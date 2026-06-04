<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    private $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    // 一覧表示 categoryごとにタブで分ける
    public function index()
    {
        $all_reviews = Review::with(['user', 'images'])
            ->latest()
            ->get();

        $working_reviews = $all_reviews->filter(function ($review) {
            return Str::contains(
                $review->title . ' ' . $review->comment,
                ['Working', 'Work', 'Office', 'Coworking', 'Remote', 'Freelance', 'Productivity', 'Focus', 'Quiet', 'Space', 'Desk']
            );
        });

        $hospital_reviews = $all_reviews->filter(function ($review) {
            return Str::contains(
                $review->title . ' ' . $review->comment,
                ['Hospital', 'Clinic', 'Medical', 'Doctor', 'Healthcare', 'Nurse', 'Treatment', 'Surgery', 'Pharmacy']
            );
        });

        $tourism_reviews = $all_reviews->filter(function ($review) {
            return Str::contains(
                $review->title . ' ' . $review->comment,
                ['Beach', 'Tourism', 'Spot', 'Tourist', 'Sightseeing', 'Attraction', 'Ocean', 'Mountain', 'Park', 'Museum','Travel','Vacation','Resort','Nature','Adventure','Hiking','Camping','Landmark','Historical','Cultural']
            );
        });

        return view('reviews.index', compact(
            'all_reviews',
            'working_reviews',
            'hospital_reviews',
            'tourism_reviews'
        ));
    }

    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|integer|min:1',
            'title'     => 'required|string|max:255',
            'comment'   => 'required|string',
            'rating'    => 'required|integer|min:1|max:5',
            'amenities'   => 'nullable|array',              // ★ 追加
            'amenities.*' => 'string|in:wifi,outlet,air-conditioner,parking,toilet', // ★ 追加
            'images'    => 'nullable|array|max:5',
            'images.*'  => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $review = Review::create([
            'user_id'        => Auth::id(),
            'location_id'    => $request->location_id, //仮置き
            // 'category'       => $request->category,
            'title'          => $request->title,
            'comment'        => $request->comment,
            'rating'         => $request->rating,
            'amenities'   => $request->amenities ?? [],
        ]);

        //    画像の保存処理
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review_images', 'public');
                $review->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('reviews.index')->with('success', 'Review created successfully!');
    }

    #SPOT検索API
    public function searchLocations(Request $request)
    {
        $keyword = $request->get('q', '');

        #仮data
        $dummy = collect([
            ['id' => 1, 'name' => 'A Co-working Space(Ayala)', 'address' => '12345', 'category' => 'working', 'rating' => 4.5],
            ['id' => 2, 'name' => 'B Hospital', 'address' => '67890', 'category' => 'hospital', 'rating' => 4.0],
            ['id' => 3, 'name' => 'C Tourism Spot', 'address' => '54321', 'category' => 'tourism', 'rating' => 4.8],
        ]);

        $results = $keyword ? $dummy->filter(fn($l) => str_contains(strtolower($l['name']), strtolower($keyword)))->values() : $dummy;

        return response()->json($results);
    }

    public function edit(Review $review): View
    {
        // 自分以外の投稿は４０３
        abort_if(Auth::id() !== $review->user_id, 403);
        return view('reviews.edit', compact('review'));
    }

    // Update
    public function update(Request $request, Review $review): RedirectResponse
{
    // dd($request->all());
    // 送信されたdelete_imagesとDBのimage_pathを比較
    // dd([
    //     'delete_images' => $request->delete_images,
    //     'db_image_paths' => $review->images->pluck('image_path'),
    // ]);

    abort_if(Auth::id() !== $review->user_id, 403);

    $request->validate([
        'title'           => 'required|string|max:255',
        'comment'         => 'required|string',
        'rating'          => 'required|integer|min:1|max:5',
        'amenities'       => 'nullable|array',
        'amenities.*'     => 'string|in:wifi,outlet,air-conditioner,parking,toilet',
        'images'          => 'nullable|array|max:5',
        'images.*'        => 'image|mimes:jpeg,png,jpg|max:2048',
        'delete_images'   => 'nullable|array',   // ★ 追加
        'delete_images.*' => 'nullable|string',  // ★ 追加
    ]);

    // ★ 既存画像の削除
    if ($request->has('delete_images')) {
        foreach ($request->delete_images as $path) {
            $image = $review->images()->where('image_path', $path)->first();
         
            if ($image) {
                Storage::disk('public')->delete($path);
                $image->delete();
            }
        }
    }

    $review->update([
        'location_id' => $request->location_id ?? $review->location_id,
        'title'       => $request->title,
        'comment'     => $request->comment,
        'rating'      => $request->rating,
        'amenities'   => $request->amenities ?? [],
    ]);

    // 新規画像の追加
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('review_images', 'public');
            $review->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('reviews.index')->with('success', 'Review updated!');
}

    // Delete
    public function destroy(Review $review): RedirectResponse
    {
        abort_if(Auth::id() !== $review->user_id, 403);
        // ① storageから画像ファイルを物理削除
        foreach ($review->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // ② DBのreviewを削除（cascade により review_imagesも自動削除）
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review deleted!');
    }

    
}
