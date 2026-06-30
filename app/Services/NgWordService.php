<?php

namespace App\Services;

use App\Models\NgWord;
use App\Models\User;
use App\Models\UserNgWord;
use Closure;
use Illuminate\Support\Collection;

class NgWordService
{
    protected const STRENGTH_LEVELS = [
        'low'      => 1,
        'standard' => 2,
        'high'     => 3,
    ];

    public function validateText(string $value, ?User $user, Closure $fail): void
    {
        if ($user) {
            $user->loadMissing('settings');
            if ($user->settings && ! $user->settings->ng_word_filter) {
                return;
            }
        }

        $strength = $user?->settings?->ng_word_strength ?? 'standard';
        $words    = $this->wordsForUser($user, $strength);

        $inputText = mb_strtolower($value);

        foreach ($words as $entry) {
            $word = mb_strtolower($entry['word']);
            if ($word !== '' && mb_strpos($inputText, $word) !== false) {
                $category = $entry['category'] ?? 'general';
                $fail("不適切な表現が含まれています（{$category}）。");

                return;
            }
        }
    }

    public function wordsForUser(?User $user, string $strength = 'standard'): Collection
    {
        $minLevel = self::STRENGTH_LEVELS[$strength] ?? 2;

        $systemWords = NgWord::query()
            ->where('is_active', true)
            ->get()
            ->filter(function (NgWord $word) use ($minLevel) {
                $wordLevel = self::STRENGTH_LEVELS[$word->min_strength] ?? 1;

                return $wordLevel <= $minLevel;
            })
            ->map(fn (NgWord $w) => ['word' => $w->word, 'category' => $w->category]);

        if (! $user) {
            return $systemWords;
        }

        $userWords = UserNgWord::query()
            ->where('user_id', $user->id)
            ->get()
            ->map(fn (UserNgWord $w) => ['word' => $w->word, 'category' => 'custom']);

        return $systemWords->merge($userWords);
    }
}
