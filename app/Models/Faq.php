<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    protected $fillable = ['faq_category_id', 'question', 'question_en', 'answer', 'answer_en', 'is_active', 'sort_order'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    public function displayQuestion(): string
    {
        if (app()->getLocale() === 'en' && $this->question_en) {
            return $this->question_en;
        }

        return $this->question;
    }

    public function displayAnswer(): string
    {
        if (app()->getLocale() === 'en' && $this->answer_en) {
            return $this->answer_en;
        }

        return $this->answer;
    }
}
