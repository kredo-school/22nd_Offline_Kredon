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
@endphp

{{-- {{ dd($amenityIcons) }} --}}

<div class="col">
    <div class="card h-100 shadow-sm border-0 review-card" data-title="{{ $review->title }}"
        data-user="{{ $review->user->name ?? 'User' }}" data-rating="{{ $review->rating }}"
        data-date="{{ $review->created_at->format('Y/m/d') }}" data-comment='{{ e($review->comment) }}'
        data-amenities='{{ json_encode($review->amenities ?? []) }}'
        data-images='{{ json_encode($review->images->pluck('image_path')->map(fn($p) => asset('storage/' . $p))->values()) }}'
        onclick="showPreview(this)">

        <div class="card-body p-3">

            {{-- Header --}}
            <div class="d-flex align-items-start justify-content-between mb-2">

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-secondary rounded-circle" style="width:30px;height:30px;"></div>

                    <div>
                        <span class="fw-bold small d-block">
                            {{ $review->user->name ?? 'User' }}
                        </span>

                        <div class="text-warning small">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
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
                                        data-title="{{ $review->title }}" data-comment="{{ $review->comment }}"
                                        data-rating="{{ $review->rating }}" data-amenities='@json($review->amenities ?? [])'
                                        data-images='@json($review->images->pluck("image_path") ?? [])'
                                        data-location-name="A Co-working Space (Ayala)"
                                        data-location-address="12375, Cebu, Philippines" data-location-rating="4.8"
                                        data-location-img="{{ $review->images->first()?->image_path ?? '' }}">
                                        Edit
                                    </a>
                                </li>

                                <li>
                                    <form action="{{ route('all_reviews.destroy', $review->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this review?')">
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
            <h6 class="card-title fw-bold mb-1 text-truncate">
                {{ $review->title }}
            </h6>

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
