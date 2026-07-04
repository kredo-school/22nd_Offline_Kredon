<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDisplayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'color_mode'   => ['required', Rule::in(['light', 'dark', 'system'])],
            'character_id' => ['required', Rule::exists('character_temps', 'slug')],
        ];
    }
}
