<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
// 🌟 修正1：Auth を使うための自己紹介を追加！
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // ブックマークの追加・解除を切り替える処理
    public function toggle($spot_id)
    {
        // 🌟 修正2：VS Codeを黙らせるプロの魔法を追加！
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        
        $spot = Spot::findOrFail($spot_id);

        if ($spot->isBookmarkedBy($user)) {
            // 既にお気に入りされていれば解除
            $user->bookmarks()->detach($spot_id);
            return back()->with('success', 'お気に入りを解除しました');
        } else {
            // お気に入りされていなければ追加
            $user->bookmarks()->attach($spot_id);
            return back()->with('success', '🌟 お気に入りに登録しました！');
        }
    }
}