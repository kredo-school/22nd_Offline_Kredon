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
        // ① データの警備（予約URLのバリデーションを追加）
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'budget' => 'nullable|string', 
            'booking_url' => 'nullable|url', // 🌟 追加：URL形式チェック
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
            $tourist_spot->booking_url = $request->booking_url; // 🌟 追加：予約URLを保存

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

            $tourist_spot->has_activity = $request->has('has_activity');
            $tourist_spot->has_view     = $request->has('has_view');
            $tourist_spot->has_shopping = $request->has('has_shopping');
            $tourist_spot->has_food     = $request->has('has_food');
            
            $tourist_spot->user_id = Auth::id();
            $tourist_spot->save();

            // 写真の保存ロジック
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('tourist_spots/' . $tourist_spot->id, $filename, 'public');
                
                $tourist_spot->photo_path = $path;
                $tourist_spot->save();
            }

            DB::commit();

            return redirect()->route('tourist_spots.index')
                ->with('success', '✨ 新しい観光スポットを登録しました！');
                
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
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

        // 🌟 旧学習スポット用の不要なWi-Fi・電源検索ロジックはエラーの種になるため削除しました

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
        $tourist_spot = TouristSpot::findOrFail($id);
        return view('tourist_spot_detail', compact('tourist_spot'));
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