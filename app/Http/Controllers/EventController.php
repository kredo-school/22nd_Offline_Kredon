<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
 public function index()
{
    $query = Event::whereDate('event_date', '>=', today())
                  ->latest();

    if (request('category')) {
        $query->where('category', request('category'));
    }

    $events = $query->get();

    return view('event.index', compact('events'));
}

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|max:255',
            'description' => 'required',
            'location' => 'nullable|max:255',
            'event_date' => 'required|date',

            'image1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image1')) {
            $validated['image1'] = $request->file('image1')->store('events', 'public');
        }

        if ($request->hasFile('image2')) {
            $validated['image2'] = $request->file('image2')->store('events', 'public');
        }

        $validated['user_id'] = auth()->id();

        Event::create($validated);

        return redirect()->route('event.index')
            ->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
{
  $event->load([
    'user',
    'comments.user',
    'participants:id,name'
]);
    $joined = auth()->check()
        ? $event->participants->contains(auth()->id())
        : false;

    $expired = now()->gt(\Carbon\Carbon::parse($event->event_date));

return view('event.show', compact(
    'event',
    'joined',
    'expired'
));
}
    public function edit(Event $event)
    {
        if ($event->user_id != auth()->id()) {
            abort(403);
        }

        return view('event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|max:255',
            'description' => 'required',
            'location' => 'nullable|max:255',
            'event_date' => 'required|date',

            'image1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image1')) {

            if ($event->image1) {
                Storage::disk('public')->delete($event->image1);
            }

            $validated['image1'] =
                $request->file('image1')->store('events', 'public');
        }

        if ($request->hasFile('image2')) {

            if ($event->image2) {
                Storage::disk('public')->delete($event->image2);
            }

            $validated['image2'] =
                $request->file('image2')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()
            ->route('event.show', $event->id)
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id != auth()->id()) {
            abort(403);
        }

        if ($event->image1) {
            Storage::disk('public')->delete($event->image1);
        }

        if ($event->image2) {
            Storage::disk('public')->delete($event->image2);
        }

        $event->delete();

        return redirect()
            ->route('event.index')
            ->with('success', 'Event deleted successfully!');
    }
    public function participants(Event $event)
{
    $participants = $event->participants()->paginate(20);

    return view('event.participants', compact(
        'event',
        'participants'
    ));
}
}