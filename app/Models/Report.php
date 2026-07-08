<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'message_id',
        'group_message_id',
        'reason',
        'resolved',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function groupMessage()
    {
        return $this->belongsTo(GroupMessage::class);
    }
}