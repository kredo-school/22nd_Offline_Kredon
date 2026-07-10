<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLogin
{
    public function handle(Login $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        $user->forceFill([
            'last_login_at' => now(),
            'login_count'   => $user->login_count + 1,
        ])->saveQuietly();
    }
}