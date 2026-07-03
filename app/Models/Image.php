<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // 画像パスを保存できるように設定
    protected $fillable = ['path'];

    // どの投稿(ItemPost)に属しているかのリレーション
    public function itemPost()
    {
        return $this->belongsTo(ItemPost::class);
    }
}