<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristSpot extends Model
{
       
        protected $fillable = [
            'user_id',
            'name',
            'area',
            'hours',
            'status',
        'budget',
        'photo_path',
        'has_activity',
        'has_view',
        'has_shopping',
        'has_food',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // このスポットがお気に入り登録されているか判定するメソッド
    public function isBookmarkedBy($user)
    {
        if (!$user) return false;
        return TouristBookmark::where('user_id', $user->id)
            ->where('tourist_spot_id', $this->id)
            ->exists();
    }
    // この観光スポットに紐づくクチコミ一覧を取得
    public function reviews()
    {
        return $this->hasMany(TouristReview::class);
    }
    // 🌟 これを追記！：お気に入り（保存）数を数えるための設定
    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'tourist_bookmarks', 'tourist_spot_id', 'user_id');
    }
}
