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
        // 🌟 犯人を絶対に逃がさない手動バリデーション
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'hours_type' => 'required|in:specified,24h,unknown',
            'open_time' => 'nullable|string',
            'close_time' => 'nullable|string',
            'photos' => 'nullable|array|max:4',
            // ★超重要変更点：'image' をやめて、具体的な拡張子で許可する（AVIFも追加！）
            'photos.*' => 'file|mimes:jpg,jpeg,png,gif,webp,avif|max:10240',
            'customer_vibe' => 'required|integer|between:1,5',
            'eye_fatigue_level' => 'required|integer|between:1,5',
            'chair_comfort' => 'required|integer|between:1,5',
            'desk_stability' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        // もし入力チェックに引っかかったら、無言で戻さずに黒い画面で理由を自白させる！
        if ($validator->fails()) {
            dd('🚨【犯人判明】入力チェックで弾かれました！', $validator->errors()->toArray());
        }

        DB::beginTransaction();

        try {
            $spot = new Spot();
            $spot->name = $request->name;
            $spot->area = $request->area;

            // 時間の合体処理
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
            $spot->hours = $hours;

            $spot->has_wifi = $request->has('has_wifi');
            $spot->has_power = $request->has('has_power');
            $spot->user_id = Auth::id();

            $spot->save();

            // 複数画像の保存ロジック
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs('spots/' . $spot->id, $filename, 'public');

                    if ($index === 0) {
                        $spot->photo_path = $path;
                        $spot->save();
                    }

                    $spot->photos()->create([
                        'photo_path' => $path
                    ]);
                }
            }

            // レビュー作成
            $spot->reviews()->create([
                'user_id' => Auth::id(),
                'customer_vibe' => $request->customer_vibe,
                'eye_fatigue_level' => $request->eye_fatigue_level,
                'chair_comfort' => $request->chair_comfort,
                'desk_stability' => $request->desk_stability,
                'comment' => $request->comment,
            ]);

            DB::commit();

            return redirect('/') 
                ->with('success', '✨ 新しいスポットと写真を登録しました！');

        } catch (\Exception $e) {
            DB::rollback();
            // 🌟 もしデータベース保存中にエラーが起きたら、黒い画面で理由を自白させる！
            dd('🚨【犯人判明】DB保存中にエラーが起きました！', $e->getMessage(), '行番号: ' . $e->getLine());
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
            $query->where(function ($q) use ($keyword) {
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
    // app/Http/Controllers/SpotController.php に追加

    public function useCoupon(Spot $spot)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'ログインが必要です。']);
        }

        // すでに今月使用済みの場合は弾く
        if ($spot->isCouponUsedByMonth($user)) {
            return response()->json(['success' => false, 'message' => '今月は既に使用済みです。']);
        }

        // 使用履歴を記録
        \Illuminate\Support\Facades\DB::table('coupon_usages')->insert([
            'user_id' => $user->id,
            'spot_id' => $spot->id,
            'used_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'クーポンを適用しました！']);
    }
}
