<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\AllReview;
use App\Models\Review;
use App\Models\TouristReview;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AllReviewController extends Controller
{
    private $review;

    public function __construct(AllReview $review)
    {
        $this->review = $review;
    }


    // 一覧表示 categoryごとにタブで分ける
    public function index()
    {
        $allReviews = AllReview::with(['user', 'images'])->get()
            ->map(fn($r) => $this->normalizeAllReview($r));

        $workingReviews = Review::with(['user', 'spot'])->get()
            ->map(fn($r) => $this->normalizeWorkingReview($r));

        $touristReviews = TouristReview::with(['user', 'touristSpot'])->get()
            ->map(fn($r) => $this->normalizeTouristReview($r));

        $merged = $allReviews
            ->concat($workingReviews)
            ->concat($touristReviews)
            ->sortByDesc('created_at')
            ->values();

        return view('reviews.index', [
            'all_reviews'     => $merged,
            'working_reviews' => $merged->where('category', 'working')->values(),
            'tourism_reviews' => $merged->where('category', 'tourism')->values(),
        ]);
    }

    // ① all_reviews（ダミー）
    private function normalizeAllReview($review)
    {
        $avg = $this->calcAverage([
            $review->customer_vibe,
            $review->eye_fatigue_level,
            $review->chair_comfort,
            $review->desk_stability,
        ]) ?: $review->rating; // 評価軸が未入力なら旧ratingにフォールバック

        return (object) [
            'source'      => 'all_review',
            'id'          => $review->id,
            'user_id'     => $review->user_id,
            'user'        => $review->user,
            'category'    => $this->detectCategory($review->title . ' ' . $review->comment),
            'title'       => $review->title,
            'rating'      => $avg,

            'comment'     => $review->comment,
            'amenities'   => $review->amenities ?? [],
            'images'      => $review->images,
            'created_at'  => $review->created_at,
            'updated_at'  => $review->updated_at,
            'detail_url'  => null,
        ];
    }

    // ② reviews（Working Spot 実データ）
    private function normalizeWorkingReview($review)
    {
        $images = $review->photo_path
            ? collect([(object) ['image_path' => $review->photo_path]])
            : collect();

        // ★ スポット自体の設備情報からアイコンを連動
        $amenities = array_values(array_filter([
            $review->spot?->has_wifi  ? 'wifi'    : null,
            $review->spot?->has_power ? 'outlet'  : null,
        ]));

        $avg = $this->calcAverage([
            $review->customer_vibe,
            $review->eye_fatigue_level,
            $review->chair_comfort,
            $review->desk_stability,
        ]) ?: $review->rating;

        return (object) [
            'source'      => 'working',
            'id'          => $review->id,
            'user_id'     => $review->user_id,
            'user'        => $review->user,
            'category'    => 'working',
            'title'       => $review->spot->name ?? 'Working Spot', // ★元投稿（Spot）のタイトル
            'rating'      => $avg,
            'comment'     => $review->comment,

            'good_point'  => $review->good_point,
            'bad_point'   => $review->bad_point,
            'customer_vibe'     => $review->customer_vibe,
            'eye_fatigue_level' => $review->eye_fatigue_level,
            'chair_comfort'     => $review->chair_comfort,
            'desk_stability'    => $review->desk_stability,
            'raw_photo_path'    => $review->photo_path,

            'amenities'   => $amenities,
            'images'      => $images,
            'created_at'  => $review->created_at,
            'updated_at'  => $review->updated_at,
            'detail_url'  => $review->spot ? route('spots.show', $review->spot->id) : null,
        ];
    }

    // ③ tourist_reviews（Tourist Spot 実データ）
    private function normalizeTouristReview($review)
    {
        return (object) [
            'source'      => 'tourism',
            'id'          => $review->id,
            'user_id'     => $review->user_id,
            'user'        => $review->user,
            'category'    => 'tourism',
            'title'       => $review->touristSpot->name ?? 'Tourist Spot', // ★元投稿のタイトル
            'rating'      => (float) $review->rating,
            'comment'     => $review->comment,
            'amenities'   => [],
            'images'      => collect(),
            'created_at'  => $review->created_at,
            'updated_at'  => $review->updated_at,
            'detail_url'  => $review->touristSpot ? route('tourist_spots.show', $review->touristSpot->id) : null,
        ];
    }

    // amenities' counted stars
    private function calcAverage(array $scores): float
    {
        $scores = array_filter($scores, fn($v) => $v !== null);
        if (empty($scores)) {
            return 0;
        }
        return round(array_sum($scores) / count($scores), 1);
    }

    private function detectCategory(string $text): string
    {
        if (Str::contains($text, ['Working', 'Work', 'Office', 'Coworking', 'Remote', 'Freelance', 'Desk'])) {
            return 'working';
        }
        return 'tourism';
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

        $review = AllReview::create([
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

        return redirect()->route('all_reviews.index')->with('success', 'Review created successfully!');
    }

    #SPOT検索API
    public function searchLocations(Request $request)
    {
        $keyword = $request->get('q', '');
        $type = $request->get('type', 'working'); // 'working' | 'tourism'

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
        // 自分以外の投稿は４０３
        abort_if(Auth::id() !== $review->user_id, 403);
        return view('reviews.edit', compact('review'));
    }

    // Update
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

        return redirect()->route('all_reviews.index')->with('success', 'Review updated!');
    }

    // Delete
    public function destroy(AllReview $review): RedirectResponse
    {

        abort_if(Auth::id() !== $review->user_id, 403);
        // ① storageから画像ファイルを物理削除
        foreach ($review->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // ② DBのreviewを削除（cascade により review_imagesも自動削除）
        $review->delete();

        return redirect()->route('all_reviews.index')->with('success', 'Review deleted!');
    }
}
