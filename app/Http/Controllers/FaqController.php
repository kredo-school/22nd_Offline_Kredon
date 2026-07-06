<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;

class FaqController extends Controller
{
    public function getFaqData()
    {
        return FaqCategory::with([
            'faqs' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order');
            },
        ])
            ->orderBy('sort_order')
            ->get();
    }
}
