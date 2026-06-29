<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    // 🌟 保存を許可するカラム
    protected $fillable = ['user_id', 'spot_id'];

    /*
    |--------------------------------------------------------------------------
    | 🔗 繋ぎ込み（リレーション設定）
    |--------------------------------------------------------------------------
    */
    // このお気に入りは「どのユーザー」のものか？
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // このお気に入りは「どのスポット」につけられたものか？
    public function spot()
    {
        return $this->belongsTo(Spot::class);
    }
}