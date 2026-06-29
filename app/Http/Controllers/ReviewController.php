<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


use App\Models\User;

class ReviewController extends Controller
{

    public function index()
    {
        return view('reviews.index');
    }


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

    // 🌟 レビュー編集（更新）処理
    public function update(Request $request, $id)
    {
        $review = \App\Models\Review::findOrFail($id);

        // セキュリティ対策：絶対に本人しか編集できないようにする
        if ($review->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, '権限がありません');
        }

        // 写真が新しくアップロードされたら保存（それ以外はそのまま）
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('reviews', 'public');
            $review->photo_path = $path;
        }

        // データを上書き保存
        $review->update([
            'customer_vibe' => $request->customer_vibe,
            'eye_fatigue_level' => $request->eye_fatigue_level,
            'chair_comfort' => $request->chair_comfort,
            'desk_stability' => $request->desk_stability,
            'good_point' => $request->good_point,
            'bad_point' => $request->bad_point,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'レビューを更新しました！');
    }

    // 🌟 レビュー削除処理
    public function destroy($id)
    {
        $review = \App\Models\Review::findOrFail($id);

        // セキュリティ対策：絶対に本人しか削除できないようにする
        if ($review->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, '権限がありません');
        }

        $review->delete();

        return back()->with('success', 'レビューを削除しました！');
    }
}
