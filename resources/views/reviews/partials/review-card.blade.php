<style>
    .review-icon i {
        font-size: 0.75rem;
        color: #5c9ad0;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
        font-style: italic;
    }
</style>

@php
    $amenityIcons = [
        'wifi' => 'fa-wifi',
        'outlet' => 'fa-plug',
        'air-conditioner' => 'fa-snowflake',
        'parking' => 'fa-parking',
        'toilet' => 'fa-restroom',
        'accessibility' => 'fa-wheelchair',
        'food' => 'fa-utensils',
        'drink' => 'fa-cocktail',
        // 他のアメニティとアイコンのマッピングもここに追加
    ];

    $categoryIcons = [
        'working' => 'fa-briefcase',
        'tourism' => 'fa-map-pin',
    ];
@endphp

<div class="col">
    <div class="card h-100 shadow-sm border-0 review-card" data-title="{{ $review->title }}"
        data-user="{{ $review->user->name ?? 'User' }}" data-rating="{{ $review->rating }}"
        data-date="{{ $review->created_at->format('Y/m/d') }}" data-comment='{{ e($review->comment) }}'
        data-amenities='{{ json_encode($review->amenities ?? []) }}'
        data-images='{{ json_encode($review->images->pluck('image_path')->map(fn($p) => asset('storage/' . $p))->values()) }}'
        data-detail-url="{{ $review->detail_url ?? '#' }}" onclick="showPreview(this)">

        <div class="card-body p-3">

            {{-- Header --}}
            <div class="d-flex align-items-start justify-content-between mb-2">

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-secondary rounded-circle" style="width:30px;height:30px;"></div>

                    <div>
                        <span class="fw-bold small d-block">
                            {{ $review->user->name ?? 'User' }}
                        </span>

                        <div class="text-warning small d-flex align-items-center gap-1">
                            <i class="fa-solid fa-star"></i>
                            <span class="fw-bold">{{ number_format($review->rating, 1) }}</span>
                        </div>
                    </div>
                </div>

                {{-- menu --}}
                @auth
                    @if (auth()->id() === $review->user_id)
                        <div class="dropdown" onclick="event.stopPropagation()">
                            <button class="btn btn-sm btn-light border-0 rounded-circle p-1" type="button"
                                data-bs-toggle="dropdown">

                                <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end" onclick="event.stopPropagation()">
                                <li>
                                    <a href="#" class="dropdown-item edit-review-btn" data-bs-toggle="modal"
                                        data-bs-target="#editReviewModal" data-id="{{ $review->id }}"
                                        data-source="{{ $review->source }}" data-title="{{ $review->title }}" 
                                        data-comment="{{ $review->comment }}"  data-rating="{{ $review->rating }}" 
                                        data-amenities='@json($review->source === 'all_review' ? $review->amenities ?? [] : [])' 
                                        data-images='@json($review->source === 'all_review' ? $review->images->pluck('image_path') : [])' 
                                        data-good-point="{{ $review->good_point ?? '' }}" 
                                        data-bad-point="{{ $review->bad_point ?? '' }}" 
                                        data-customer-vibe="{{ $review->customer_vibe ?? '' }}" 
                                        data-eye-fatigue-level="{{ $review->eye_fatigue_level ?? '' }}" 
                                        data-chair-comfort="{{ $review->chair_comfort ?? '' }}" 
                                        data-desk-stability="{{ $review->desk_stability ?? '' }}" 
                                        data-photo="{{ $review->raw_photo_path ?? '' }}">
                                        Edit
                                    </a>
                                </li>

                                <li>
                                    <form
                                        action="{{ $review->source === 'all_review' ? route('all_reviews.destroy', $review->id) : ($review->source === 'working' ? route('reviews.destroy', $review->id) : route('tourist_reviews.destroy', $review->id)) }}"
                                        method="POST" onsubmit="return confirm('Delete this review?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="dropdown-item text-danger">
                                            Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endauth

            </div>

            {{-- title --}}
            <div class="d-flex align-items-center gap-2 mb-1">
                @if (isset($categoryIcons[$review->category]))
                    <span class="badge rounded-pill text-bg-light border">
                        <i class="fa-solid {{ $categoryIcons[$review->category] }}"></i>
                    </span>
                @endif
                <h6 class="card-title fw-bold mb-0 text-truncate">
                    {{ $review->title }}
                </h6>
            </div>

            {{-- date + amenities --}}
            <div class="d-flex align-items-center gap-2 mb-2">

                <small class="text-muted mb-0">
                    <i class="fa-regular fa-calendar me-1"></i>
                    {{ $review->created_at->format('Y/m/d') }}

                    {{-- If the post will be edited --}}
                    @if ($review->updated_at->gt($review->created_at->addMinute()))
                        <span class="text-muted" style="font-size: 0.7rem;">(Edited)</span>
                    @endif
                </small>

                @if (!empty($review->amenities))
                    <div class="review-icon d-flex gap-2 ms-auto">
                        @foreach ($review->amenities as $amenity)
                            @if (isset($amenityIcons[$amenity]))
                                <i class="fa-solid {{ $amenityIcons[$amenity] }}" title="{{ $amenity }}"></i>
                            @endif
                        @endforeach
                    </div>
                @endif

            </div>

            {{-- comment --}}
            <p class="card-text text-muted small text-truncate-2">
                {{ Str::limit($review->comment, 60) }}
            </p>

            {{-- image --}}
            <div class="position-relative ratio ratio-16x9 rounded overflow-hidden bg-light">

                @if ($review->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $review->images->first()->image_path) }}"
                        class="img-fluid object-fit-cover">
                @else
                    <div class="d-flex align-items-center justify-content-center">
                        No Image
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
