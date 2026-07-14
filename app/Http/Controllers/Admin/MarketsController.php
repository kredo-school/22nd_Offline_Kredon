<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarketsController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemPost::with(['user'])
            ->withCount('comments');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('market_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->get('sort') === 'comments') {
            $query->orderByDesc('comments_count');
        } else {
            $query->latest();
        }

        $paginatedItems = $query->paginate(12)->withQueryString();

        $items = $paginatedItems->getCollection()
            ->map(fn(ItemPost $item) => $this->normalizeItem($item));

        // Admin/MarketController.php (near where $paginatedItems is built)

        $dummyComments = collect([
            [
                'id'        => 1,
                'text'      => 'How much for this? Is it still available?',
                'item_name' => 'T-shirt',
                'item_id'   => 1,
                'handle'    => '@juan_delacruz',
                'date'      => '2026-07-13 10:24',
                'status'    => 'Approved',
            ],
            [
                'id'        => 2,
                'text'      => 'Can I pick it up in person? Where are you located?',
                'item_name' => 'T shirts',
                'item_id'   => 3,
                'handle'    => '@maria_santos',
                'date'      => '2026-07-13 09:02',
                'status'    => 'Pending',
            ],
            [
                'id'        => 3,
                'text'      => 'This account is a scam, ignore it!! Click here -> bit.ly/xxxxx',
                'item_name' => 'p p p',
                'item_id'   => 2,
                'handle'    => '@spam_bot99',
                'date'      => '2026-07-12 22:47',
                'status'    => 'Spam',
            ],
            [
                'id'        => 4,
                'text'      => 'Is it still in good condition? Could you share a few more photos?',
                'item_name' => 'T-shirt',
                'item_id'   => 1,
                'handle'    => '@carlo_reyes',
                'date'      => '2026-07-12 18:15',
                'status'    => 'Approved',
            ],
            [
                'id'        => 5,
                'text'      => 'Can you hold it for me? I can come by this weekend.',
                'item_name' => 'Household Items',
                'item_id'   => 2,
                'handle'    => '@aimi_dela',
                'date'      => '2026-07-12 15:30',
                'status'    => 'Pending',
            ],
        ]);

        $page = request('comment_page', 1);
        $perPage = 10;

        $paginatedComments = new \Illuminate\Pagination\LengthAwarePaginator(
            $dummyComments->forPage($page, $perPage)->values(),
            $dummyComments->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'comment_page']
        );

        $comments = $paginatedComments->items();

        // コメント管理タブ用(本物のDB取得用)
        // $paginatedComments = \App\Models\MarketComment::with(['user', 'item'])
        //     ->latest()
        //     ->paginate(20, ['*'], 'comments_page');

        // $comments = $paginatedComments->getCollection()
        //     ->map(fn($comment) => $this->normalizeComment($comment));

        $metrics = [
            'total'   => ItemPost::count(),
            'flagged' => 0, // TODO: 通報テーブル実装後に接続
            'active'  => ItemPost::where('market_status', 'available')->count(),
            'sold'    => ItemPost::where('market_status', 'sold')->count(),
        ];

        return view('admin.markets.index', [
            'items'             => $items,
            'comments'          => $comments,
            'metrics'           => $metrics,
            'paginatedItems'    => $paginatedItems,
            'paginatedComments' => $paginatedComments,
        ]);
    }

    public function show(ItemPost $item)
    {
        $item->load(['images', 'user', 'comments.user']);

        return view('admin.markets.show', [
            'item' => $this->normalizeItemDetail($item),
        ]);
    }

    private function normalizeItem(ItemPost $item): array
    {
        return [
            'id'         => $item->id,
            'name'       => $item->title,
            'meta'       => $item->category . ' · ' . Str::limit($item->description, 30),
            'category'   => $item->category,
            'status'     => $this->mapStatus($item->market_status),
            'reports'    => 0,
            'views'      => 0,
            'icon'       => $this->mapIcon($item->category),
            'flagged'    => false,
            'user'       => $item->user->name ?? 'Unknown user',
            'comments'   => $item->comments_count ?? 0,
            'created_at' => $item->created_at?->format('Y-m-d H:i') ?? '-',
        ];
    }

    private function normalizeItemDetail(ItemPost $item): array
    {
        return [
            'id'          => $item->id,
            'name'        => $item->title,
            'category'    => $item->category,
            'condition'   => $item->status,
            'status'      => $this->mapStatus($item->market_status),
            'posted_at'   => $item->created_at?->format('Y-m-d H:i') ?? '-',
            'location'    => $item->location_name,
            'user'        => $item->user->name ?? 'Unknown',
            'handle'      => '@' . ($item->user->username ?? 'unknown'),
            'description' => $item->description,
            'images'      => $item->images->map(fn($img) => asset('storage/' . $img->path))->toArray(),
            'comments'    => $item->comments->map(fn($c) => [
                'user'   => $c->user->name ?? 'Unknown',
                'handle' => '@' . ($c->user->username ?? 'unknown'),
                'text'   => $c->comment,
                'date'   => $c->created_at?->format('Y-m-d H:i') ?? '-',
                'status' => 'Approved',
            ])->toArray(),
        ];
    }


    private function normalizeComment($comment): array
    {
        return [
            'text'      => $comment->comment,
            'item_name' => $comment->item->title ?? 'Deleted item',
            'item_id'   => $comment->item_post_id,
            'user'      => $comment->user->name ?? 'Unknown',
            'handle'    => '@' . ($comment->user->username ?? 'unknown'),
            'date'      => $comment->created_at->format('Y-m-d H:i'),
            'status'    => 'Approved',
        ];
    }

    private function mapStatus(?string $marketStatus): string
    {
        return match ($marketStatus) {
            'available' => 'Active',
            'sold'      => 'Sold',
            default     => 'Unknown',
        };
    }

    private function mapIcon(?string $category): string
    {
        return match ($category) {
            'Clothes'          => 'fa-shirt',
            'Skincare'         => 'fa-pump-soap',
            'Household Items'  => 'fa-house',
            'Stationery'       => 'fa-pen',
            'Medicine'         => 'fa-pills',
            'Fashion', 'ファッション' => 'fa-shirt', // 既存の古いデータ対応
            default            => 'fa-box',
        };
    }
}
