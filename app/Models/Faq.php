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

    /**
     * @return array<int, array{type: string, text?: string, number?: int, ja?: string, en?: string}>
     */
    public function emergencyPhraseItems(): array
    {
        $items = [];
        $phraseNumber = 0;

        foreach (preg_split('/\r\n|\n/', $this->answer) as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (preg_match('/^【.+】$/u', $line)) {
                $items[] = ['type' => 'heading', 'text' => $line];
                continue;
            }

            if (! str_contains($line, '⇔')) {
                continue;
            }

            [$ja, $en] = array_map('trim', explode('⇔', $line, 2));
            $ja = trim(preg_replace('/^\d+\./u', '', $ja) ?? $ja);

            $phraseNumber++;

            $items[] = [
                'type'   => 'phrase',
                'number' => $phraseNumber,
                'ja'     => $ja,
                'en'     => $en,
            ];
        }

        return $items;
    }

    public function displayEmergencyHeading(string $text): string
    {
        if (app()->getLocale() !== 'en') {
            return $text;
        }

        $map = [
            '【現在地・状態】' => 'Location & Condition',
        ];

        return $map[$text] ?? $text;
    }
}
