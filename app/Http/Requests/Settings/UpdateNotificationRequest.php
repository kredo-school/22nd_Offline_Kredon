<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'notify_comment' => ['nullable'],
            'notify_event'   => ['nullable'],
            'notify_market'  => ['nullable'],
            'notify_premium' => ['nullable'],
            'channel_push'   => ['nullable'],
            'channel_email'  => ['nullable'],
        ];
    }
}
