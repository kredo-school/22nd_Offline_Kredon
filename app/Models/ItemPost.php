<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPost extends Model
{
    // データベースへの一括代入を許可するカラムを定義
    protected $fillable = [
    'user_id',
    'title',
    'description',
    'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
