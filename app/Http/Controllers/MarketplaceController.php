<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Models\ItemPost;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class MarketplaceController extends Controller
{
    // 一覧
 public function index(Request $request)
{
    $query = ItemPost::with('images');

    if (
        $request->filled('category') &&
        $request->category != 'all'
    ) {
        $query->where('category', $request->category);
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
           'image1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',   
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
    'interestedUsers',
    'reservedUser',
    'user'
]);

    $isInterested = Auth::check()
    ? $item->interestedUsers->contains(Auth::id())
    : false;

return view(
    'marketplace.show',
    compact(
        'item',
        'isInterested'
    )
);
}
public function sold(ItemPost $item)
{
    abort_if(Auth::id() != $item->user_id,403);

    $item->update([
        'market_status' => 'sold'
    ]);

    return back();
}

public function available(ItemPost $item)
{
    abort_if(Auth::id() != $item->user_id,403);

    $item->update([
        'market_status' => 'available'
    ]);

    return back();
}
public function edit(ItemPost $item)
{
    return view('marketplace.edit', compact('item'));
}
public function update(Request $request, ItemPost $item)
{
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'category' => 'required',
        'location_name' => 'required',
        'status' => 'required',
    ]);

    $item->update([
        'title' => $request->title,
        'description' => $request->description,
        'category' => $request->category,
        'location_name' => $request->location_name,
        'status' => $request->status,
    ]);
    if($request->hasFile('images')){

    // 古い画像削除
    foreach($item->images as $image){

        Storage::disk('public')->delete($image->path);

        $image->delete();

    }

    // 新しい画像保存
    foreach($request->file('images') as $file){

        $path=$file->store('items','public');

        Image::create([
            'item_post_id'=>$item->id,
            'path'=>$path,
        ]);

    }

}

    return redirect()
        ->route('marketplace.show', $item)
        ->with('success', 'Item updated successfully!');
}
        
}