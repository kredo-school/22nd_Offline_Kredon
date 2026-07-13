<?php

namespace App\Services;

use App\Models\AllReview;
use App\Models\Review;
use App\Models\TouristReview;
use Illuminate\Support\Str;

class ReviewAggregator
{
    public function getMerged()
    {
        $allReviews = AllReview::with(['user', 'images'])->get()
            ->map(fn($r) => $this->normalizeAllReview($r));

        $workingReviews = Review::with(['user', 'spot'])->get()
            ->map(fn($r) => $this->normalizeWorkingReview($r));

        $touristReviews = TouristReview::with(['user', 'touristSpot'])->get()
            ->map(fn($r) => $this->normalizeTouristReview($r));

        return $allReviews->concat($workingReviews)->concat($touristReviews)
            ->sortByDesc('created_at')->values();
    }

    private function normalizeAllReview($review)
    {
        $avg = $this->calcAverage([
            $review->customer_vibe,
            $review->eye_fatigue_level,
            $review->chair_comfort,
            $review->desk_stability,
        ]) ?: $review->rating;

        return (object) [
            'source'      => 'all_review',
            'id'          => $review->id,
            'user_id'     => $review->user_id,
            'user'        => $review->user,
            'category'    => $this->detectCategory($review->title . ' ' . $review->comment),
            'title'       => $review->title,
            'rating'      => $avg,
            'status'      => $review->status,
            'comment'     => $review->comment,
            'amenities'   => $review->amenities ?? [],
            'images'      => $review->images,
            'created_at'  => $review->created_at,
            'updated_at'  => $review->updated_at,
            'detail_url'  => null,
        ];
    }

    private function normalizeWorkingReview($review)
    {
        $images = $review->photo_path
            ? collect([(object) ['image_path' => $review->photo_path]])
            : collect();

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
            'title'       => $review->spot->name ?? 'Working Spot',
            'rating'      => $avg,
            'status'      => $review->status,
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

    private function normalizeTouristReview($review)
    {
        return (object) [
            'source'      => 'tourism',
            'id'          => $review->id,
            'user_id'     => $review->user_id,
            'user'        => $review->user,
            'category'    => 'tourism',
            'title'       => $review->touristSpot->name ?? 'Tourist Spot',
            'rating'      => (float) $review->rating,
            'status'      => $review->status,
            'comment'     => $review->comment,
            'amenities'   => [],
            'images'      => collect(),
            'created_at'  => $review->created_at,
            'updated_at'  => $review->updated_at,
            'detail_url'  => $review->touristSpot ? route('tourist_spots.show', $review->touristSpot->id) : null,
        ];
    }

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
}