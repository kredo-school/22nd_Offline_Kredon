<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookmarkController extends Controller
{
    public function storte(Request $request)
    {
        // 実際には Bookmark::create(...) を書く場所
        // 今はログを出して、リクエストが飛んできたことを確認する
        Log::info('ブックマーク登録リクエストを受診：', $request->all());

        return response()->json(['message' => '登録完了（仮）']);
    }

    public function destroy($id)
    {
        Log::info('ブックマーク削除リクエストを受診： ID ' . '$id');

        return response()->json(['message' => '解除完了（仮）']);
    }
}
