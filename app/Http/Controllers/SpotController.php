<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB; // 🌟 トランザクションを使うために必須！

class SpotController extends Controller
{
    public function store(Request $request)
    {
        // ① 入力データの警備（基本情報とニッチ評価のバリデーション）
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'has_wifi' => 'nullable|boolean',
            'has_power' => 'nullable|boolean',
            'customer_vibe' => 'nullable|integer|between:1,5',
            'eye_fatigue_level' => 'nullable|integer|between:1,5',
            'chair_comfort' => 'nullable|integer|between:1,5',
            'desk_stability' => 'nullable|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        // 🌟 プロの技：データベース・トランザクションを開始
        // これを入れることで、「万が一どちらかの保存に失敗したら、両方ともなかったことにする（データの不整合を防ぐ）」という強固な安全策になります。
        DB::beginTransaction();

        try {
            // ② まずは Spots テーブルにお店の基本情報を保存
            $spot = new Spot();
            $spot->name = $request->name;
            $spot->area = $request->area;
            $spot->has_wifi = $request->has_wifi ?? 0;
            $spot->has_power = $request->has_power ?? 0;
            $spot->save(); // ⬅️ ここで新しく作ったお店の「ID」が自動生成される！

            // ③ ユーザーがレビュー項目を1つでも入力していたら、Reviewsテーブルに保存
            // （何も入力してなければ、お店の基本情報だけが登録されます）
            if (
                $request->filled('customer_vibe') || $request->filled('eye_fatigue_level') ||
                $request->filled('chair_comfort') || $request->filled('desk_stability') ||
                $request->filled('comment')
            ) {

                $user = User::first(); // 仮のログインユーザー

                $review = new Review();
                $review->user_id = $user->id;
                $review->spot_id = $spot->id; // 🌟 さっき自動生成された出来たてホヤホヤの「お店ID」をここで紐付ける！
                $review->comment = $request->comment;

                // ニッチ評価を代入
                $review->customer_vibe = $request->customer_vibe;
                $review->eye_fatigue_level = $request->eye_fatigue_level;
                $review->chair_comfort = $request->chair_comfort;
                $review->desk_stability = $request->desk_stability;

                $review->save();
            }

            // 全て成功したらデータベースへの書き込みを確定（コミット）
            DB::commit();

            return back()->with('success', '✨ 新しいスポットと最初のレビューを登録しました！');
        } catch (\Exception $e) {
            // どっかでエラーが起きたら、全部登録前の状態に巻き戻す（ロールバック）
            DB::rollback();
            return back()->with('error', '登録中にエラーが発生しました。');
        }
    }
}
