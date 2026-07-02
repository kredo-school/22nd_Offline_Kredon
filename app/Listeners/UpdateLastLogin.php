<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLogin
{
    public function handle(Login $event): void
    {
        $event->user->forceFill([
            'last_login_at' => now(),
            'login_count' => $event->user->login_count + 1,
        ])->saveQuietly();
        // saveQuietly: updated_at の更新イベントを発火させず、モデルの他のイベントリスナーにも影響を与えない
    }
}