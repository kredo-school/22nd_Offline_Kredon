<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
  public function index(User $user)
{
    $chat = Chat::firstOrCreate([
        'user_one_id' => auth()->id(),
        'user_two_id' => $user->id,
    ]);

    return redirect()->route('chat.show', $chat->id);
}
    public function show(Chat $chat)
    {
        $chat->load('messages');

        return view('chat.show', compact('chat'));
    }

    public function send(Request $request, Chat $chat)
    {
        Message::create([
            'chat_id' => $chat->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back();
    }
 public function store(Request $request)
{
    $receiverId = $request->receiver_id;

    $chat = Chat::where(function ($q) use ($receiverId) {

        $q->where('user_one_id', auth()->id())
          ->where('user_two_id', $receiverId);

    })->orWhere(function ($q) use ($receiverId) {

        $q->where('user_one_id', $receiverId)
          ->where('user_two_id', auth()->id());

    })->first();

    if (!$chat) {

        $chat = Chat::create([
            'user_one_id' => auth()->id(),
            'user_two_id' => $receiverId,
        ]);
    }

    return redirect()->route('chat.show', $chat->id);
}

    public function list()
{
    $userId = auth()->id();

    $chats = Chat::where('user_one_id',$userId)
        ->orWhere('user_two_id',$userId)
        ->latest()
        ->get();

    return view('chat.list',compact('chats'));
}
    
}