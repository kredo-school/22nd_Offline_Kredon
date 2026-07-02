<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Review;
use App\Models\Spot;
use App\Models\TouristSpot;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function appNotifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Spot::class, 'bookmarks')->withTimestamps();
    }

    public function bookmarkedStudySpots()
    {
        return $this->belongsToMany(Spot::class, 'bookmarks', 'user_id', 'spot_id')->withTimestamps();
    }

    public function bookmarkedTouristSpots()
    {
        return $this->belongsToMany(TouristSpot::class, 'tourist_bookmarks', 'user_id', 'tourist_spot_id')->withTimestamps();
    }
}
