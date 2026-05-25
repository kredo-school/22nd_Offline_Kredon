<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ItemPost extends Model
{
    // データベースに保存できるようにする許可設定
    protected $fillable = ['user_id', 'title', 'description', 'status', 'location_name'];

    // 1つの投稿に複数枚の画像が持てるようにする設定
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}