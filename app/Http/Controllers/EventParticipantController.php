<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    public function join(Event $event)
    {
        $event->participants()->syncWithoutDetaching([
            auth()->id()
        ]);

        return back();
    }

    public function leave(Event $event)
    {
        $event->participants()->detach(
            auth()->id()
        );

        return back();
    }
}