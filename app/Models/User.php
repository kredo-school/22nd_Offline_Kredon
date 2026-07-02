<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Review;
use App\Models\Spot;
use App\Models\TouristSpot;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ユーザーが書いたレビューを引っ張るための電線
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 標準の Notifiable::notifications() と名前が衝突するため appNotifications にしています
    public function appNotifications(): HasMany
    {
        // FIXME: Gitの衝突でAimiさんのコードの中身が消失していたため仮置きしています
        return $this->hasMany(\App\Models\Notification::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Spot::class, 'bookmarks')->withTimestamps();
    }

    // 🌟 追加：学習スポット（Spot）とのお気に入り（bookmarksテーブル）の繋がり
    public function bookmarkedStudySpots()
    {
        return $this->belongsToMany(Spot::class, 'bookmarks', 'user_id', 'spot_id')->withTimestamps();
    }

    // 🌟 ユーザーが保存した観光スポット一覧を取得
    public function bookmarkedTouristSpots()
    {
        // tourist_bookmarks テーブルを中間テーブルとして、TouristSpot モデルを結びつける
        return $this->belongsToMany(TouristSpot::class, 'tourist_bookmarks', 'user_id', 'tourist_spot_id')->withTimestamps();
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}
public function joinedEvents()
{
    return $this->belongsToMany(
        Event::class,
        'event_participants'
    );
}
}