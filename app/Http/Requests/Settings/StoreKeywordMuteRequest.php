<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKeywordMuteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'keyword' => [
                'required',
                'string',
                'max:50',
                Rule::unique('user_keyword_mutes', 'keyword')->where('user_id', auth()->id()),
            ],
        ];
    }
}
