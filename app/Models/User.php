<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'bio',
        'role',
        'two_factor_enabled',
        'two_factor_secret',
        'posts_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'two_factor_enabled'   => 'boolean',
            'two_factor_secret'    => 'encrypted',
            'posts_count'          => 'integer',
        ];
    }

    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    public function ngWords(): HasMany
    {
        return $this->hasMany(UserNgWord::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(UserBlock::class);
    }

    public function keywordMutes(): HasMany
    {
        return $this->hasMany(UserKeywordMute::class);
    }

    public function isPremium(): bool
    {
        return (int) $this->role === 3;
    }

    public function avatarUrl(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        return str_starts_with($this->avatar, 'http')
            ? $this->avatar
            : asset('storage/' . ltrim($this->avatar, '/'));
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class, 'recipient_id');
    }

    public function unreadAppNotifications(): HasMany
    {
        return $this->appNotifications()->where('is_read', false);
    }

    public function notificationSubscriptions(): HasMany
    {
        return $this->hasMany(\App\Models\NotificationSubscription::class);
    }
}
