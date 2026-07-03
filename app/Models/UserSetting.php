<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'color_mode',
        'character_temp_id',
        'allow_comments',
        'pre_approval',
        'ng_word_filter',
        'ng_word_strength',
        'spam_detection',
        'ai_moderation',
        'notification_settings',
        'privacy_settings',
        'app_settings',
    ];

    protected function casts(): array
    {
        return [
            'allow_comments'        => 'boolean',
            'pre_approval'          => 'boolean',
            'ng_word_filter'        => 'boolean',
            'spam_detection'        => 'boolean',
            'ai_moderation'         => 'boolean',
            'notification_settings' => 'array',
            'privacy_settings'      => 'array',
            'app_settings'          => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function characterTemp(): BelongsTo
    {
        return $this->belongsTo(CharacterTemp::class);
    }
}
