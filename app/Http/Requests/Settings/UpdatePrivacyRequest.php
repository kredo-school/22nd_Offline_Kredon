<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePrivacyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $visibility = Rule::in(['public', 'members', 'private']);
        $dm         = Rule::in(['all', 'members', 'none']);

        return [
            'private_account'      => ['nullable'],
            'show_online'          => ['nullable'],
            'show_activity'        => ['nullable'],
            'post_visibility'      => ['required', $visibility],
            'review_visibility'    => ['required', $visibility],
            'show_bookmarks'       => ['nullable'],
            'show_browsing'        => ['nullable'],
            'disable_location'     => ['nullable'],
            'approximate_location' => ['nullable'],
            'location_visibility'  => ['required', $visibility],
            'dm_setting'           => ['required', $dm],
            'show_in_search'       => ['nullable'],
        ];
    }
}
