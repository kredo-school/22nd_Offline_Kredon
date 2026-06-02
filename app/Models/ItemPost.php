<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPost extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'status', 'location_name', 'category'];

    // 1つの投稿が複数の画像を持つ
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}