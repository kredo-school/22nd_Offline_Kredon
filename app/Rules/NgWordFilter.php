<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NgWordFilter implements ValidationRule
{
    // クラスのプロパティはここに書くのが正解です
    protected $moderationList = [
        'harassment' => ['kill yourself', 'stupid', 'idiot', '死ね', 'バカ'],
        'spam'       => ['line.me', 'add me on line', 'click here', 'ライン交換']
    ];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 大文字・小文字を区別しないために小文字へ変換
        $inputText = mb_strtolower($value);

        foreach ($this->moderationList as $category => $words) {
            foreach ($words as $word) {
                
                // 入力テキストの中にNGワードが含まれているかチェック
                if (mb_strpos($inputText, mb_strtolower($word)) !== false) {
                   $fail("不適切な表現が含まれています（{$category}）。");
                    return;
                }
            }
        }
    }
}