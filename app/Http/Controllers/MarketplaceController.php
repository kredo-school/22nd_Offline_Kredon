<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPost;

class MarketplaceController extends Controller
{
    public function index()
    {
        if (ItemPost::count() === 0) {
            $this->createTestData();
        }

        // with('images') を使う場合は、画像機能が完成してから呼び出してください
        $items = ItemPost::latest()->get(); 

        return view('marketplace.index', compact('items'));
    }

    public function create()
    {
        return view('marketplace.create');
    }

    public function store(Request $request)
    {
        // フォームから送られてきた全項目をバリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'location_name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string', // 追加
            'status' => 'required|string',   // 追加
            'images.*' => 'nullable|image|max:2048', // 画像（もしあれば）
        ]);

        // データベースに保存
        $item = ItemPost::create([
            'title' => $request->title,
            'location_name' => $request->location_name,
            'description' => $request->description,
            'category' => $request->category, // 追加
            'status' => $request->status,     // 追加
        ]);

        // 画像がある場合の処理（シンボリックリンクの設定後に行う）
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('items', 'public');
                    $item->images()->create(['path' => $path]);
                }
            }
        }

        return redirect()->route('marketplace.index')->with('success', '投稿が完了しました！');
    }

    private function createTestData()
    {
        $locations = ['ITパーク周辺', 'アヤラセンター近く', 'マボロエリア', 'ラフグ周辺', 'SMシティ近く', 'バニラッドエリア'];
        $titles = ['Tシャツまとめ', 'スキンケアセット', 'タオル3枚'];

        foreach ($titles as $index => $title) {
            ItemPost::create([
                'title' => $title,
                'description' => 'テスト投稿です。',
                'status' => '新品',
                'location_name' => $locations[$index % count($locations)],
                'category' => 'その他',
            ]);
        }
    }
}