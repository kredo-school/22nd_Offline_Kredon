<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 🌟 マイページを表示する係
    public function mypage(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ① 自分が過去に投稿したクチコミを最新順で取得
        // 🌟変更点: get() ではなく paginate(10) に。さらに、お気に入り側の矢印と混同しないように 'reviews_page' という名前をつけます
        $myReviews = $user->reviews()->with('spot')->latest()->paginate(10, ['*'], 'reviews_page');

        // ② お気に入りスポットのクエリ（検索・並び替えの準備）
        $query = $user->bookmarks()->withCount('bookmarks');

        // 🌟 フィルター機能（リクエストに応じて絞り込み・並び替え）
        $filter = $request->query('filter');
        
        if ($filter === 'wifi') {
            $query->where('has_wifi', true);
        } elseif ($filter === 'power') {
            $query->where('has_power', true);
        }

        // 🌟変更点: 最新順で取得。こちらも 'bookmarks_page' という専用の名前をつけてページネーション！
        $myBookmarks = $query->latest()->paginate(10, ['*'], 'bookmarks_page');

        return view('mypage', compact('myReviews', 'myBookmarks'));
    }
}