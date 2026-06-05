<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // 🌟 お気に入りの追加・解除をたった1行で処理する係
    public function toggle($id)
    {
        $spot = Spot::findOrFail($id);
        
        // 💡 修正ポイント：VS Codeに「これはApp\Models\Userだよ！」と教えてあげる魔法のコメント（これで赤線が消えます）
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // toggle()を使うと「データベースにあれば削除」「なければ追加」を自動でやってくれます
        $user->bookmarks()->toggle($spot->id);

        // 元の画面（詳細ページ）に戻る
        return back()->with('success', 'お気に入りを更新しました！');
    }
}