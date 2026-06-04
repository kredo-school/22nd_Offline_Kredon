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

    .amenity-label.selected {
        border-color: #13bdbd;
        background-color: rgba(19, 189, 189, 0.15);
    }

    .amenity-label.selected i {
        color: #13bdbd !important;
    }

    .amenity-label.selected span {
        color: #13bdbd !important;
    }

    .amenity-label:hover {
        border-color: #13bdbd;
        background-color: rgba(19, 189, 189, 0.1);
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

                <form action="{{ route('reviews.store') }}" method="post" enctype="multipart/form-data"
                    id="reviewForm">
                    @csrf

                    <input type="hidden" name="location_id" id="selectedLocationId"
                        value="{{ old('location_id', 0) }}">
                    <input type="hidden" name="category" id="selectedCategoryId" value="{{ old('category') }}">
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating') }}">

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

                    {{-- Title & Rating --}}
                    <div class="mb-2 d-flex">
                        <div class="title">
                            <label for="review_title" class="form-label fw-bold">Title</label>
                            <input type="text" name="title" id="review_title" class="form-control shadow-sm"
                                value="{{ old('title') }}" maxlength="255" required>
                        </div>
                        <div class="rate ms-4">
                            <label class="form-label fw-bold">Rate</label>
                            <div class="d-flex align-items-center gap-2">
                                <div id="starRating" class="d-flex gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-regular fa-star star-btn" data-value="{{ $i }}"
                                            onmouseover="hoverStar({{ $i }})" onmouseout="resetStars()"
                                            onclick="selectStar({{ $i }})"></i>
                                    @endfor
                                </div>
                                <div class="ms-2">
                                    <span id="ratingScore" class="fw-bold"
                                        style="font-size:1.4rem; color:#ffc107;">—</span>
                                    <span class="text-muted" style="font-size:0.85rem;">/5</span>
                                    <div id="ratingLabel" class="text-muted" style="font-size:0.8rem;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Images --}}
                    <div class="mb-2">
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
                        <input type="file" class="d-none" id="imageInput" name="images[]" multiple
                            accept="image/*" onchange="previewImages(this)">
                        <p class="text-muted mb-0 mt-1" style="font-size:0.7rem;">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            PNG, JPG, JPEG formats are supported. Maximum file size is 2MB per image.
                        </p>
                    </div>

                    {{-- Text --}}
                    <div class="mb-3">
                        <label for="review_comment" class="form-label fw-bold">Text</label>
                        <textarea name="comment" id="review_comment" class="form-control" rows="3"
                            placeholder="Write your review in detail (less than 1000 letters)" maxlength="1000">{{ old('comment') }}</textarea>
                    </div>

                    {{-- Amenities --}}
                    <div class="mb-2">
                        <label class="form-label fw-bold">Amenities & Services</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @php
                                $amenities = [
                                    ['value' => 'wifi', 'icon' => 'fa-wifi', 'label' => 'Wi-Fi'],
                                    ['value' => 'outlet', 'icon' => 'fa-plug', 'label' => 'Power Outlet'],
                                    [
                                        'value' => 'air-conditioner',
                                        'icon' => 'fa-snowflake',
                                        'label' => 'Air-conditioner',
                                    ],
                                    ['value' => 'parking', 'icon' => 'fa-square-parking', 'label' => 'Parking'],
                                    ['value' => 'toilet', 'icon' => 'fa-restroom', 'label' => 'Toilet'],
                                ];
                            @endphp

                            @foreach ($amenities as $a)
                                {{-- ★ fix②: labelタグでwrapしてJS不要に。checkboxのidとlabelのforを紐付け --}}
                                <label class="amenity-label" for="amenity_{{ $a['value'] }}">
                                    <input type="checkbox" id="amenity_{{ $a['value'] }}" name="amenities[]"
                                        value="{{ $a['value'] }}" class="amenity-check d-none">
                                    <i class="fa-solid {{ $a['icon'] }} mb-1"
                                        style="font-size:1.2rem; color:#adb5bd;"></i>
                                    <span
                                        style="font-size:0.72rem; color:#2d3033; font-weight:600;">{{ $a['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
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

{{-- JS --}}
@push('scripts')
    <script>
        const LABELS = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        let currentRating = 0;

        document.addEventListener('DOMContentLoaded', function() {

            // ── 星レーティング ──
            const stars = document.querySelectorAll('#starRating .star-btn');
            const scoreEl = document.getElementById('ratingScore');
            const labelEl = document.getElementById('ratingLabel');
            const ratingInput = document.getElementById('ratingInput');

            function paintStars(upTo) {
                stars.forEach((s, i) => {
                    const lit = i < upTo;
                    // ★ fix③: star-lit で統一（CSS側も同名）
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

            // ── アメニティ ──
            // ★ fix②: label > checkbox 構造なのでクリックは自動。
            //    selected クラスだけ JS で付け外しする。
            document.querySelectorAll('.amenity-check').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    this.closest('.amenity-label').classList.toggle('selected', this.checked);
                });
            });
        });

        // ── 画像プレビュー ──
        let selectedFiles = []; // 追加：選択されたファイルを管理する配列

        function previewImages(input) {
            const previewArea = document.getElementById('imagePreviewArea');
            const maxImages = 5;
            const remaining = maxImages - selectedFiles.length;

            // 現在表示中の枚数を確認
            // const currentCount = previewArea.querySelectorAll('div').length;
            // const remaining = maxImages - currentCount;

            if (remaining <= 0) return; // すでに5枚ある場合は何もしない

            // 追加できる枚数だけ処理
            Array.from(input.files).slice(0, remaining).forEach(file => {
                selectedFiles.push(file); // 追加：選択されたファイルを配列に保存

                const reader = new FileReader();

                reader.onload = (e) => {
                    const fileIndex = selectedFiles.length - 1; // 追加：現在のファイルのインデックス
                    const wrapper = document.createElement('div');
                    wrapper.style.cssText = 'position:relative; width:90px; height:90px; flex-shrink:0;';
                    wrapper.dataset.fileIndex = fileIndex; // 追加：ファイルインデックスをデータ属性に保存

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

                    // ★ 削除後に5枚未満になったらAddボタンを再表示
                    btn.onclick = () => {
                        const idx = parseInt(wrapper.dataset.fileIndex);
                        selectedFiles.splice(idx, 1);
                        // インデックスを振り直す
                        previewArea.querySelectorAll('div[data-file-index]').forEach((el, i) => {
                            el.dataset.fileIndex = i;
                        });
                        wrapper.remove();
                        if (selectedFiles.length < maxImages) {
                            document.getElementById('addImageBtn').style.display = 'flex';
                        }
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    previewArea.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });

            if (selectedFiles.length >= maxImages) {
                document.getElementById('addImageBtn').style.display = 'none';
            }

            input.value = '';
        }

        // ── フォーム送信時にselectedFilesをinputに反映 ──
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('reviewForm').addEventListener('submit', function(e) {
                if (selectedFiles.length === 0) return;

                e.preventDefault();

                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                document.getElementById('imageInput').files = dt.files;
                this.submit();
            });
        });
    
        // SPOT keyword search (dummy implementation)
        async function searchSpots(keyword) {
            const res = await fetch(`/reviews/search-locations?q=${encodeURIComponent(keyword)}`);
            const data = await res.json();
            renderDropdown(data);
            document.getElementById('spotDropdown').style.display = 'block';
        }

        function toggleSpotDropdown() {
            const dropdown = document.getElementById('spotDropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                searchSpots(''); // 全件表示
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
             onclick="selectSpot(${item.id}, '${item.name}', '${item.category}')">
            <span class="fw-bold">${item.name}</span>
            <span class="text-muted ms-2">${item.address}</span>
        </div>
            `).join('');
        }

        function selectSpot(id, name, category) {
            document.getElementById('selectedLocationId').value = id;
            document.getElementById('selectedCategoryId').value = category;
            document.getElementById('selectedSpotName').innerText = name;
            document.getElementById('selectedSpotBudge').classList.remove('d-none');
            document.getElementById('spotDropdown').style.display = 'none';
            document.getElementById('spotSearchInput').value = name;
        }

        function clearSpot() {
            document.getElementById('selectedLocationId').value = 0;
            document.getElementById('selectedCategoryId').value = '';
            document.getElementById('selectedSpotName').innerText = '';
            document.getElementById('selectedSpotBudge').classList.add('d-none');
            document.getElementById('spotSearchInput').value = '';
        }

        // モーダル外クリックでドロップダウンを閉じる
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('spotDropdown');
            const input = document.getElementById('spotSearchInput');
            if (dropdown && !dropdown.contains(e.target) && e.target !== input) {
                dropdown.style.display = 'none';
            }
        });
    </script>
@endpush

   {{-- // ── スポット検索（location実装時用） ──
    async function searchSpots(keyword) {
        const res  = await fetch(`/reviews/search-locations?q=${encodeURIComponent(keyword)}`);
        const data = await res.json();
        renderDropdown(data);
        document.getElementById('spotDropdown').style.display = 'block';
    }

    function toggleSpotDropdown() {
        const dropdown = document.getElementById('spotDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : '';
        if (dropdown.style.display === 'block') searchSpots('');
    }

    function renderDropdown(items) {
        const list = document.getElementById('spotDropdownList');
        list.innerHTML = items.length === 0
            ? '<div class="p-2 text-muted small bg-white border">No results found</div>'
            : items.map(item => `
                <div class="p-2 bg-white border border-top-0 small" style="cursor:pointer;"
                     onmouseover="this.style.backgroundColor='#f0fafa'"
                     onmouseout="this.style.backgroundColor='white'"
                     onclick="selectSpot(${item.id},'${item.name}','${item.category}')">
                    <span class="fw-bold">${item.name}</span>
                    <span class="text-muted ms-2">${item.address}</span>
                </div>`).join('');
    }

    // function selectSpot(id, name, category) {
    //     document.getElementById('selectedLocationId').value = id;
    //     document.getElementById('selectedCategoryId').value = category;
    //     document.getElementById('selectedSpotName').innerText = name;
    //     document.getElementById('selectedSpotBudge').classList.remove('d-none');
    //     document.getElementById('spotDropdown').style.display = 'none';
    //     document.getElementById('spotSearchInput').value = name;
    // }

    // function clearSpot() {
    //     document.getElementById('selectedLocationId').value = 0;
    //     document.getElementById('selectedCategoryId').value = '';
    //     document.getElementById('selectedSpotName').innerText = '';
    //     document.getElementById('selectedSpotBudge').classList.add('d-none');
    //     document.getElementById('spotSearchInput').value = '';
    // }

    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('spotDropdown');
        const input    = document.getElementById('spotSearchInput');
        if (dropdown && !dropdown.contains(e.target) && e.target !== input) {
            dropdown.style.display = 'none';
        }
    }); --}}