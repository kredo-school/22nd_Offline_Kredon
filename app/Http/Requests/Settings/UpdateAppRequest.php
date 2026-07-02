<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'ai_recommendations'  => ['nullable'],
            'continue_learning'   => ['nullable'],
            'auto_translate'      => ['nullable'],
            'translate_language'  => ['required', Rule::in(['ja', 'en', 'tl'])],
            'data_saver'          => ['nullable'],
            'wifi_hd_only'        => ['nullable'],
            'location_accuracy'   => ['nullable'],
            'spot_priority'       => ['required', Rule::in(['popular', 'nearby', 'recent'])],
            'map_priority'        => ['required', Rule::in(['spot', 'event', 'mixed'])],
        ];
    }
}
