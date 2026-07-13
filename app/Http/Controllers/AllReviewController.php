<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\AllReview;

use App\Services\ReviewAggregator;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AllReviewController extends Controller
{
    private $review;
    private ReviewAggregator $aggregator;

    public function __construct(AllReview $review, ReviewAggregator $aggregator)
    {
        $this->review = $review;
        $this->aggregator = $aggregator;
    }

    // 一覧表示 categoryごとにタブで分ける
    public function index()
    {
        $merged = $this->aggregator->getMerged();

        return view('reviews.index', [
            'all_reviews'     => $merged,
            'working_reviews' => $merged->where('category', 'working')->values(),
            'tourism_reviews' => $merged->where('category', 'tourism')->values(),
        ]);
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
            'amenities'   => 'nullable|array',
            'amenities.*' => 'string|in:wifi,outlet,air-conditioner,parking,toilet',
            'images'    => 'nullable|array|max:5',
            'images.*'  => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $review = AllReview::create([
            'user_id'        => Auth::id(),
            'location_id'    => $request->location_id,
            'title'          => $request->title,
            'comment'        => $request->comment,
            'rating'         => $request->rating,
            'amenities'   => $request->amenities ?? [],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review_images', 'public');
                $review->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('all_reviews.index')->with('success', 'Review created successfully!');
    }

    #SPOT検索API
    public function searchLocations(Request $request)
    {
        $keyword = $request->get('q', '');
        $type = $request->get('type', 'working');

        $query = $type === 'tourism'
            ? \App\Models\TouristSpot::query()
            : \App\Models\Spot::query();

        $query->where('status', 'published');

        if ($keyword !== '') {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        $results = $query->limit(20)->get(['id', 'name', 'area'])
            ->map(fn($s) => [
                'id'      => $s->id,
                'name'    => $s->name,
                'address' => $s->area,
            ]);

        return response()->json($results);
    }

    public function edit(AllReview $review): View
    {
        abort_if(Auth::id() !== $review->user_id, 403);
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, AllReview $review): RedirectResponse
    {
        abort_if(Auth::id() !== $review->user_id, 403);

        $request->validate([
            'title'           => 'required|string|max:255',
            'comment'         => 'required|string',
            'rating'          => 'required|integer|min:1|max:5',
            'amenities'       => 'nullable|array',
            'amenities.*'     => 'string|in:wifi,outlet,air-conditioner,parking,toilet',
            'images'          => 'nullable|array|max:5',
            'images.*'        => 'image|mimes:jpeg,png,jpg|max:2048',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'nullable|string',
        ]);

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

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review_images', 'public');
                $review->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('all_reviews.index')->with('success', 'Review updated!');
    }

    public function destroy(AllReview $review): RedirectResponse
    {
        abort_if(Auth::id() !== $review->user_id, 403);

        foreach ($review->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $review->delete();

        return redirect()->route('all_reviews.index')->with('success', 'Review deleted!');
    }
}
