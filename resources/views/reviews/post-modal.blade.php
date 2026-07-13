<style>
    .amenity-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 75px;
        padding: 8px 6px;
        border-radius: 12px;
        border: 2px solid #dee2e6;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        background: #fff;
    }

    .star-btn {
        font-size: 1.2rem;
        color: #dee2e6;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star-btn.star-lit {
        color: #ffc107;
    }

    .axis-btn.active {
        background-color: #13bdbd !important;
        border-color: #13bdbd !important;
        color: #fff !important;
    }

    .category-toggle .btn-check:checked+label {
        background-color: #13bdbd;
        border-color: #13bdbd;
        color: #fff;
    }
</style>

<div class="modal fade" id="postReviewModal" tabindex="-1" aria-labelledby="postReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-sm">

            {{-- Header --}}
            <div class="modal-header py-1">
                <h5 class="modal-title fw-bold" id="postReviewModalLabel">Post New Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body py-2">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="" method="post" enctype="multipart/form-data" id="reviewForm">
                    @csrf

                    <input type="hidden" name="location_id" id="selectedLocationId" value="0">

                    {{-- カテゴリー切り替え --}}
                    <div class="mb-3 category-toggle">
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="review_category" id="cat_working"
                                value="working" checked>
                            <label class="btn btn-outline-info" for="cat_working">
                                <i class="fa-solid fa-briefcase me-1"></i>Working
                            </label>
                            <input type="radio" class="btn-check" name="review_category" id="cat_tourism"
                                value="tourism">
                            <label class="btn btn-outline-info" for="cat_tourism">
                                <i class="fa-solid fa-map-pin me-1"></i>Tourism
                            </label>
                        </div>
                    </div>

                    {{-- Spot Search --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Search and Select a Spot</label>
                        <div class="position-relative">
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                </span>
                                <input type="text" id="spotSearchInput"
                                    class="form-control border-start-0 border-end-0" placeholder="Search..."
                                    autocomplete="off" oninput="searchSpots(this.value)">
                                <span class="input-group-text bg-white border-start-0" onclick="toggleSpotDropdown()">
                                    <i class="fa-solid fa-chevron-down text-muted" id="spotChevronIcon"></i>
                                </span>
                            </div>
                            <div id="spotDropdown"
                                style="display:none; position:absolute; top:100%; left:0; right:0; overflow-y:auto; z-index:1000;">
                                <div id="spotDropdownList"></div>
                            </div>
                        </div>
                        <div id="selectedSpotBudge" class="mt-1 d-none">
                            <span class="badge rounded-pill fw-normal px-3 py-2">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                <span id="selectedSpotName"></span>
                                <button type="button" onclick="clearSpot()">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    {{-- Working用フィールド --}}
                    <div id="workingFields">
                        <div class="row g-2 mb-2">
                            @foreach ([['key' => 'customer_vibe', 'label' => '客層', 'icon' => 'fa-users'], ['key' => 'eye_fatigue_level', 'label' => '照明', 'icon' => 'fa-lightbulb'], ['key' => 'chair_comfort', 'label' => 'イス', 'icon' => 'fa-chair'], ['key' => 'desk_stability', 'label' => '机', 'icon' => 'fa-table']] as $axis)
                                <div class="col-6">
                                    <label class="form-label fw-bold small mb-1">
                                        <i class="fa-solid {{ $axis['icon'] }} me-1"></i>{{ $axis['label'] }}
                                    </label>

                                    <input type="hidden" name="{{ $axis['key'] }}" id="input_{{ $axis['key'] }}"
                                        value="">
                                    <div class="d-flex gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" class="btn btn-sm btn-outline-secondary axis-btn"
                                                data-axis="{{ $axis['key'] }}"
                                                data-value="{{ $i }}">{{ $i }}</button>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label fw-bold small">Good Point</label>
                                <input type="text" name="good_point" class="form-control form-control-sm"
                                    maxlength="255">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">Bad Point</label>
                                <input type="text" name="bad_point" class="form-control form-control-sm"
                                    maxlength="255">
                            </div>
                        </div>
                    </div>

                    {{-- Tourism用フィールド --}}
                    <div id="tourismFields" class="d-none mb-2">
                        <label class="form-label fw-bold">Rate</label>
                        <div class="d-flex align-items-center gap-2">
                            <div id="starRating" class="d-flex gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-regular fa-star star-btn" data-value="{{ $i }}"
                                        onmouseover="hoverStar({{ $i }})" onmouseout="resetStars()"
                                        onclick="selectStar({{ $i }})"></i>
                                @endfor
                            </div>
                            <span id="ratingScore" class="fw-bold" style="font-size:1.4rem; color:#ffc107;">—</span>
                            <span class="text-muted" style="font-size:0.85rem;">/5</span>
                            <div id="ratingLabel" class="text-muted" style="font-size:0.8rem;"></div>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="">
                    </div>

                    {{-- Images（Working限定） --}}
                    <div class="mb-2" id="imagesFieldWrapper">
                        <label class="form-label fw-bold">Images (up to 5)</label>
                        <div class="d-flex align-items-start gap-2 flex-wrap">
                            <div id="addImageBtn" onclick="document.getElementById('imageInput').click()"
                                style="width:90px; height:90px; border-radius:12px;
                                       border:2px dashed #13bdbd; background:rgba(19,189,189,0.05);
                                       display:flex; flex-direction:column; align-items:center;
                                       justify-content:center; cursor:pointer; transition:all 0.2s;">
                                <i class="fa-solid fa-camera" style="font-size:1.4rem; color:#13bdbd;"></i>
                                <span style="font-size:0.72rem; color:#13bdbd; margin-top:4px; font-weight:600;">Add
                                    Images</span>
                            </div>
                            <div class="d-flex gap-2 flex-wrap align-items-start" id="imagePreviewArea"></div>
                        </div>
                        <input type="file" class="d-none" id="imageInput" name="photo" accept="image/*"
                            onchange="previewImages(this)">
                        <p class="text-muted mb-0 mt-1" style="font-size:0.7rem;">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            PNG, JPG, JPEG formats are supported. Maximum file size is 2MB.
                        </p>
                    </div>

                    {{-- Text --}}
                    <div class="mb-3">
                        <label for="review_comment" class="form-label fw-bold">Text</label>
                        <textarea name="comment" id="review_comment" class="form-control" rows="3"
                            placeholder="Write your review in detail (less than 1000 letters)" maxlength="1000">{{ old('comment') }}</textarea>
                    </div>

            </div>{{-- /modal-body --}}

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                    style="color:#13bdbd; border-color:#13bdbd;">Cancel</button>
                <button type="submit" class="btn btn-primary text-white"
                    style="background-color:#13bdbd; border-color:#13bdbd;">Post Review</button>
            </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const LABELS = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        let currentRating = 0;
        let selectedFiles = [];

        document.addEventListener('DOMContentLoaded', function() {

            // ── ★ Tourism用スター評価 ──
            const stars = document.querySelectorAll('#starRating .star-btn');
            const scoreEl = document.getElementById('ratingScore');
            const labelEl = document.getElementById('ratingLabel');
            const ratingInput = document.getElementById('ratingInput');

            function paintStars(upTo) {
                stars.forEach((s, i) => {
                    const lit = i < upTo;
                    s.classList.toggle('star-lit', lit);
                    s.classList.toggle('fa-solid', lit);
                    s.classList.toggle('fa-regular', !lit);
                });
            }

            window.hoverStar = (val) => paintStars(val);
            window.resetStars = () => paintStars(currentRating);
            window.selectStar = (val) => {
                currentRating = val;
                ratingInput.value = val;
                scoreEl.textContent = val;
                labelEl.textContent = LABELS[val];
                paintStars(val);
            };

            // ── Working用 4軸ボタン ──
            document.querySelectorAll('.axis-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const axis = this.dataset.axis;
                    const value = this.dataset.value;
                    document.getElementById(`input_${axis}`).value = value;
                    document.querySelectorAll(`.axis-btn[data-axis="${axis}"]`).forEach(b => {
                        b.classList.toggle('active', b.dataset.value === value);
                    });
                });
            });

            // ── カテゴリー切り替え ──
            document.querySelectorAll('input[name="review_category"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    clearSpot();
                    const isWorking = this.value === 'working';
                    document.getElementById('workingFields').classList.toggle('d-none', !isWorking);
                    document.getElementById('tourismFields').classList.toggle('d-none', isWorking);
                    document.getElementById('imagesFieldWrapper').classList.toggle('d-none', !
                        isWorking);
                });
            });
        });

        // ── 画像プレビュー（Working限定・1枚のみ） ──
        function previewImages(input) {
            const previewArea = document.getElementById('imagePreviewArea');
            previewArea.innerHTML = '';
            selectedFiles = [];

            const file = input.files[0];
            if (!file) return;
            selectedFiles.push(file);

            const reader = new FileReader();
            reader.onload = (e) => {
                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:relative; width:90px; height:90px; flex-shrink:0;';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText =
                    'width:90px; height:90px; object-fit:cover; border-radius:12px; border:1px solid #dee2e6;';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.innerHTML = '&times;';
                btn.style.cssText = `
                position:absolute; top:-6px; right:-6px;
                width:20px; height:20px; border-radius:50%;
                background:#dc3545; color:white; border:none;
                font-size:0.75rem; line-height:1;
                display:flex; align-items:center; justify-content:center;
                cursor:pointer; padding:0;`;

                btn.onclick = () => {
                    selectedFiles = [];
                    document.getElementById('imageInput').value = '';
                    wrapper.remove();
                    document.getElementById('addImageBtn').style.display = 'flex';
                };

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                previewArea.appendChild(wrapper);
                document.getElementById('addImageBtn').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // ── スポット検索（カテゴリー別） ──
        async function searchSpots(keyword) {
            const type = document.querySelector('input[name="review_category"]:checked').value;
            const res = await fetch(`/reviews/search-locations?q=${encodeURIComponent(keyword)}&type=${type}`);
            const data = await res.json();
            renderDropdown(data);
            document.getElementById('spotDropdown').style.display = 'block';
        }

        function toggleSpotDropdown() {
            const dropdown = document.getElementById('spotDropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                searchSpots('');
            }
        }

        function renderDropdown(items) {
            const list = document.getElementById('spotDropdownList');
            if (items.length === 0) {
                list.innerHTML = '<div class="p-2 text-muted small bg-white border">No results found</div>';
                return;
            }
            list.innerHTML = items.map(item => `
        <div class="p-2 bg-white border border-top-0 small"
             style="cursor:pointer;"
             onmouseover="this.style.backgroundColor='#f0fafa'"
             onmouseout="this.style.backgroundColor='white'"
             onclick="selectSpot(${item.id}, '${item.name.replace(/'/g, "\\'")}')">
            <span class="fw-bold">${item.name}</span>
            <span class="text-muted ms-2">${item.address ?? ''}</span>
        </div>
            `).join('');
        }

        function selectSpot(id, name) {
            document.getElementById('selectedLocationId').value = id;
            document.getElementById('selectedSpotName').innerText = name;
            document.getElementById('selectedSpotBudge').classList.remove('d-none');
            document.getElementById('spotDropdown').style.display = 'none';
            document.getElementById('spotSearchInput').value = name;
        }

        function clearSpot() {
            document.getElementById('selectedLocationId').value = 0;
            document.getElementById('selectedSpotName').innerText = '';
            document.getElementById('selectedSpotBudge').classList.add('d-none');
            document.getElementById('spotSearchInput').value = '';
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('spotDropdown');
            const input = document.getElementById('spotSearchInput');
            if (dropdown && !dropdown.contains(e.target) && e.target !== input) {
                dropdown.style.display = 'none';
            }
        });

        // ── 送信直前：送信先URLを組み立て＆画像をinputに反映 ──
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reviewForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                const type = document.querySelector('input[name="review_category"]:checked').value;
                const spotId = document.getElementById('selectedLocationId').value;

                if (!spotId || spotId === '0') {
                    e.preventDefault();
                    alert('Select the spot');
                    return;
                }

                this.action = type === 'working' ?
                    `/spots/${spotId}/reviews` :
                    `/tourist_spots/${spotId}/reviews`;

                if (type === 'working' && selectedFiles.length > 0) {
                    const dt = new DataTransfer();
                    dt.items.add(selectedFiles[0]);
                    document.getElementById('imageInput').files = dt.files;
                }
            });
        });
    </script>
@endpush
