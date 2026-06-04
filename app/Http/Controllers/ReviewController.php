<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // 🌟 既存のお店に対する「追加レビュー」を保存する係
    public function store(Request $request, $spot_id)
    {
        // ① 入力データの警備（バリデーション）
        $request->validate([
            'customer_vibe' => 'nullable|integer|between:1,5',
            'eye_fatigue_level' => 'nullable|integer|between:1,5',
            'chair_comfort' => 'nullable|integer|between:1,5',
            'desk_stability' => 'nullable|integer|between:1,5',
            'good_point' => 'nullable|string|max:255',
            'bad_point' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            // 'photo' => 'nullable|image|max:2048', // ※写真は後で実装するので一旦コメントアウト
        ]);

       $user = Auth::user();

        // ② Reviewsテーブルに新しいレビューを保存！
        $review = new Review();
        $review->user_id = $user->id;
        $review->spot_id = $spot_id; // どのお店のレビューかを紐付ける！
        $review->customer_vibe = $request->customer_vibe;
        $review->eye_fatigue_level = $request->eye_fatigue_level;
        $review->chair_comfort = $request->chair_comfort;
        $review->desk_stability = $request->desk_stability;
        $review->good_point = $request->good_point;
        $review->bad_point = $request->bad_point;
        $review->comment = $request->comment;
        
        $review->save();

        return back()->with('success', '✨ レビューを投稿しました！平均点が更新されました！');
    }
    
// 🌟 追加：レビューを削除する担当
    public function destroy($id)
    {
        // 該当のレビューを探す
        $review = \App\Models\Review::findOrFail($id);
        
        // レビューをデータベースから削除
        $review->delete();

        // マイページに戻り、成功メッセージを表示
        return back()->with('success', 'レビューを削除しました。');
    }
}