<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TouristSpot;
use App\Models\Review;
use App\Models\TouristBookmark; // 🌟 欠落していたインポートを追加
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TouristSpotController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'budget' => 'nullable|string', 
            'booking_url' => 'nullable|url', 
            'hours_type' => 'required|in:specified,24h,unknown', 
            'open_time' => 'nullable|string', 
            'close_time' => 'nullable|string', 
            'photo' => 'nullable|image|max:10240', 
        ]);

        DB::beginTransaction();

        try {
            $tourist_spot = new TouristSpot();
            $tourist_spot->name = $request->name;
            $tourist_spot->area = $request->area;
            $tourist_spot->budget = $request->budget; 
            $tourist_spot->booking_url = $request->booking_url; 

            $hours = null;
            if ($request->hours_type === '24h') {
                $hours = '24時間営業';
            } elseif ($request->hours_type === 'unknown') {
                $hours = '不明';
            } else {
                if ($request->filled('open_time') && $request->filled('close_time')) {
                    $hours = $request->open_time . ' - ' . $request->close_time;
                } elseif ($request->filled('open_time')) {
                    $hours = $request->open_time . ' - 未定';
                } elseif ($request->filled('close_time')) {
                    $hours = '未定 - ' . $request->close_time;
                } else {
                    $hours = '未定';
                }
            }
            $tourist_spot->hours = $hours;

            $tourist_spot->has_activity = $request->has('has_activity');
            $tourist_spot->has_view     = $request->has('has_view');
            $tourist_spot->has_shopping = $request->has('has_shopping');
            $tourist_spot->has_food     = $request->has('has_food');
            
            $tourist_spot->user_id = Auth::id();
            $tourist_spot->save();

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('tourist_spots/' . $tourist_spot->id, $filename, 'public');
                
                $tourist_spot->photo_path = $path;
                $tourist_spot->save();
            }

            DB::commit();

            // 🌟 月数計算とガチャのテーブル選択
            $months = 0;
            if (Auth::check()) {
                $months = Auth::user()->created_at->diffInMonths(now());
            }
            $category = $months < 4 ? 'basic' : 'advanced';

            // データベースからランダムに1件Tipsを引く
            $randomTip = \App\Models\Tip::where('category', $category)->inRandomOrder()->first();

            // 🚨 ここが真っ白対策の「安全装置」！
            // もしSeederが失敗していてガチャが空っぽ(null)でも、エラーにならずデフォルト文字を出す！
            $title = $randomTip ? $randomTip->title : '💡 情報シェアありがとうございます！';
            $text = $randomTip ? $randomTip->text : '引き続き、セブでの生活と開発を楽しんでいきましょう！';

            return redirect()->route('tourist_spots.index') 
                ->with('success', '✨ 新しい観光スポットを登録しました！')
                ->with('reward_tip_title', $title)
                ->with('reward_tip_text', $text);
                
        // 🚨 Exception を Throwable に変更！
        // これで「どんな致命的なエラー」が起きても、絶対に気絶（真っ白）せず黒い画面で理由を自白します！
        } catch (\Throwable $e) {
            DB::rollback();
            dd('🚨【原因判明】エラー発生！', $e->getMessage(), '行番号: ' . $e->getLine());
        }
    }

    public function update(Request $request, $id)
    {
        // ① 入力チェック（予約URLを追加）
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'budget' => 'nullable|string',
            'booking_url' => 'nullable|url', // 🌟 追加：URL形式チェック
            'hours' => 'nullable|string',
            'photo' => 'nullable|image|max:10240',
        ]);

        $tourist_spot = TouristSpot::findOrFail($id);

        // ② セキュリティ
        if ($tourist_spot->user_id !== Auth::id()) {
            return redirect()->route('tourist_spots.index')->with('error', '編集権限がありません。');
        }

        // ③ データの更新
        $tourist_spot->name = $request->name;
        $tourist_spot->area = $request->area;
        $tourist_spot->budget = $request->budget;
        $tourist_spot->booking_url = $request->booking_url; // 🌟 追加：予約URLを更新
        $tourist_spot->hours = $request->hours;

        $tourist_spot->has_activity = $request->has('has_activity');
        $tourist_spot->has_view     = $request->has('has_view');
        $tourist_spot->has_shopping = $request->has('has_shopping');
        $tourist_spot->has_food     = $request->has('has_food');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('tourist_spots/' . $tourist_spot->id, $filename, 'public');
            $tourist_spot->photo_path = $path;
        }

        $tourist_spot->save();

        return redirect()->route('tourist_spots.show', $tourist_spot->id)
            ->with('success', '✨ 観光スポットの情報を更新しました！');
    }

    public function index(Request $request)
    {
        // 星の平均点も一緒に取得
        $query = TouristSpot::withAvg('reviews', 'rating');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        // エリア検索
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        // ========================================================
        // 🌟 ここから追加：体験タグでの絞り込み
        // ========================================================
        if ($request->has('activity')) {
            $query->where('has_activity', true);
        }
        if ($request->has('view')) {
            $query->where('has_view', true);
        }
        if ($request->has('shopping')) {
            $query->where('has_shopping', true);
        }
        if ($request->has('food')) {
            $query->where('has_food', true);
        }
        // ========================================================

        // 並び替え（人気順 or 新着順）
        $sort = $request->input('sort', 'newest');
        if ($sort === 'bookmark_count') {
            $query->withCount('bookmarks')->orderBy('bookmarks_count', 'desc');
        } else {
            $query->latest();
        }

        $tourist_spots = $query->paginate(20);

        return view('tourist_top', compact('tourist_spots'));
    }

    public function show($id)
    {
        // 🌟 進化ポイント1：スポット情報と一緒に「星の平均点(avg)」と「クチコミ件数(count)」も取得！
        $tourist_spot = TouristSpot::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->findOrFail($id);

        // 🌟 進化ポイント2：このスポットに投稿されたクチコミ一覧を最新順で取得！
        $reviews = $tourist_spot->reviews()->latest()->get();

        // 🌟 取得したデータを画面に渡す（$reviews を追加）
        return view('tourist_spot_detail', compact('tourist_spot', 'reviews'));
    }

    public function destroy($id)
    {
        $tourist_spot = TouristSpot::findOrFail($id);

        if ($tourist_spot->user_id !== Auth::id()) {
            return redirect()->route('tourist_spots.index')->with('error', '削除権限がありません。');
        }

        $tourist_spot->delete();

        return redirect()->route('tourist_spots.index')
            ->with('success', '🗑️ 観光スポットを削除しました。');
    }

    public function toggleBookmark($id)
    {
        $userId = Auth::id();

        $bookmark = TouristBookmark::where('user_id', $userId)
            ->where('tourist_spot_id', $id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', '🤍 お気に入りから外しました。');
        } else {
            TouristBookmark::create([
                'user_id' => $userId,
                'tourist_spot_id' => $id
            ]);
            return back()->with('success', '❤️ お気に入りに登録しました！');
        }
    }
}
