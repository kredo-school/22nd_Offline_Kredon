@extends('layouts.app')

@section('title', 'Review')

@section('content')

   <style>
       /* min-heightは　overflowへの許可 */
    .review-wrapper {
        display: flex;
        height: 100%;
        flex-direction: row;
        min-height: 0;
        overflow: hidden;
    }

    .main-content {
        flex: 1;
        overflow-y: auto;
        min-height: 0;
        min-width: 0;
        background-color: #f8f9fa;
    }

    .sidebar-right {
        height: 100%;
        width: 280px;
        flex-shrink: 0;
        overflow-y: auto;
        min-height: 0;
        background-color: #f7f5f0;
        border-left: 1px solid #e9ecef;
        padding: 20px;
    }

    h5 {
        margin-top: 0;
    }

    #categoryTab .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        background-color: transparent;
        font-size: 0.9rem;
        color: #6c757d;
        transition: all 0.2s ease;
    }

    #categoryTab .nav-link.active {
        border-bottom: 2px solid rgb(19, 189, 189);
        color: rgb(19, 189, 189) !important;
        background-color: transparent;
    }

    #categoryTab .nav-link.active i {
        color: rgb(19, 189, 189) !important;
    }

    #categoryTab .nav-link:hover {
        border-bottom: 2px solid rgb(19, 189, 189);
        color: rgb(19, 189, 189);
    }

    .review-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .review-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important;
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .preview-amenities {
        font-size: 0.9rem;
        color: #5c9ad0;
    }
</style>

    {{-- <div class="container-fluid px-0 review-wrapper"> --}}
    <div class="review-wrapper">

        {{-- ────────【中央】Review カラム ──────── --}}
        <div class="main-content px-4 pt-3">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="h3 mb-0 fw-bold">Search the reviews</h5>
                <button class="btn text-white px-3 py-2 fw-bold" style="background-color: #117a8b; border-radius: 8px;"
                    data-bs-toggle="modal" data-bs-target="#postReviewModal">
                    <i class="fa-solid fa-plus me-1"></i>Post New Review
                </button>
            </div>

         {{-- 検索フォーム --}}
            <div class="card border-0 bg-transparent mb-4">
                <form class="d-flex w-100" onsubmit="return false;">
                    <div class="input-group shadow-sm" style="border-radius: 30px; max-width: 600px;">
                        <span class="input-group-text bg-white border-0"
                            style="border-top-left-radius: 30px; border-bottom-left-radius: 30px;">
                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        </span>
                        <input id="reviewSearchInput" class="form-control bg-white border-0" type="search"
                            placeholder="Search the title or key words..."
                            style="border-top-right-radius: 30px; border-bottom-right-radius: 30px;"
                            oninput="filterReviews(this.value)">
                    </div>
                </form>
            </div>

            <script>
                function filterReviews(keyword) {
                    const cards = document.querySelectorAll('.review-card');
                    const chars = [...keyword.trim()].filter(c => c !== ''); // 入力文字を1文字ずつ配列化

                    cards.forEach(card => {
                        const col = card.closest('.col'); // グリッドのラッパーごと表示/非表示
                        const title = (card.dataset.title || '').toLowerCase();
                        const comment = (card.dataset.comment || '').toLowerCase();
                        const target = title + comment;

                        // キーワードが空なら全件表示
                        if (chars.length === 0) {
                            col.style.display = '';
                            return;
                        }

                        // タイトル or コメントに、入力した文字のうち1文字でも含まれていればヒット
                        const isMatch = chars.some(c => target.includes(c.toLowerCase()));

                        col.style.display = isMatch ? '' : 'none';
                    });
                }
            </script>

            {{-- カテゴリータブメニュー --}}
            <ul class="nav nav-tabs border-bottom mb-4" id="categoryTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-3 py-2" id="all-tab" data-bs-toggle="tab"
                        data-bs-target="#all-contents" type="button" role="tab" aria-selected="true">
                        <i class="fa-solid fa-table-cells-large me-2"></i>【All】
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-3 py-2" id="working-tab" data-bs-toggle="tab"
                        data-bs-target="#working-contents" type="button" role="tab" aria-selected="false">
                        <i class="fa-solid fa-briefcase me-2"></i>【Working Place】
                    </button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-3 py-2" id="hospital-tab" data-bs-toggle="tab"
                        data-bs-target="#hospital-contents" type="button" role="tab" aria-selected="false">
                        <i class="fa-solid fa-hospital me-2"></i>【Hospital】
                    </button>
                </li> --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold px-3 py-2" id="tourism-tab" data-bs-toggle="tab"
                        data-bs-target="#tourism-contents" type="button" role="tab" aria-selected="false">
                        <i class="fa-solid fa-map-pin me-2"></i>【Tourism】
                    </button>
                </li>
            </ul>

            {{-- タブ切り替えコンテンツエリア --}}
            <div class="tab-content pb-5" id="categoryTabContent">

                {{-- 1. All タブ --}}
                <div class="tab-pane fade show active" id="all-contents" role="tabpanel" aria-labelledby="all-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($all_reviews as $review)
                            @include('reviews.partials.review-card', [
                                'review' => $review,
                                // 'amenityIcons' => $amenityIcons,
                            ])
                        @endforeach
                    </div>
                </div>

                {{-- 2. Working Place タブ --}}
                <div class="tab-pane fade" id="working-contents" role="tabpanel" aria-labelledby="working-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($working_reviews->filter(fn($r) => \Str::contains($r->title . $r->comment, ['Working', 'Work', 'Office', 'Coworking'])) as $review)
                            @include('reviews.partials.review-card', [
                                'review' => $review,
                                // 'amenityIcons' => $amenityIcons,
                            ])
                        @endforeach
                    </div>
                </div>

                {{-- 3. Hospital タブ --}}
                {{-- <div class="tab-pane fade" id="hospital-contents" role="tabpanel" aria-labelledby="hospital-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($hospital_reviews->filter(fn($r) => \Str::contains($r->title . $r->comment, ['Hospital', 'Clinic', 'Medical'])) as $review)
                            @include('reviews.partials.review-card', [
                                'review' => $review,
                                // 'amenityIcons' => $amenityIcons,
                            ])
                        @endforeach
                    </div>
                </div> --}}

                {{-- 4. Tourism タブ --}}
                <div class="tab-pane fade" id="tourism-contents" role="tabpanel" aria-labelledby="tourism-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($tourism_reviews->filter(fn($r) => \Str::contains($r->title . $r->comment, ['Beach', 'Tourism', 'Spot', 'Tourist'])) as $review)
                            @include('reviews.partials.review-card', [
                                'review' => $review,
                                // 'amenityIcons' => $amenityIcons,
                            ])
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- ────────【右】Preview details カラム ──────── --}}
        <div class="sidebar-right d-none d-md-block">
            <div id="preview-default-message" class="d-flex align-items-center justify-content-center h-100">
                <p class="text-muted text-center small">
                    Details of the selected review will be displayed here
                </p>
            </div>

            <div id="preview-details-content" class="d-none">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h6 class="h5 fw-bold mb-0" style="color: #495057;">Preview Details</h6>
                    <button type="button" class="btn-close" onclick="closePreview()"></button>
                </div>

                <div class="mb-2">
                    <h5 id="preview-title" class="fw-bold mb-1"></h5>
                    <small id="preview-meta" class="text-muted"></small>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <div id="preview-stars" class="text-warning me-2"></div>
                    <span id="preview-rating-val" class="fw-bold"></span>
                </div>

                {{-- amenity icon --}}
                <div class="d-flex flex-wrap gap-2 mb-3" id="preview-amenities"></div>

                <p id="preview-comment" class="small text-secondary mb-4"
                    style="white-space: pre-wrap; line-height: 1.6;"></p>

                {{-- preview carousel    --}}
                <div id="reviewCarousel" class="carousel slide mb-4 shadow-sm rounded overflow-hidden"
                    data-bs-ride="false">
                    <div class="carousel-indicators mb-0" id="carousel-indicators"></div>

                    <div class="carousel-inner" id="carousel-items-container"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="d-grid gap-2">
                    <a href="#" id="preview-detail-btn" class="btn text-white fw-bold btn-sm py-2"
                        style="background-color: rgb(19, 189, 189); border:none;">Spot Details</a>
                    <button class="btn btn-outline-secondary btn-sm py-2">Directions to this location</button>
                </div>
            </div>
        </div>


    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        function showPreview(element) {
            document.getElementById('preview-default-message').classList.add('d-none');
            document.getElementById('preview-details-content').classList.remove('d-none');

            const title = element.getAttribute('data-title');
            const user = element.getAttribute('data-user');
            const rating = parseInt(element.getAttribute('data-rating'));
            const date = element.getAttribute('data-date');
            const comment = element.getAttribute('data-comment');
            const images = JSON.parse(element.getAttribute('data-images'));

            document.getElementById('preview-title').innerText = title;
            document.getElementById('preview-meta').innerText = `by ${user} - ${date}`;
            document.getElementById('preview-rating-val').innerText = `${rating}.0/5`;
            document.getElementById('preview-comment').innerText = comment;

            // アメニティアイコン
            const amenities = JSON.parse(element.getAttribute('data-amenities') || '[]');
            const amenityIconMap = {
                'wifi': 'fa-wifi',
                'outlet': 'fa-plug',
                'air-conditioner': 'fa-snowflake',
                'parking': 'fa-square-parking',
                'toilet': 'fa-restroom',
            };
            const amenitiesContainer = document.getElementById('preview-amenities');
            amenitiesContainer.innerHTML = '';
            if (amenities.length > 0) {
                amenities.forEach(amenity => {
                    const icon = amenityIconMap[amenity];
                    if (icon) {
                        amenitiesContainer.innerHTML += `
                <span class="d-flex align-items-center gap-1 badge rounded-pill text-bg-light border small">
                    <i class="fa-solid ${icon} text-secondary"></i>
                    <span class="text-secondary">${amenity}</span>
                </span>`;
                    }
                });
                amenitiesContainer.classList.remove('d-none');
            } else {
                amenitiesContainer.classList.add('d-none');
            }

            let starHtml = '';
            for (let i = 1; i <= 5; i++) {
                starHtml += `<i class="fa-${i <= rating ? 'solid' : 'regular'} fa-star"></i>`;
            }
            document.getElementById('preview-stars').innerHTML = starHtml;

            const container = document.getElementById('carousel-items-container');
            container.innerHTML = '';

            const indicators = document.getElementById('carousel-indicators');
            indicators.innerHTML = '';

            if (images.length > 0) {
                document.getElementById('reviewCarousel').classList.remove('d-none');

                images.forEach((imgUrl, index) => {
                    const activeClass = index === 0 ? 'active' : '';
                    container.innerHTML += `
                    <div class="carousel-item ${activeClass}">
                        <div class="ratio ratio-16x9">
                            <img src="${imgUrl}" class="d-block w-100 object-fit-cover" alt="Preview Image">
                        </div>
                    </div>`;
                });

                if (images.length > 1) {
                    images.forEach((_, index) => {
                        indicators.innerHTML += `
                        <button type="button" data-bs-target="#reviewCarousel" data-bs-slide-to="${index}"
                            class="${index === 0 ? 'active' : ''}" aria-label="Slide ${index + 1}"></button>`;
                    });
                    indicators.classList.remove('d-none');
                } else {
                    indicators.classList.add('d-none');
                }

            } else {
                document.getElementById('reviewCarousel').classList.add('d-none');
                indicators.classList.add('d-none');
            }
        }

        function closePreview() {
            document.getElementById('preview-default-message').classList.remove('d-none');
            document.getElementById('preview-details-content').classList.add('d-none');
        }
    </script>
    @include('reviews.post-modal')
    @include('reviews.edit-modal')
@endsection
