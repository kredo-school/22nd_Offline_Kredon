<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 🌟 Auth（ログイン情報）を使うために絶対に必要！
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ログインしていないとアクセスできないようにする
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();

        // ① あゆみさんが作っていた「学習スポット」のデータ取得
        $bookmarkedStudySpots = $user->bookmarkedStudySpots()->get(); // ※ここのコードは元の記述が必要です

        // ② 今回作った「観光スポット」のデータ取得
        $bookmarkedSpots = $user->bookmarkedTouristSpots()->latest('tourist_bookmarks.created_at')->get();

        // ③ 両方のデータを画面（Blade）に一緒に渡す！
        return view('home', compact('bookmarkedStudySpots', 'bookmarkedSpots'));
    }
}