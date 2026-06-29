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

    .edit-star-btn {
        font-size: 1.2rem;
        color: #dee2e6;
        cursor: pointer;
        transition: color 0.2s;
    }

    .edit-star-btn.star-lit {
        color: #ffc107;
    }
</style>

<div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-sm">

            <div class="modal-header py-1">
                <h5 class="modal-title fw-bold" id="editReviewModalLabel">Edit Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-2">
                <form action="{{ route('all_reviews.update', $review->id) }}" method="post" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="location_id" id="edit_locationId" value="0">
                    <input type="hidden" name="rating" id="edit_ratingInput" value="">

                    {{-- Selected Spot --}}
                    <div class="mb-3">
                        <div class="border rounded-3 overflow-hidden">
                            <div class="px-3 py-2 text-white fw-semibold"
                                style="background-color:#2563c7; font-size:0.82rem;">
                                Selected Spot Information
                            </div>
                            <div class="d-flex align-items-center gap-3 p-2">
                                <img id="edit_locationImg" src="/images/no-image.png" alt="spot"
                                    style="width:90px; height:70px; object-fit:cover; border-radius:8px; flex-shrink:0;">
                                <div>
                                    <div class="fw-bold mb-1" id="edit_locationName" style="font-size:0.95rem;"></div>
                                    <div class="text-muted mb-1" style="font-size:0.78rem;">
                                        <i class="fa-solid fa-location-dot me-1"></i>
                                        <span id="edit_locationAddress"></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <span id="edit_locationStars" class="text-warning"
                                            style="font-size:0.82rem;"></span>
                                        <span id="edit_locationRating" class="fw-bold"
                                            style="font-size:0.85rem;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Title & Rating --}}
                    <div class="mb-2 d-flex">
                        <div class="title">
                            <label for="edit_title" class="form-label fw-bold">Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control shadow-sm">
                        </div>
                        <div class="rate ms-4">
                            <label class="form-label fw-bold">Rate</label>
                            <div class="d-flex align-items-center gap-2">
                                <div id="edit_starRating" class="d-flex gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-regular fa-star edit-star-btn" data-value="{{ $i }}"
                                            onmouseover="editHoverStar({{ $i }})"
                                            onmouseout="editResetStars()"
                                            onclick="editSelectStar({{ $i }})"></i>
                                    @endfor
                                </div>
                                <div class="ms-2">
                                    <span id="edit_ratingScore" class="fw-bold"
                                        style="font-size:1.4rem; color:#ffc107;">—</span>
                                    <span class="text-muted" style="font-size:0.85rem;">/5</span>
                                    <div id="edit_ratingLabel" class="text-muted" style="font-size:0.8rem;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Images --}}
                    <div class="mb-2">
                        <label class="form-label fw-bold">Images (up to 5)</label>
                        <div class="d-flex align-items-start gap-2 flex-wrap">
                            <div id="edit_addImageBtn" onclick="document.getElementById('edit_imageInput').click()"
                                style="width:90px; height:90px; border-radius:12px;
                                        border:2px dashed #13bdbd; background:rgba(19,189,189,0.05);
                                        display:flex; flex-direction:column; align-items:center;
                                        justify-content:center; cursor:pointer; transition:all 0.2s;">
                                <i class="fa-solid fa-camera" style="font-size:1.4rem; color:#13bdbd;"></i>
                                <span style="font-size:0.72rem; color:#13bdbd; margin-top:4px; font-weight:600;">Add
                                    Images</span>
                            </div>
                            <div class="d-flex gap-2 flex-wrap align-items-start" id="edit_imagePreviewArea"></div>
                        </div>
                        <input type="file" class="d-none" id="edit_imageInput" name="images[]" multiple
                            accept="image/*" onchange="editPreviewImages(this)">
                        <p class="text-muted mb-0 mt-1" style="font-size:0.7rem;">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            PNG, JPG, JPEG formats are supported. Maximum file size is 2MB per image.
                        </p>

                        {{-- 削除する既存画像パスを格納するコンテナ --}}
                        <div id="edit_deletedImagesContainer"></div>
                    </div>

                    {{-- Text --}}
                    <div class="mb-3">
                        <label for="edit_comment" class="form-label fw-bold">Text</label>
                        <textarea name="comment" id="edit_comment" class="form-control" rows="3"
                            placeholder="Write your review in detail (less than 1000 letters)" maxlength="1000"></textarea>
                    </div>

                    {{-- Amenities --}}
                    <div class="mb-2">
                        <label class="form-label fw-bold">Amenities & Services</label>
                        <div class="d-flex gap-2 flex-wrap" id="edit_amenitiesArea">
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
                                {{-- ★ IDをedit_プレフィックスに変更 --}}
                                <label class="amenity-label" for="edit_amenity_{{ $a['value'] }}">
                                    <input type="checkbox" id="edit_amenity_{{ $a['value'] }}" name="amenities[]"
                                        value="{{ $a['value'] }}" class="edit-amenity-check d-none">
                                    <i class="fa-solid {{ $a['icon'] }} mb-1"
                                        style="font-size:1.2rem; color:#adb5bd;"></i>
                                    <span
                                        style="font-size:0.72rem; color:#2d3033; font-weight:600;">{{ $a['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                    style="color:#13bdbd; border-color:#13bdbd;">Cancel</button>
                <button type="submit" form="editForm" class="btn btn-primary text-white"
                    style="background-color:#13bdbd; border-color:#13bdbd;">Update Review</button>
            </div>

        </div>
    </div>
</div>

{{-- JS --}}
@push('scripts')
    <script>
        (function() {
            const LABELS = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            let editRating = 0;
            let editFiles = []; // { file: File|null, isExisting: bool, path: string|null }
            const MAX_IMG = 5;

            // ── 星 ──
            function paintStars(upTo) {
                document.querySelectorAll('#edit_starRating .edit-star-btn').forEach((s, i) => {
                    const lit = i < upTo;
                    s.classList.toggle('star-lit', lit);
                    s.classList.toggle('fa-solid', lit);
                    s.classList.toggle('fa-regular', !lit);
                });
            }
            window.editHoverStar = (v) => paintStars(v);
            window.editResetStars = () => paintStars(editRating);
            window.editSelectStar = (v) => {
                editRating = v;
                document.getElementById('edit_ratingInput').value = v;
                document.getElementById('edit_ratingScore').textContent = v;
                document.getElementById('edit_ratingLabel').textContent = LABELS[v] ?? '';
                paintStars(v);
            };

            // ── プレビューアイテム生成 ──
            function makePreviewItem(src, index) {
                const area = document.getElementById('edit_imagePreviewArea');

                const wrap = document.createElement('div');
                wrap.style.cssText = 'position:relative; width:90px; height:90px; flex-shrink:0;';
                wrap.dataset.fileIndex = index;

                const img = document.createElement('img');
                img.src = src;
                img.style.cssText =
                    'width:90px; height:90px; object-fit:cover; border-radius:12px; border:1px solid #dee2e6;';

                const del = document.createElement('button');
                del.type = 'button';
                del.innerHTML = '&times;';
                del.style.cssText = `
            position:absolute; top:-6px; right:-6px;
            width:20px; height:20px; border-radius:50%;
            background:#dc3545; color:#fff; border:none;
            font-size:.75rem; line-height:1;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; padding:0;`;
                del.onclick = () => {
                    const idx = parseInt(wrap.dataset.fileIndex);
                    const item = editFiles[idx];
                    //hidden inputから削除
                    document.getElementById('edit_deletedImagesContainer').innerHTML = '';

                    // ★ 既存画像なら削除フラグをformに追加
                    if (item.isExisting && item.path) {
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'delete_images[]';
                        hidden.value = item.path;
                        hidden.dataset.deletePath = item.path; // 特定用
                        document.getElementById('edit_deletedImagesContainer').appendChild(hidden);
                    }

                    editFiles.splice(idx, 1);
                    area.querySelectorAll('div[data-file-index]').forEach((el, i) => el.dataset.fileIndex = i);
                    wrap.remove();
                    if (editFiles.length < MAX_IMG) {
                        document.getElementById('edit_addImageBtn').style.display = 'flex';
                    }
                };
                wrap.append(img, del);
                area.appendChild(wrap);
            }

            // ── 新規画像選択 ──
            window.editPreviewImages = function(input) {
                const remaining = MAX_IMG - editFiles.length;
                if (remaining <= 0) return;

                Array.from(input.files).slice(0, remaining).forEach(file => {
                    editFiles.push({
                        file,
                        isExisting: false,
                        path: null
                    });
                    const reader = new FileReader();
                    reader.onload = (e) => makePreviewItem(e.target.result, editFiles.length - 1);
                    reader.readAsDataURL(file);
                });

                if (editFiles.length >= MAX_IMG) {
                    document.getElementById('edit_addImageBtn').style.display = 'none';
                }
                input.value = '';
            };

            document.addEventListener('DOMContentLoaded', function() {

                // ── アメニティ change ──
                document.querySelectorAll('.edit-amenity-check').forEach(cb => {
                    cb.addEventListener('change', function() {
                        this.closest('.amenity-label').classList.toggle('selected', this
                            .checked);
                    });
                });

                // ── フォーム送信 ──
                document.getElementById('editForm').addEventListener('submit', function(e) {
                    const newFiles = editFiles.filter(f => !f.isExisting).map(f => f.file);
                    if (newFiles.length === 0) return;
                    e.preventDefault();
                    const dt = new DataTransfer();
                    newFiles.forEach(f => dt.items.add(f));
                    document.getElementById('edit_imageInput').files = dt.files;
                    this.submit();
                });

                // ── Edit ボタン クリック ──
                document.querySelectorAll('.edit-review-btn').forEach(btn => {
                    btn.addEventListener('click', function() {

                        const rating = parseInt(this.dataset.rating ?? 0);

                        // テキスト
                        document.getElementById('edit_title').value = this.dataset.title ?? '';
                        document.getElementById('edit_comment').value = this.dataset.comment ??
                            '';

                        // 星
                        editRating = rating;
                        document.getElementById('edit_ratingInput').value = rating;
                        document.getElementById('edit_ratingScore').textContent = rating || '—';
                        document.getElementById('edit_ratingLabel').textContent = LABELS[
                            rating] ?? '';
                        paintStars(rating);

                        // Selected Location
                        const locRating = parseFloat(this.dataset.locationRating ?? 0).toFixed(
                            1);
                        const locImg = this.dataset.locationImg ?? '';
                        const stars = Math.round(parseFloat(locRating));

                        document.getElementById('edit_locationName').textContent = this.dataset
                            .locationName ?? '（未設定）';
                        document.getElementById('edit_locationAddress').textContent = this
                            .dataset.locationAddress ?? '';
                        document.getElementById('edit_locationRating').textContent = locRating;
                        document.getElementById('edit_locationStars').textContent = '★'.repeat(
                            stars) + '☆'.repeat(5 - stars);

                        const imgEl = document.getElementById('edit_locationImg');
                        imgEl.src = (locImg && locImg.trim()) ? `/storage/${locImg}` :
                            '/images/no-image.png';

                        // 既存画像プレビュー
                        const area = document.getElementById('edit_imagePreviewArea');
                        area.innerHTML = '';
                        editFiles = [];
                        document.getElementById('edit_addImageBtn').style.display = 'flex';

                        const existingImages = JSON.parse(this.dataset.images || '[]');
                        existingImages.forEach((path, i) => {
                            editFiles.push({
                                file: null,
                                isExisting: true,
                                path
                            });
                            makePreviewItem(`/storage/${path}`, i);
                        });
                        if (editFiles.length >= MAX_IMG) {
                            document.getElementById('edit_addImageBtn').style.display = 'none';
                        }

                        // アメニティ
                        const amenities = JSON.parse(this.dataset.amenities || '[]');
                        document.querySelectorAll('.edit-amenity-check').forEach(cb => {
                            cb.checked = amenities.includes(cb.value);
                            cb.closest('.amenity-label').classList.toggle('selected', cb
                                .checked);
                        });

                        // action
                        document.getElementById('editForm').action =
                            `/all_reviews/${this.dataset.id}/update`;
                    });
                });
            });
        })();
    </script>
@endpush
