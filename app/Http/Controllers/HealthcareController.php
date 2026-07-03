<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Services\WizardService;
use Illuminate\Http\Request;

class HealthcareController extends Controller
{
    public function __construct(
        private readonly WizardService $wizard
    ) {}

    public function index(Request $request)
    {
        $hospitals = Hospital::with(['images', 'specialties'])
            ->orderBy('is_clinic')
            ->orderBy('duration_walk')
            ->get();

        $medicalOffice = new MedicalOfficeController();
        $medicalOfficeStatus = $medicalOffice->getMedicalOfficeStatus();

        $faqController = new FaqController();
        $faqCategories = $faqController->getFaqData();

        if ($request->has('wizard_back')) {
            $backTo = max(1, (int) $request->query('wizard_back'));
            $this->wizard->clearAnswersFromStep($backTo);

            return redirect()->to(route('healthcare.index') . '#search-section');
        }

        $answers = $this->wizard->getAnswers();

        if ($this->wizard->isComplete($answers) && !$request->boolean('from_result')) {
            return redirect()->route('wizard.result');
        }

        $step = $this->wizard->resolveDisplayStep($answers);
        if ($this->wizard->isComplete($answers) && $request->boolean('from_result')) {
            $step = $this->wizard->totalSteps();
        }

        $wizardStep = $this->wizard->getStepData($step, $answers);
        $selectedAnswer = $answers[$step] ?? null;

        return view('healthcare.index', compact(
            'hospitals',
            'medicalOfficeStatus',
            'faqCategories',
            'wizardStep',
            'selectedAnswer',
        ));
    }
}
