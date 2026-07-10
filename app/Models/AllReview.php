<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AllReview extends Model
{
    use HasFactory;
    // セキュリティー
    protected $fillable = [
        'user_id',
        'location_id',
        'rating',
        'title',
        'comment',
        'amenities',
        'customer_vibe',
        'eye_fatigue_level',
        'chair_comfort',
        'desk_stability',
    ];

    //★ 追加：DB保存時はJSON、取得時は自動でarrayに変換
    protected $casts = [
        'amenities' => 'array',
    ];

    // １つのレビューは複数の写真を持っている
    public function images()
    {
        return $this->hasMany(ReviewImage::class, 'review_id');
    }

    // user_idを外部キーとして、ユーザーテーブルとリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
