<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'comment' => 'required|max:1000'
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment posted!');
    }
    public function destroy(Comment $comment)
{
    if ($comment->user_id != auth()->id()) {
        abort(403);
    }

    $comment->delete();

    return back();
}
}