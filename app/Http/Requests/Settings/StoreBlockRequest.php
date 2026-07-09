<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBlockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:30',
                Rule::exists('users', 'username')->whereNot('id', auth()->id()),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.exists' => 'The specified user was not found.',
        ];
    }
}
