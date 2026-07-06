<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'allow_comments'   => ['nullable'],
            'pre_approval'     => ['nullable'],
            'ng_word_filter'   => ['nullable'],
            'ng_word_strength' => ['required', Rule::in(['low', 'standard', 'high'])],
            'spam_detection'   => ['nullable'],
            'ai_moderation'    => ['nullable'],
        ];
    }
}
