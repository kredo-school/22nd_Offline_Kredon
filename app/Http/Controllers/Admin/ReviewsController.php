<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReviewAggregator;
use App\Models\AllReview;
use App\Models\Review;
use App\Models\TouristReview;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index(Request $request, ReviewAggregator $aggregator)
    {
        $merged = $aggregator->getMerged();

        // カテゴリ絞り込み（working / tourism）
        if ($category = $request->get('category')) {
            $merged = $merged->where('category', $category);
        }

        // 検索（本文・ユーザー名・対象名）
        if ($keyword = $request->get('q')) {
            $merged = $merged->filter(
                fn($r) =>
                str_contains($r->comment ?? '', $keyword) ||
                    str_contains($r->user->name ?? '', $keyword) ||
                    str_contains($r->title ?? '', $keyword)
            );
        }

        // ステータス絞り込み
        if ($status = $request->get('status')) {
            $merged = $merged->where('status', $status);
        }

        $reviews = $merged; // 必要ならここで ->forPage(...) 等のページネーションを実装

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'counts' => [
                'all'     => $merged->count(),
                'working' => $merged->where('category', 'working')->count(),
                'tourism' => $merged->where('category', 'tourism')->count(),
                'pending' => $merged->where('status', 'unpublished')->count(),
            ],
        ]);
    }

    // ステータス切替のみ実装
    public function updateStatus(Request $request, string $source, int $id)
    {
        $request->validate(['status' => 'required|in:published,unpublished']);

        $model = match ($source) {
            'all_review' => AllReview::findOrFail($id),
            'working'    => Review::findOrFail($id),
            'tourism'    => TouristReview::findOrFail($id),
            default      => abort(404),
        };

        $model->update(['status' => $request->status]);

        return response()->json(['status' => $model->status]);
    }
}
