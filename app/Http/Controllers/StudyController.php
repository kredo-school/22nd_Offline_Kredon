<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;

class StudyController extends Controller
{
    // 🌟 新しいトップページを表示する係
    public function top()
    {
        $spots = Spot::latest()->take(3)->get();
        return view('top', compact('spots'));
    }

    // 🌟 検索・一覧ページを表示 ＆ 検索・ソートロジックを処理する係
    public function index(Request $request)
    {
        // 🌟 プロの技：1本の綺麗なメソッドチェーンにまとめることで、VS Codeの誤検知エラーを一掃します！
        // 途中の余計な変数への小分けを無くすことで、チェッカーも正しく型を認識できるようになります。
        $spots = Spot::with('reviews')
            ->withCount('reviews')
            ->search($request)
            ->sort($request)
            ->paginate(10);

        // 注目のスポット（クチコミが一番多い店舗）を1件取得
        $featuredSpot = Spot::withCount('reviews')->orderByDesc('reviews_count')->first();

        return view('top', compact('spots', 'featuredSpot'));
    }

    // 🌟 1つのお店の詳細と、そのレビューを全部持ってくる係
    public function show($id)
    {
        $spot = Spot::with('reviews')->findOrFail($id);
        return view('spot_detail', compact('spot'));
    }
}