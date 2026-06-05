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
        // ① データの警備（時間のルールも追加！）
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'open_time' => 'nullable|string', // 🌟 H:i縛りをやめて文字列として受け入れる
            'close_time' => 'nullable|string', // 🌟 同上
            'photo' => 'nullable|image|max:10240', // 🌟 写真の上限を2MBから一気に「10MB」へ引き上げ！
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

            // 🌟 追加：バラバラに送られてきた時間を「08:00 - 22:00」の形に合体させる
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

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('spots', 'public');
                $spot->photo_path = $path;
            }

            $spot->save();

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
                ->with('success', '✨ 新しいスポットと最初のレビューを登録しました！');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', '登録中にエラーが発生しました。');
        }
    }
}
