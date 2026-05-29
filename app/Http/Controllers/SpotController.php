<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Review;
use App\Models\User;

class SpotController extends Controller
{
    // 新規スポットと初期レビューを同時に保存する処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'area' => 'required',
        ]);
        // 開発用：とりあえず最初のテストユーザーを投稿者とする
        $user = User::first();

        // ① まずは新しいお店（Spot）を登録する
        $spot = new Spot();

        $spot->user_id = $user->id;
        $spot->name = $request->name;
        $spot->area = $request->area;
        $spot->has_wifi = $request->has('has_wifi') ? true : false;
        $spot->has_power = $request->has('has_power') ? true : false;

        // 写真があれば保存
        if ($request->hasFile('photo')) {
            $spot->photo_path = $request->file('photo')->store('photos', 'public');
        }
        $spot->save(); // 先にお店を保存してIDを発行！

        // ② 次に、そのお店の「初期DNA（初回の集中環境レビュー）」を登録する
        $review = new Review();
        $review->user_id = $user->id;
        $review->spot_id = $spot->id; // ①で作られたお店のIDを紐付ける
        $review->dead_spot_rating = $request->dead_spot_rating;
        $review->aircon_level = $request->aircon_level;
        $review->wall_seat_rating = $request->wall_seat_rating;
        $review->bgm_volume_level = $request->bgm_volume_level;
        $review->save();

        // ③ 成功メッセージを持ってトップページへ戻る
        return back()->with('success', '✨ 新規スポットを開拓しました！あなたが第一発見者です！');
    }
}
