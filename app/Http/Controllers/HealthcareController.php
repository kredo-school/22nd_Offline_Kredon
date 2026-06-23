<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Carbon\Carbon;

class HealthcareController extends Controller
{
    public function index()
    {
        // 病院一覧取得
        $hospitals = Hospital::with('images')
            ->orderBy('is_clinic')
            ->orderBy('duration_walk')
            ->get();

        // 医師訪問状況判定

        $medicalOffice = new \App\Http\Controllers\MedicalOfficeController();
        $doctorStatus = $medicalOffice->getDoctorStatus();

        // FAQデータ（FaqControllerからデータをもらう）
        $faqController = new \App\Http\Controllers\FaqController();
        $faqCategories = $faqController->getFaqData();

        $faqCategories = \App\Models\FaqCategory::with('faqs')->get();

        return view('healthcare.index', compact('hospitals', 'doctorStatus', 'faqCategories'));
    }   
}