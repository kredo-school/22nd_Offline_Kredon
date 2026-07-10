<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\GroupMessage;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportMessage(Message $message)
    {
        Report::create([
            'user_id'=>auth()->id(),
            'message_id'=>$message->id,
        ]);

        return back()->with(
            'success',
            'Message reported.'
        );
    }

    public function reportGroup(GroupMessage $message)
    {
        Report::create([
            'user_id'=>auth()->id(),
            'group_message_id'=>$message->id,
        ]);

        return back()->with(
            'success',
            'Message reported.'
        );
    }
    public function reportItem(ItemPost $item)
{
    Report::create([
        'user_id'=>Auth::id(),
        'reason'=>'Marketplace Item',
        'target_type'=>'item',
        'target_id'=>$item->id,
    ]);

    return back()->with('success','Item reported.');
}

public function reportMarketComment(MarketComment $comment)
{
    Report::create([
        'user_id'=>Auth::id(),
        'reason'=>'Marketplace Comment',
        'target_type'=>'market_comment',
        'target_id'=>$comment->id,
    ]);

    return back()->with('success','Comment reported.');
}
}