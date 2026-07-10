<?php

namespace App\Http\Controllers;

use App\Models\ItemPost;
use App\Models\MarketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketCommentController extends Controller
{
    public function store(Request $request, ItemPost $item)
    {
        $request->validate([
            'comment'=>'required|max:500'
        ]);

        MarketComment::create([
            'item_post_id'=>$item->id,
            'user_id'=>Auth::id(),
            'comment'=>$request->comment
        ]);

        return back();
    }

    public function destroy(MarketComment $comment)
    {
        if(Auth::id() != $comment->user_id){
            abort(403);
        }

        $comment->delete();

        return back();
    }
}