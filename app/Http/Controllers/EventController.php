<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $query = Event::latest();

        if (request('category')) {
            $query->where(
                'category',
                request('category')
            );
        }

        $events = $query->get();

        return view(
            'event.index',
            compact('events')
        );
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required',
            'event_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] =
                $request->file('image')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()
            ->route('event.index')
            ->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        return view(
            'event.show',
            compact('event')
        );
    }
}