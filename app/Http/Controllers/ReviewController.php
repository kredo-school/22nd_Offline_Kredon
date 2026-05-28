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
        $user = User::first();
        
        $review = new Review();
        $review->user_id = $user->id;
        $review->spot_id = $spot->id;
        $review->title = $request->title;
        $review->comment = $request->comment;
        $review->dead_spot_rating = $request->dead_spot_rating;
        $review->aircon_level = $request->aircon_level;
        // 🌟 追加：パーソナルスペースの評価を保存
        $review->wall_seat_rating = $request->wall_seat_rating;
        $review->bgm_volume_level = $request->bgm_volume_level;

        // 📸 追加：画像が送られてきたら保存して、パスを記録する
        if ($request->hasFile('photo')) {
            // storage/app/public/photos フォルダに保存
            $path = $request->file('photo')->store('photos', 'public');
            $review->photo_path = $path;
        }
        
        $review->save();

        // ✨ 追加：成功メッセージをリュックに詰めて、元の画面に戻る
        return back()->with('success', '✨ スポットのレビューを投稿しました！');
    }
}