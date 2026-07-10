<?php

namespace App\Http\Controllers;

use App\Models\ItemPost;
use App\Models\Notification;
use App\Models\Spot;
use App\Models\TouristSpot;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $category = $request->query('category', 'market');
        $sort     = $request->query('sort', 'newest');

        if ($category === 'market') {
            $sort = 'newest';
        }

        $posts = $this->fetchFeedItems($category, $sort, $request->query('keyword'));

        return view('home', [
            'posts'         => $posts,
            'announcements' => $this->fetchAnnouncements(),
            'banners'       => $this->fetchHeroBanners(),
        ]);
    }

    public function search(Request $request)
    {
        return redirect()->route('home', $request->only(['category', 'sort', 'keyword']));
    }

    private function fetchFeedItems(string $category, string $sort, ?string $keyword)
    {
        return match ($category) {
            'working'  => $this->fetchWorkingSpots($sort, $keyword),
            'hospital' => $this->fetchHospitals($sort, $keyword),
            'tourist'  => $this->fetchTouristSpots($sort, $keyword),
            default    => $this->fetchMarketItems($sort, $keyword),
        };
    }

    private function fetchMarketItems(string $sort, ?string $keyword)
    {
        $query = ItemPost::with(['user', 'images'])
            ->where('status', 'active');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%")
                    ->orWhere('location_name', 'LIKE', "%{$keyword}%");
            });
        }

        return $query->latest()
            ->paginate(12)->withQueryString()
            ->through(fn(ItemPost $item) => $this->normalizeItemPost($item));
    }

    private function fetchWorkingSpots(string $sort, ?string $keyword)
    {
        $query = Spot::with('user')
            ->where('status', 'published')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        match ($sort) {
            'ranking' => $query->withCount('bookmarks')->orderByDesc('bookmarks_count'),
            'reviews' => $query->orderByDesc('reviews_count'),
            default   => $query->latest(),
        };

        return $query->paginate(12)->withQueryString()
            ->through(fn(Spot $spot) => $this->normalizeSpot($spot, 'working'));
    }

    private function fetchTouristSpots(string $sort, ?string $keyword)
    {
        $query = TouristSpot::with('user')
            ->where('status', 'published')
            ->withCount(['reviews', 'bookmarks']);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        match ($sort) {
            'ranking' => $query->orderByDesc('bookmarks_count'),
            'reviews' => $query->orderByDesc('reviews_count'),
            default   => $query->latest(),
        };

        return $query->paginate(12)->withQueryString()
            ->through(fn(TouristSpot $spot) => $this->normalizeTouristSpot($spot));
    }

    private function fetchHospitals(string $sort, ?string $keyword)
    {
        $query = Hospital::where('status', 'published')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('address_en', 'LIKE', "%{$keyword}%");
            });
        }

        match ($sort) {
            'reviews' => $query->orderByDesc('reviews_count'),
            default   => $query->latest(),
        };

        return $query->paginate(12)->withQueryString()
            ->through(fn(Hospital $hospital) => $this->normalizeHospital($hospital));
    }

    private function normalizeItemPost(ItemPost $item): object
    {
        $imagePath = $item->images->first()?->path;

        return (object) [
            'user'        => $item->user,
            'created_at'  => $item->created_at,
            'title'       => $item->title,
            'description' => $item->description,
            'image_url'   => $imagePath ? asset('storage/' . ltrim($imagePath, '/')) : null,
            'url'         => route('marketplace.show', $item),
        ];
    }

    private function normalizeSpot(Spot $spot, string $spotCategory): object
    {
        $description = $spot->description
            ?: trim(($spot->area ?? '') . ' ' . ($spot->hours ?? ''));

        return (object) [
            'type'          => 'spot',
            'category'      => $spotCategory,
            'status'        => $spot->status,
            'rating_avg'    => $spot->reviews_avg_rating,
            'reviews_count' => $spot->reviews_count,
            'user'          => $spot->user,
            'created_at'    => $spot->created_at,
            'title'         => $spot->name,
            'description'   => $description ?: '—',
            'image_url'     => $spot->photo_path
                ? asset('storage/' . ltrim($spot->photo_path, '/'))
                : null,
            'url'           => route('spots.show', $spot->id),
        ];
    }
    private function normalizeTouristSpot(TouristSpot $spot): object
    {
        $description = trim(($spot->area ?? '') . ' ' . ($spot->budget ?? ''));

        return (object) [
            'type'          => 'spot',
            'category'      => 'tourist',
            'status'        => $spot->status,
            'rating_avg'    => $spot->reviews_avg_rating ?? null,
            'reviews_count' => $spot->reviews_count ?? null,
            'user'          => $spot->user,
            'created_at'    => $spot->created_at,
            'title'         => $spot->name,
            'description'   => $description ?: '—',
            'image_url'     => $spot->photo_path
                ? asset('storage/' . ltrim($spot->photo_path, '/'))
                : null,
            'url'           => route('tourist_spots.show', $spot->id),
        ];
    }

    private function normalizeHospital(Hospital $hospital): object
    {
        return (object) [
            'type'          => 'spot',
            'category'      => 'hospital',
            'status'        => $hospital->status,
            'rating_avg'    => $hospital->reviews_avg_rating,
            'reviews_count' => $hospital->reviews_count,
            'user'          => null,
            'created_at'    => $hospital->created_at,
            'title'         => $hospital->name,
            'description'   => $hospital->address_en ?: '—',
            'image_url'     => $hospital->images->first()?->path
                ? asset('storage/' . ltrim($hospital->images->first()->path, '/'))
                : null,
            'url'           => route('hospitals.show', $hospital->id),
        ];
    }

    private function fetchAnnouncements()
{
    $user = Auth::user();
    $isSubscriber = $user && (int) $user->role === 3;

    return Notification::query()
        ->where('status', 'sent')
        ->where(function ($q) use ($isSubscriber, $user) {
            $q->where('target_type', 'all');

            if ($isSubscriber) {
                $q->orWhere('target_type', 'subscriber');
            }

            if ($user) {
                $q->orWhere(function ($sub) use ($user) {
                    $sub->where('target_type', 'custom')
                        ->whereJsonContains('data->user_ids', $user->id);
                });
            }
        })
        ->orderByDesc('sent_at')
        ->limit(10)
        ->get()
        ->map(fn (Notification $notification) => (object) [
            'title'      => $notification->title,
            'category'   => $notification->category, // 追加
            'created_at' => $notification->sent_at ?? $notification->created_at,
            'image_url'  => $notification->data['image_url'] ?? null,
            'url'        => $notification->getUrl(),
        ]);
}

    private function fetchHeroBanners(): array
{
    // 固定のプロモーションバナー(常に表示)
    return [
        ['title' => 'Working Spots', 'path' => 'images/home_banner/working-place.jpg', 'url' => route('top')],
        ['title' => 'Market Place', 'path' => 'images/home_banner/market_banner.png.jpeg', 'url' => route('marketplace.index')],
        ['title' => 'Game', 'path' => 'images/kredon-game-home.png', 'url' => route('game.home')],
        ['title' => 'Tourist Spots', 'path' => 'images/home_banner/cave.jpeg', 'url' => route('tourist_spots.index')],
        ['title' => 'Community Reviews', 'path' => 'images/home_banner/community.jpg', 'url' => route('all_reviews.index')],
    ];
}
}
