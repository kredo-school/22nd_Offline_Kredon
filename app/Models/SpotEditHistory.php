<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotEditHistory extends Model
{
    use HasFactory;

    // 保存を許可する箱
    protected $fillable = ['spot_id', 'user_id'];

    // ユーザー情報と連携（管理画面で名前を出すため）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}