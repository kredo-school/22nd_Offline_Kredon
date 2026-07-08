<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Models\ItemPost;

class MarketplaceController extends Controller
{
    // 一覧
  public function index(Request $request)
{
    $query = ItemPost::with('images');

    if($request->category)
    {
        $query->where('category',$request->category);
    }

    $items = $query->latest()->get();

    return view('marketplace.index', compact('items'));
}
    // 投稿画面
    public function create()
    {
        return view('marketplace.create');
    }

    // 保存
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location_name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $item = ItemPost::create([
        'user_id' => Auth::id(), // ★ここを追加
        'title' => $request->title,
        'location_name' => $request->location_name,
        'description' => $request->description,
        'category' => $request->category,
        'status' => $request->status,
    ]);

        // 画像保存
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('items', 'public');

                $item->images()->create([
                    'path' => $path
                ]);
            }
        }

        return redirect()
            ->route('marketplace.index')
            ->with('success', '投稿が完了しました！');
    }
            public function show(ItemPost $item)
        {
           $item->load([
        'images',
        'user',
    ]);

    return view('marketplace.show', compact('item'));
}
        
}