<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GroupChat;
use App\Models\GroupMessage;
use Illuminate\Http\Request;

class GroupChatController extends Controller
{
    // ==========================
    // グループチャット表示
    // ==========================
    public function show(Event $event)
    {
        // イベント参加者のみ
        abort_unless(
            $event->participants()
                ->where('user_id', auth()->id())
                ->exists(),
            403
        );

        $chat = GroupChat::firstOrCreate([
            'event_id' => $event->id,
        ]);
$chat->messages()
    ->where('user_id','!=',auth()->id())
    ->where('is_read',false)
    ->update([
        'is_read'=>true
    ]);
        $chat->load([
            'messages' => function ($q) {
                $q->orderBy('created_at', 'asc');
            },
            'messages.user'
        ]);

        return view('groupchat.show', compact(
            'event',
            'chat'
        ));
    }

    // ==========================
    // メッセージ送信
    // ==========================
    public function send(Request $request, Event $event)
    {
        abort_unless(
            $event->participants()
                ->where('user_id', auth()->id())
                ->exists(),
            403
        );

        $request->validate([
            'message' => 'required|max:1000'
        ]);

        $chat = GroupChat::firstOrCreate([
            'event_id' => $event->id,
        ]);

        GroupMessage::create([
            'group_chat_id' => $chat->id,
            'user_id'       => auth()->id(),
            'message'       => $request->message,
            'is_read'=>false,

        ]);

        return redirect()->route('group.chat', $event);
    }

    // ==========================
    // AJAX更新用
    // ==========================
    public function fetch(Event $event)
    {
        abort_unless(
            $event->participants()
                ->where('user_id', auth()->id())
                ->exists(),
            403
        );

        $chat = GroupChat::where(
            'event_id',
            $event->id
        )->first();

        if (!$chat) {
            return response()->json([]);
        }

        $chat->load([
            'messages' => function ($q) {
                $q->orderBy('created_at', 'asc');
            },
            'messages.user'
        ]);

        return response()->json(
            $chat->messages
        );
    }

    // ==========================
    // 参加者一覧
    // ==========================
    public function members(Event $event)
    {
        return view(
            'groupchat.members',
            [
                'event'   => $event,
                'members' => $event->participants
            ]
        );
    }
    public function unreadCount()
{
    return $this->messages()

        ->where('user_id','!=',auth()->id())

        ->where('is_read',false)

        ->count();
}
}