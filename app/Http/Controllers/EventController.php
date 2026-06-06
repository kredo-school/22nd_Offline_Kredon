<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // イベントを日付の近い順に取得
        $events = Event::orderBy('start_date', 'asc')->get();

        return view('event.index', compact('events'));
    }
}
