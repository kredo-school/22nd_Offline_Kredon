<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserNgWordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'word' => [
                'required',
                'string',
                'max:100',
                Rule::unique('user_ng_words', 'word')->where('user_id', auth()->id()),
            ],
        ];
    }
}
