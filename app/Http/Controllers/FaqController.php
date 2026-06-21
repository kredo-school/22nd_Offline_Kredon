<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqCategoryTest;
class FaqController extends Controller
{
    public function getFaqData() 
    {
    $faqCategories = FaqCategoryTest::with([
        'faqs' => function ($query) {
            $query->where('is_active', true)
                  ->orderBy('sort_order');
    }

    ])
        ->orderBy('sort_order')
        ->get();
    }
}
