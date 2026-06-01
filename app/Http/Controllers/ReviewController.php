<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Spot;
use App\Models\User;

class ReviewController extends Controller
{
    public function store(Request $request, Spot $spot)
    {
        // 🚨 追加：入力データの警備（バリデーション）
        // 追加したニッチ評価が「空欄OK（nullable）」かつ「1〜5の数字」かチェックします
        $request->validate([
            'customer_vibe' => 'nullable|integer|between:1,5',
            'eye_fatigue_level' => 'nullable|integer|between:1,5',
            'chair_comfort' => 'nullable|integer|between:1,5',
            'desk_stability' => 'nullable|integer|between:1,5',
        ]);

        $user = User::first();
        
        $review = new Review();
        $review->user_id = $user->id;
        $review->spot_id = $spot->id;
        
        // テキスト系の評価
        $review->title = $request->title;
        $review->comment = $request->comment;
        
        // 既存の評価項目
        $review->dead_spot_rating = $request->dead_spot_rating;
        $review->aircon_level = $request->aircon_level;
        $review->wall_seat_rating = $request->wall_seat_rating;
        $review->bgm_volume_level = $request->bgm_volume_level;

        // 🌟 今回追加：ニッチなパーソナルスペース評価をセット！
        $review->customer_vibe = $request->customer_vibe;         // 客層
        $review->eye_fatigue_level = $request->eye_fatigue_level; // 目の疲れ度
        $review->chair_comfort = $request->chair_comfort;         // イスの座りやすさ
        $review->desk_stability = $request->desk_stability;       // 机の安定度

        // 📸 画像が送られてきたら保存して、パスを記録する
        if ($request->hasFile('photo')) {
            // storage/app/public/photos フォルダに保存
            $path = $request->file('photo')->store('photos', 'public');
            $review->photo_path = $path;
        }
        
        $review->save();

        // ✨ 成功メッセージをリュックに詰めて、元の画面に戻る
        return back()->with('success', '✨ スポットのニッチなレビューを投稿しました！');
    }
}