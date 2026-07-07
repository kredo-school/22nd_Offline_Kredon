<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $fillable = [
        'group_chat_id',
        'user_id',
        'message',
          'group_chat_id',

    'user_id',

    'message',

    'is_read',

    ];

   public function user()
{
    return $this->belongsTo(User::class);
}

    public function chat()
    {
        return $this->belongsTo(GroupChat::class,'group_chat_id');
    }
    
}