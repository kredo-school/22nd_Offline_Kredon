<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/EventParticipant.php
class EventParticipant extends Model
{
    protected $fillable = ['event_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}