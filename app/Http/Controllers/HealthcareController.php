<?php

namespace App\Http\Controllers;

use App\Models\Hospital;

class HealthcareController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::with(['images', 'specialties'])
            ->orderBy('is_clinic')
            ->orderBy('duration_walk')
            ->get();

        $medicalOffice = new MedicalOfficeController();
        $doctorStatus = $medicalOffice->getDoctorStatus();

        $faqController = new FaqController();
        $faqCategories = $faqController->getFaqData();

        return view('healthcare.index', compact('hospitals', 'doctorStatus', 'faqCategories'));
    }
}
