<?php

namespace App\Http\Controllers;

use App\Services\WizardService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WizardController extends Controller
{
    public function __construct(
        private readonly WizardService $wizard
    ) {}

    public function start()
    {
        $this->wizard->clearWizardSession();

        return $this->redirectToHealthcareWizard();
    }

    public function show(int $step)
    {
        if (!$this->wizard->stepExists($step)) {
            abort(404);
        }

        return $this->redirectToHealthcareWizard();
    }

    public function store(Request $request, int $step)
    {
        $this->wizard->syncSession();

        if (!$this->wizard->stepExists($step)) {
            abort(404);
        }

        $stepData = $this->wizard->getStepData($step);

        $request->validate([
            'answer' => ['required', Rule::in($stepData['optionKeys'])],
        ]);

        session(['wizard_answers.' . $step => $request->answer]);
        session(['wizard_version' => $this->wizard->configVersion()]);

        $answers = $this->wizard->getAnswers();

        if ($this->wizard->isEarlyComplete($answers)) {
            $this->wizard->clearAnswersFromStep(2);

            return redirect()->to(route('healthcare.index') . '#wizard-result');
        }

        if ($this->wizard->isComplete($answers)) {
            return redirect()->to(route('healthcare.index') . '#wizard-result');
        }

        return $this->redirectToHealthcareWizard();
    }

    public function result()
    {
        $this->wizard->syncSession();

        $answers = $this->wizard->getAnswers();

        if (!$this->wizard->isComplete($answers)) {
            return $this->redirectToHealthcareWizard();
        }

        return redirect()->to(route('healthcare.index') . '#wizard-result');
    }

    private function redirectToHealthcareWizard()
    {
        return redirect()->to(route('healthcare.index') . '#search-section');
    }
}
