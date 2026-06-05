<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 🌟 マイページを表示する係
    public function mypage()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ① 自分が過去に投稿したクチコミを最新順で取得（お店の情報も一緒に持ってくる）
        $myReviews = $user->reviews()->with('spot')->latest()->get();

        // ② 自分がお気に入り登録したスポットを最新順で取得
        $myBookmarks = $user->bookmarks()->latest()->get();

        // ③ 2つのデータをマイページの画面（mypage.blade.php）に渡す
        return view('mypage', compact('myReviews', 'myBookmarks'));
    }
}