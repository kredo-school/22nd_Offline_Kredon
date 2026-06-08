<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TouristSpot;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TouristSpotController extends Controller
{
   public function store(Request $request)
    {
        // ① データの警備（観光スポット用にスッキリ最適化）
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'budget' => 'nullable|string', // 🌟 予算を追加
            'open_time' => 'nullable|string', 
            'close_time' => 'nullable|string', 
            'photo' => 'nullable|image|max:10240', // 🌟 フォームに合わせて単一画像に変更
        ]);

        DB::beginTransaction();

        try {
            $tourist_spot = new TouristSpot();
            $tourist_spot->name = $request->name;
            $tourist_spot->area = $request->area;
            $tourist_spot->budget = $request->budget; // 🌟 予算を保存

            // 時間の合体処理
            $hours = null;
            if ($request->filled('open_time') && $request->filled('close_time')) {
                $hours = $request->open_time . ' - ' . $request->close_time;
            } elseif ($request->filled('open_time')) {
                $hours = $request->open_time . ' - 未定';
            } elseif ($request->filled('close_time')) {
                $hours = '未定 - ' . $request->close_time;
            }
            $tourist_spot->hours = $hours;

            // 🌟 観光スポット専用の「体験フラグ」に変更！（has_wifiなどは削除）
            $tourist_spot->has_activity = $request->has('has_activity');
            $tourist_spot->has_view     = $request->has('has_view');
            $tourist_spot->has_shopping = $request->has('has_shopping');
            $tourist_spot->has_food     = $request->has('has_food');
            
            $tourist_spot->user_id = Auth::id();

            // まずスポット自体を保存してIDを確定させる
            $tourist_spot->save();

            // 🌟 写真の保存ロジック（フォームに合わせて1枚だけシンプルに保存）
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('tourist_spots/' . $tourist_spot->id, $filename, 'public');
                
                $tourist_spot->photo_path = $path;
                $tourist_spot->save();
            }

            // ※学習スポット専用のレビュー初期投稿ロジック（イスの座り心地など）は、
            // 観光スポットの新規登録には不要なので削除しました！

            DB::commit();

            // 🌟 登録成功後、作ったばかりの詳細ページではなく、安全に一覧ページ（トップ）に戻す
            return redirect()->route('tourist_spots.index')
                ->with('success', '✨ 新しい観光スポットを登録しました！');
                
        } catch (\Exception $e) {
            DB::rollback();
            // 🌟 万が一またエラーが起きた時に、原因を画面にドーンと出して教えてくれる魔法に変更！
            dd($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $tourist_spot = TouristSpot::findOrFail($id);

        if ($tourist_spot->user_id !== Auth::id()) {
            abort(403, 'このスポットを編集する権限がありません。');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'open_time' => 'nullable|string',
            'close_time' => 'nullable|string',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|max:10240',
        ]);

        $hours = $tourist_spot->hours; 
        if ($request->filled('open_time') || $request->filled('close_time')) {
            $open = $request->filled('open_time') ? $request->open_time : '未定';
            $close = $request->filled('close_time') ? $request->close_time : '未定';
            $hours = $open . ' - ' . $close;
        }

        $tourist_spot->update([
            'name' => $request->name,
            'area' => $request->area,
            'hours' => $hours,
            'has_wifi' => $request->has('has_wifi') ? true : false,
            'has_power' => $request->has('has_power') ? true : false,
        ]);

        // 🌟 編集時も専用フォルダに整理して保存
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('tourist_spots/' . $tourist_spot->id, $filename, 'public');

                if (empty($tourist_spot->photo_path) && $index === 0) {
                    $tourist_spot->update(['photo_path' => $path]);
                }

                $tourist_spot->photos()->create([
                    'photo_path' => $path
                ]);
            }
        }

        return redirect()->route('tourist_spots.show', $tourist_spot->id)
            ->with('success', '✨ スポット情報を最新に更新しました！');
    }

    public function index(Request $request)
    {
        $query = TouristSpot::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->has('wifi')) {
            $query->where('has_wifi', true);
        }

        if ($request->has('power')) {
            $query->where('has_power', true);
        }

        $sort = $request->input('sort', 'newest'); 
        if ($sort === 'rating_high') {
            $query->latest(); 
        } elseif ($sort === 'bookmark_count') {
            $query->withCount('bookmarks')->orderBy('bookmarks_count', 'desc');
        } else {
            $query->latest();
        }

        $tourist_spots = $query->paginate(20);

        return view('tourist_top', compact('tourist_spots'));
    }

    public function show($id)
    {
        // 🌟 クチコミに加えて、紐づく複数写真（photos）も一緒に持ってくる！
        $tourist_spot = TouristSpot::with(['reviews.user', 'photos'])->findOrFail($id);
        return view('tourist_spot_detail', compact('tourist_spot'));
    }
}