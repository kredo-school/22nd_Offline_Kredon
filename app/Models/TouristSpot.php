<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristSpot extends Model
{
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
}
