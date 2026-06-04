<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;

class StudyController extends Controller
{
    // 🌟 今回追加：新しいトップページを表示する係
    public function top()
    {
        // 注目のスポットや新着などを取得してトップページに渡す
        $spots = Spot::latest()->take(3)->get();
        return view('top', compact('spots'));
    }
   // 🌟 検索ページを表示＆検索ロジックを処理する係
    public function index(Request $request)
    {
        // ① まずは「これから検索条件を組み立てるぞ」という空の箱（クエリ）を用意する
        $query = Spot::query();

        // ② もし「キーワード」が入力されていたら、店名かエリアにその文字が含まれるか探す
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        // ③ もし「エリア」が選択されていたら、そのエリアで絞り込む
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        // ④ もし「WiFiあり」にチェックが入っていたら、WiFiがあるお店だけに絞る
        if ($request->filled('wifi')) {
            $query->where('has_wifi', 1);
        }

        // ⑤ もし「電源あり」にチェックが入っていたら、電源があるお店だけに絞る
        if ($request->filled('power')) {
            $query->where('has_power', 1);
        }

        // ⑥ ここまでに組み立てた条件を全部合体させて、データベースから最新順で取得！
        $spots = $query->with('reviews')->latest()->paginate(10);

        // ⑦ 絞り込んだ結果（$spots）を持って、検索ページ（welcome.blade.php）を表示する
        return view('welcome', compact('spots'));
    }
    // 🌟 これを追加：1つのお店の詳細と、そのレビューを全部持ってくる係
    public function show($id)
    {
        $spot = \App\Models\Spot::with('reviews')->findOrFail($id);
        return view('spot_detail', compact('spot'));
    }
    public function search(Request $request)
    {
        // ユーザーが入力した検索条件を受け取る
        $keyword = $request->input('keyword');
        $area = $request->input('area');
        $wifi = $request->input('wifi');
        $power = $request->input('power');

        // ベースとなるクエリ（データベースへの質問状）を作成
        // `with('reviews')` は平均点を計算するためにレビュー情報も一緒に持ってくる魔法
        $query = Spot::with('reviews');

        // ① キーワードがあれば、名前かエリアから探す
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        // ② エリアが選択されていれば、そのエリアで絞り込む
        if (!empty($area)) {
            $query->where('area', $area);
        }

        // ③ WiFiありにチェックが入っていれば絞り込む
        if ($wifi == '1') {
            $query->where('has_wifi', true);
        }

        // ④ 電源ありにチェックが入っていれば絞り込む
        if ($power == '1') {
            $query->where('has_power', true);
        }

        // 条件に合ったものを最新順に取得する
        $spots = $query->latest()->paginate(10);

        // 検索結果をトップページと同じデザインの 'top' に渡して表示する
        return view('top', compact('spots'));
    }
}

