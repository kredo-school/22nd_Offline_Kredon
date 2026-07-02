<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WizardController extends Controller
{
    private array $wizardData = [
        1 => [
            'question' => '海外旅行保険に加入していますか?',
            'options' => [
                'yes' => '加入している',
                'no' => '加入していない',
                'unknown' => 'わからない',
            ],
        ],
        2 => [
            'question' => 'JHDサポートを利用しますか?',
            'options' => [
                'yes' => '利用する',
                'no' => '利用しない',
            ],
        ],
        3 => [
            'question' => '現在の状況を教えてください',
            'options' => [
                'mild' => '軽い症状・相談したい',
                'hospital' => '今日病院へ行きたい',
                'emergency' => '緊急性がある',
            ],
        ],
    ];

    public function start()
    {
        session()->forget('wizard_answers');

        return redirect()->route('wizard.step', ['step' => 1]);
    }

    public function show(int $step)
    {
        if (!isset($this->wizardData[$step])) {
            abort(404);
        }

        return view('healthcare.wizard._wizard_card', [
            'step' => $step,
            'question' => $this->wizardData[$step]['question'],
            'options' => $this->wizardData[$step]['options'],
        ]);
    }

    public function store(Request $request, int $step)
    {
        if (!isset($this->wizardData[$step])) {
            abort(404);
        }

        $validOptions = array_keys($this->wizardData[$step]['options']);

        $request->validate([
            'answer' => ['required', Rule::in($validOptions)],
        ]);

        session(['wizard_answers.' . $step => $request->answer]);

        $nextStep = $step + 1;

        if ($nextStep > count($this->wizardData)) {
            return redirect()->route('wizard.result');
        }

        return redirect()->route('wizard.step', ['step' => $nextStep]);
    }

    public function result()
    {
        $answers = session('wizard_answers', []);

        if (empty($answers)) {
            return redirect()->route('wizard.start');
        }

        $hospital = $this->resolveReferenceHospital($answers);

        return view('healthcare.wizard.result', compact('answers', 'hospital'));
    }

    private function resolveReferenceHospital(array $answers): ?Hospital
    {
        $useJhd = ($answers[2] ?? null) === 'yes';
        $situation = $answers[3] ?? null;

        $query = Hospital::with(['images', 'specialties']);

        if ($situation === 'emergency') {
            return $query->where('is_jhd_supported', true)->orderBy('duration_grab')->first();
        }

        if ($useJhd && in_array($situation, ['mild', 'hospital'], true)) {
            return $query->where('is_jhd_supported', true)->orderBy('duration_grab')->first();
        }

        return $query->where('is_clinic', true)->orderBy('duration_walk')->first();
    }
}
