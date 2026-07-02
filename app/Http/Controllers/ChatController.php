<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // =========================
    // チャット一覧
    // =========================
    public function list()
    {
        $userId = auth()->id();

        $chats = Chat::where(function ($q) use ($userId) {
                $q->where('user_one_id', $userId)
                  ->orWhere('user_two_id', $userId);
            })
            ->with([
                'messages' => function ($q) {
                    $q->latest();
                },
                'userOne',
                'userTwo'
            ])
            ->withCount([
                'messages as unread_count' => function ($q) {
                    $q->where('user_id', '!=', auth()->id())
                      ->where('is_read', false);
                }
            ])
            ->get()
            ->sortByDesc(function ($chat) {
                return optional($chat->messages->first())->created_at;
            });

        return view('chat.list', compact('chats'));
    }

    // =========================
    // 個人チャット開始
    // =========================
    public function private(User $user)
    {
        abort_if($user->id == auth()->id(), 403);

        $userOne = min(auth()->id(), $user->id);
        $userTwo = max(auth()->id(), $user->id);

        $chat = Chat::firstOrCreate([
            'user_one_id' => $userOne,
            'user_two_id' => $userTwo,
        ]);

        return redirect()->route('chat.show', $chat);
    }

    // =========================
    // 個人チャット表示
    // =========================
    public function show(Chat $chat)
{
    // デバッグ
    dd([
        'login_user' => auth()->id(),
        'chat_id'    => $chat->id,
        'user_one'   => $chat->user_one_id,
        'user_two'   => $chat->user_two_id,
    ]);

    abort_unless(
        in_array(auth()->id(), [
            $chat->user_one_id,
            $chat->user_two_id
        ]),
        403
    );

    $chat->messages()
        ->where('user_id', '!=', auth()->id())
        ->where('is_read', false)
        ->update([
            'is_read' => true
        ]);

    $chat->load([
        'messages' => function ($q) {
            $q->orderBy('created_at', 'asc');
        },
        'messages.user',
        'userOne',
        'userTwo'
    ]);

    return view('chat.show', compact('chat'));
}

    // =========================
    // 個人チャット送信
    // =========================
    public function send(Request $request, Chat $chat)
    {
        abort_unless(
            in_array(auth()->id(), [
                $chat->user_one_id,
                $chat->user_two_id
            ]),
            403
        );

        $request->validate([
            'message' => 'required|max:1000'
        ]);

        Message::create([
            'chat_id' => $chat->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('chat.show', $chat);
    }

    // =========================
    // イベントグループチャット
    // =========================
    public function group(Event $event)
    {
        abort_unless(
            $event->participants()
                ->where('user_id', auth()->id())
                ->exists(),
            403
        );

        $chat = Chat::firstOrCreate([
            'type' => 'group',
            'event_id' => $event->id,
        ]);

        $chat->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true
            ]);

        $chat->load([
            'messages' => function ($q) {
                $q->orderBy('created_at', 'asc');
            },
            'messages.user'
        ]);

        return view('chat.group', compact(
            'chat',
            'event'
        ));
    }
}