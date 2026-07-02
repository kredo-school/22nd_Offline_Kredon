<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Chat;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'location',
        'event_date',
        'image1',
        'image2',
    ];

    // 投稿者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // 参加者
    public function participants()
    {
        return $this->belongsToMany(
            User::class,
            'event_participants'
        );
    }

    // グループチャット
    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    // イベント終了判定
    public function getExpiredAttribute()
    {
        return now()->gt($this->event_date);
    }
    
}