<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TouristReview;
use Illuminate\Support\Facades\Auth;

class TouristReviewController extends Controller
{
    // クチコミを保存する処理
    public function store(Request $request, $tourist_spot_id)
    {
        // ① 入力チェック（星は1〜5、コメントは無くてもOK）
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // ② データベース（TouristReviewテーブル）に保存
        TouristReview::create([
            'tourist_spot_id' => $tourist_spot_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // ③ 元の詳細画面に戻る
        return back()->with('success', '🌟 クチコミを投稿しました！');
    }

    // クチコミを削除する処理
    public function destroy($id)
    {
        $review = TouristReview::findOrFail($id);

        // セキュリティ：自分の書いたクチコミしか削除できないようにする
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', '削除権限がありません。');
        }

        $review->delete();

        return back()->with('success', '🗑️ クチコミを削除しました。');
    }
}