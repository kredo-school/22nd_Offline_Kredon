<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function mypage()
    {
    // 🌟 追加：VS Codeに「この $user は App\Models\User だよ」と教えるプロの技
        /** @var \App\Models\User $user */    
    // 開発用：ログインの壁を飛ばして、一番最初（テストデータ）のユーザーを仮で呼び出す
      $user = Auth::user();

        // そのユーザーが書いたレビューと、レビュー先のお店（spot）の情報も一緒に取得
        $reviews = $user->reviews()->with('spot')->get();

        $bookmarkedSpots = $user->bookmarks()->latest()->get();

        // 'mypage' という名前のBlade画面にデータを渡す
        return view('mypage', compact('user', 'reviews','bookmarkedSpots'));
    }
}
