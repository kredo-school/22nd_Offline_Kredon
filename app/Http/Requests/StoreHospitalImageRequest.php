<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // この操作を許可するかどうか（とりあえずtrue）
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    //* ここに「ルールのチェック項目」を記述 *//
    public function rules(): array
    {
        return [
            'image' => 'required|image|mines:jpeg,png,jpg|max:2048',
        ];
    }
}
