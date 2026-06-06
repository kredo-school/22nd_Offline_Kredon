<?php

namespace App\Http\Controllers;
use App\Models\ItemPost;
use Illuminate\Http\Request;

class ItemPostController extends Controller
{
    public function index()
    {
        // 投稿を最新順で取得（ユーザー情報も同時に読み込む
        $posts = ItemPost::with('user')->latest()->get();

        // ビューにデータを渡す（resources/views/posts/index.blade.php を表示する場合）
        return view('home', compact('posts', 'events'));
    }
}
