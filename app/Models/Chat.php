<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'type',
        'event_id',
        'user_one_id',
        'user_two_id',
    ];

    // メッセージ
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // 個人チャット相手①
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    // 個人チャット相手②
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    // グループチャット用イベント
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function unreadCount()
{
    return $this->messages()
        ->where('user_id','!=',auth()->id())
        ->where('is_read',false)
        ->count();
}
}