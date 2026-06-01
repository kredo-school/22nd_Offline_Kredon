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
        $spots = $query->latest()->get();

        // ⑦ 絞り込んだ結果（$spots）を持って、検索ページ（welcome.blade.php）を表示する
        return view('welcome', compact('spots'));
    }
}
