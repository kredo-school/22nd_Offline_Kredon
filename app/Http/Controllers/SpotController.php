<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SpotController extends Controller
{
    public function store(Request $request)
    {
        // ① データの警備
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'open_time' => 'nullable|string', 
            'close_time' => 'nullable|string', 
            'photos' => 'nullable|array|max:5', // 最大5枚まで許可
            'photos.*' => 'image|max:10240', // 1枚あたり10MBまで
            'customer_vibe' => 'nullable|integer|between:1,5',
            'eye_fatigue_level' => 'nullable|integer|between:1,5',
            'chair_comfort' => 'nullable|integer|between:1,5',
            'desk_stability' => 'nullable|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $spot = new Spot();
            $spot->name = $request->name;
            $spot->area = $request->area;

            // 時間の合体処理
            $hours = null;
            if ($request->filled('open_time') && $request->filled('close_time')) {
                $hours = $request->open_time . ' - ' . $request->close_time;
            } elseif ($request->filled('open_time')) {
                $hours = $request->open_time . ' - 未定';
            } elseif ($request->filled('close_time')) {
                $hours = '未定 - ' . $request->close_time;
            }
            $spot->hours = $hours;

            $spot->has_wifi = $request->has('has_wifi');
            $spot->has_power = $request->has('has_power');
            $spot->user_id = Auth::id();

            // 🌟 まずスポット自体を保存してIDを確定させる
            $spot->save();

            // 🌟 【進化版】複数画像の保存ロジック（IDごとのフォルダに整理）
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    // ユニークなファイル名を生成
                    $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                    // spots/スポットID/ファイル名 という階層で保存
                    $path = $photo->storeAs('spots/' . $spot->id, $filename, 'public');

                    // 1枚目は従来の「代表写真」としても登録
                    if ($index === 0) {
                        $spot->photo_path = $path;
                        $spot->save();
                    }

                    // spot_photos テーブルに保存
                    $spot->photos()->create([
                        'photo_path' => $path
                    ]);
                }
            }

            if (
                $request->filled('customer_vibe') || $request->filled('eye_fatigue_level') ||
                $request->filled('chair_comfort') || $request->filled('desk_stability') ||
                $request->filled('comment')
            ) {
                $spot->reviews()->create([
                    'user_id' => Auth::id(),
                    'customer_vibe' => $request->customer_vibe,
                    'eye_fatigue_level' => $request->eye_fatigue_level,
                    'chair_comfort' => $request->chair_comfort,
                    'desk_stability' => $request->desk_stability,
                    'comment' => $request->comment,
                ]);
            }

            DB::commit();

            return redirect()->route('spots.show', $spot->id)
                ->with('success', '✨ 新しいスポットと写真を登録しました！');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', '登録中にエラーが発生しました。');
        }
    }

    public function update(Request $request, $id)
    {
        $spot = Spot::findOrFail($id);

        if ($spot->user_id !== Auth::id()) {
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

        $hours = $spot->hours; 
        if ($request->filled('open_time') || $request->filled('close_time')) {
            $open = $request->filled('open_time') ? $request->open_time : '未定';
            $close = $request->filled('close_time') ? $request->close_time : '未定';
            $hours = $open . ' - ' . $close;
        }

        $spot->update([
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
                $path = $photo->storeAs('spots/' . $spot->id, $filename, 'public');

                if (empty($spot->photo_path) && $index === 0) {
                    $spot->update(['photo_path' => $path]);
                }

                $spot->photos()->create([
                    'photo_path' => $path
                ]);
            }
        }

        return redirect()->route('spots.show', $spot->id)
            ->with('success', '✨ スポット情報を最新に更新しました！');
    }

    public function index(Request $request)
    {
        $query = Spot::query();

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

        $spots = $query->paginate(20);

        return view('top', compact('spots'));
    }

    public function show($id)
    {
        // 🌟 クチコミに加えて、紐づく複数写真（photos）も一緒に持ってくる！
        $spot = Spot::with(['reviews.user', 'photos'])->findOrFail($id);
        return view('spot_detail', compact('spot'));
    }
}