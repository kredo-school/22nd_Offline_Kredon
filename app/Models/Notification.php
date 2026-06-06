<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    
    // ★このプロパティを追加！
    public $timestamps = false;
    
    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'event_id',
        'type',
        'title',
        'message',
        'link_url',
        'image_url',
        'is_read',
        'created_at',
    ];

    // ユーザーとのリレーション設定（必要に応じて）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
