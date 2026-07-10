<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristReview extends Model
{
    // 保存を許可するカラム
    protected $fillable = ['tourist_spot_id', 'user_id', 'rating', 'comment'];

    // このクチコミを書いたユーザーの情報を取得できるようにする
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function touristSpot()
    {
        return $this->belongsTo(TouristSpot::class, 'tourist_spot_id');
    }
}
