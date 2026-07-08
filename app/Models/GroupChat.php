<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    protected $fillable = [
        'event_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function messages()
    {
        return $this->hasMany(GroupMessage::class);
    }
}