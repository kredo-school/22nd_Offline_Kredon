<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Review;
use App\Models\Spot;
use App\Models\TouristSpot;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ユーザーが書いたレビューを引っ張るための電線
    public function reviews()
    {
        return $this->hasMany(Review::class);
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
}