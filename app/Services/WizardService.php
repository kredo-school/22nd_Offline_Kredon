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
        foreach ($stepConfig['options'] as $value => $labelKey) {
            $options[$value] = __($labelKey);
        }

        return [
            'step' => $step,
            'totalSteps' => $this->totalSteps(),
            'question' => __($stepConfig['question']),
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
        $query = Hospital::with(['images', 'specialties']);

        if (($answers[1] ?? null) === 'mild') {
            return $query->where('short_name', 'Maxicare')->first();
        }

        return $query->where('short_name', 'Cebu Doc')->first();
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

        if (($answers[1] ?? null) === 'mild') {
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
