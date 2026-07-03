<?php

namespace App\Http\Requests\Settings;

use App\Rules\NgWordFilter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name'                  => ['sometimes', 'string', 'max:50'],
            'username'              => ['sometimes', 'string', 'max:30', 'alpha_dash', Rule::unique('users', 'username')->ignore($userId)],
            'bio'                   => ['sometimes', 'nullable', 'string', 'max:200', new NgWordFilter(auth()->user())],
            'email'                 => ['sometimes', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'avatar'                => ['sometimes', 'nullable', 'image', 'max:2048'],
            'current_password'      => ['required_with:password', 'current_password'],
            'password'              => ['sometimes', 'nullable', 'confirmed', Password::defaults()],
            'password_confirmation' => ['nullable'],
        ];
    }
}
