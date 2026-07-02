<?php

namespace App\Rules;

use App\Models\User;
use App\Services\NgWordService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NgWordFilter implements ValidationRule
{
    public function __construct(protected ?User $user = null) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || trim($value) === '') {
            return;
        }

        app(NgWordService::class)->validateText($value, $this->user ?? auth()->user(), $fail);
    }
}
