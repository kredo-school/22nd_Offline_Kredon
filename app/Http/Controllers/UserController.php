<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function mypage()
    {
        // 開発用：ログインの壁を飛ばして、一番最初（テストデータ）のユーザーを仮で呼び出す
        $user = User::first();

        // そのユーザーが書いたレビューと、レビュー先のお店（spot）の情報も一緒に取得
        $reviews = $user->reviews()->with('spot')->get();

        // 'mypage' という名前のBlade画面にデータを渡す
        return view('mypage', compact('user', 'reviews'));
    }
}
