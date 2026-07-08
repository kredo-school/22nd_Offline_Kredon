<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\Hospital;

class WizardService
{
    public function configVersion(): string
    {
        return (string) config('wizard.version', '1');
    }

    public function syncSession(): void
    {
        $configVersion = $this->configVersion();

        if (session('wizard_version') !== $configVersion) {
            session()->forget('wizard_answers');
            session(['wizard_version' => $configVersion]);

            return;
        }

        $answers = session('wizard_answers', []);

        if ($answers !== [] && !$this->answersAreValid($answers)) {
            session()->forget('wizard_answers');
        }
    }

    public function getAnswers(): array
    {
        $this->syncSession();

        return session('wizard_answers', []);
    }

    public function clearWizardSession(): void
    {
        session()->forget('wizard_answers');
        session(['wizard_version' => $this->configVersion()]);
    }

    public function answersAreValid(array $answers): bool
    {
        if ($answers === []) {
            return true;
        }

        $expectedStep = 1;

        foreach ($answers as $step => $answer) {
            $step = (int) $step;

            if ($step !== $expectedStep || !$this->stepExists($step)) {
                return false;
            }

            $optionKeys = array_keys(config("wizard.steps.{$step}.options", []));

            if (!in_array($answer, $optionKeys, true)) {
                return false;
            }

            $expectedStep++;
        }

        if ($this->isEarlyComplete($answers) && count($answers) !== 1) {
            return false;
        }

        return true;
    }

    public function totalSteps(): int
    {
        return count(config('wizard.steps', []));
    }

    public function stepExists(int $step): bool
    {
        return isset(config('wizard.steps')[$step]);
    }

    public function getStepData(int $step, array $answers = []): array
    {
        $stepConfig = config("wizard.steps.{$step}");

        if (!$stepConfig) {
            abort(404);
        }

        $options = [];
        foreach ($stepConfig['options'] as $value => $optionConfig) {
            if (is_string($optionConfig)) {
                $options[$value] = [
                    'label' => __($optionConfig),
                    'subtitle' => null,
                ];
            } else {
                $options[$value] = [
                    'label' => __($optionConfig['label']),
                    'subtitle' => isset($optionConfig['subtitle']) ? __($optionConfig['subtitle']) : null,
                ];
            }
        }

        return [
            'step' => $step,
            'totalSteps' => $this->totalSteps(),
            'question' => __($stepConfig['question']),
            'subtitle' => isset($stepConfig['subtitle']) ? __($stepConfig['subtitle']) : null,
            'options' => $options,
            'optionKeys' => array_keys($stepConfig['options']),
            'infoOptions' => $this->resolveInfoOptions($stepConfig['info_options'] ?? [], $answers),
        ];
    }

    private function resolveInfoOptions(array $infoOptionsConfig, array $answers): array
    {
        $infoOptions = [];

        foreach ($infoOptionsConfig as $key => $infoConfig) {
            if (isset($infoConfig['show_when'])) {
                $conditionStep = (int) $infoConfig['show_when']['step'];
                $conditionAnswer = $infoConfig['show_when']['answer'];

                if (($answers[$conditionStep] ?? null) !== $conditionAnswer) {
                    continue;
                }
            }

            $faq = $this->resolveFaq(
                $infoConfig['faq_category_slug'],
                $infoConfig['faq_sort_order']
            );

            if (!$faq) {
                continue;
            }

            $infoOptions[] = [
                'key' => $key,
                'label' => __($infoConfig['label']),
                'hint' => isset($infoConfig['hint'])
                    ? __($infoConfig['hint'])
                    : __('healthcare.wizard.info_hint'),
                'question' => $faq->displayQuestion(),
                'answer' => $faq->displayAnswer(),
            ];
        }

        return $infoOptions;
    }

    public function resolveFaq(string $categorySlug, int $sortOrder): ?Faq
    {
        return Faq::query()
            ->where('is_active', true)
            ->where('sort_order', $sortOrder)
            ->whereHas('category', fn ($query) => $query->where('slug', $categorySlug))
            ->first();
    }

    public function isEarlyComplete(array $answers): bool
    {
        foreach (config('wizard.early_complete', []) as $step => $optionKeys) {
            if (in_array($answers[$step] ?? null, $optionKeys, true)) {
                return true;
            }
        }

        return false;
    }

    public function isComplete(array $answers): bool
    {
        if ($this->isEarlyComplete($answers)) {
            return true;
        }

        return count($answers) >= $this->totalSteps();
    }

    public function resolveDisplayStep(array $answers): int
    {
        return min(count($answers) + 1, $this->totalSteps());
    }

    public function clearAnswersFromStep(int $fromStep): void
    {
        for ($i = $fromStep; $i <= $this->totalSteps(); $i++) {
            session()->forget("wizard_answers.{$i}");
        }
    }

    public function resolveReferenceHospital(array $answers): ?Hospital
    {
        $items = $this->resolveResultItems($answers);

        return $items[0]['hospital'] ?? null;
    }

    public function resolveResultItems(array $answers): array
    {
        if ($this->isEarlyComplete($answers)) {
            $hospital = Hospital::with(['images', 'specialties'])
                ->where('short_name', 'Maxicare')
                ->first();

            if (!$hospital) {
                return [];
            }

            return [[
                'hospital' => $hospital,
                'pros' => $this->resolveRecommendationReasons($answers, $hospital),
                'notes' => [],
            ]];
        }

        $order = ['Cebu Doc', 'Chong Hua Mandaue'];

        return Hospital::with(['images', 'specialties'])
            ->whereIn('short_name', $order)
            ->get()
            ->sortBy(fn (Hospital $hospital) => array_search($hospital->short_name, $order, true))
            ->map(fn (Hospital $hospital) => [
                'hospital' => $hospital,
                'pros' => $this->resolveHospitalPros($hospital, $answers),
                'notes' => $this->resolveHospitalNotes($hospital),
            ])
            ->values()
            ->all();
    }

    public function usesPartnerComparison(array $answers): bool
    {
        return !$this->isEarlyComplete($answers);
    }

    private function resolveHospitalPros(Hospital $hospital, array $answers): array
    {
        $keys = $this->comparisonContentKeys($hospital->short_name)['pros'] ?? [];

        if (($answers[3] ?? null) === 'no') {
            $keys = array_values(array_filter(
                $keys,
                fn (string $key) => !str_contains($key, '.pros.jhd') && !str_contains($key, '.pros.cashless')
            ));
        }

        return array_map(fn (string $key) => __($key), $keys);
    }

    private function resolveHospitalNotes(Hospital $hospital): array
    {
        $keys = $this->comparisonContentKeys($hospital->short_name)['notes'] ?? [];

        return array_map(fn (string $key) => __($key), $keys);
    }

    private function comparisonContentKeys(string $shortName): array
    {
        $partnerPros = [
            'healthcare.wizard.compare.pros.medical_office',
            'healthcare.wizard.compare.cebu_doc.pros.jhd',
            'healthcare.wizard.compare.cebu_doc.pros.japanese',
            'healthcare.wizard.compare.cebu_doc.pros.cashless',
        ];

        return match ($shortName) {
            'Cebu Doc' => [
                'pros' => $partnerPros,
                'notes' => [
                    'healthcare.wizard.compare.cebu_doc.notes.traffic',
                    'healthcare.wizard.compare.cebu_doc.notes.building',
                ],
            ],
            'Chong Hua Mandaue' => [
                'pros' => $partnerPros,
                'notes' => [
                    'healthcare.wizard.compare.chong_hua.notes.jhd_floor',
                ],
            ],
            default => ['pros' => [], 'notes' => []],
        };
    }

    public function resolveRecommendationReason(array $answers): ?string
    {
        $reasons = $this->resolveRecommendationReasons($answers, $this->resolveReferenceHospital($answers));

        return $reasons[0] ?? null;
    }

    public function resolveRecommendationReasons(array $answers, ?Hospital $hospital): array
    {
        if (!$hospital) {
            return [];
        }

        $reasons = [];

        if ($this->isEarlyComplete($answers)) {
            $reasons[] = __('healthcare.wizard.reason_medical_office');

            if ($hospital->duration_walk) {
                $reasons[] = __('healthcare.wizard.reason_walk', ['minutes' => $hospital->duration_walk]);
            }

            return $reasons;
        }

        if ($hospital->is_jhd_supported && ($answers[3] ?? null) === 'yes') {
            $reasons[] = __('healthcare.wizard.reason_jhd');
            $reasons[] = __('healthcare.wizard.reason_cashless');
            $reasons[] = __('healthcare.wizard.reason_japanese_support');
        }

        if ($hospital->is_24_hours) {
            $reasons[] = __('healthcare.wizard.reason_open_hours');
        }

        if ($hospital->duration_grab) {
            $reasons[] = __('healthcare.wizard.reason_grab', ['minutes' => $hospital->duration_grab]);
        }

        return $reasons;
    }

    public function shouldShowJhdDocuments(array $answers, ?Hospital $hospital): bool
    {
        if (!$hospital || $hospital->short_name !== 'Cebu Doc') {
            return false;
        }

        return ($answers[2] ?? null) === 'yes';
    }
}
