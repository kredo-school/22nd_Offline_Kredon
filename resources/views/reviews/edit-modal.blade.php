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

    .amenity-label.selected i,
    .amenity-label.selected span {
        color: #13bdbd !important;
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

    .edit-axis-btn.active {
        background-color: #13bdbd !important;
        border-color: #13bdbd !important;
        color: #fff !important;
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
                <form action="" method="post" enctype="multipart/form-data" id="editForm">
                    @csrf
                    <input type="hidden" name="_method" id="edit_methodField" value="PATCH">
                    <input type="hidden" name="rating" id="edit_ratingInput" value="">

                    {{-- ===== AllReview専用：Title ===== --}}
                    <div class="mb-2" id="editAllReviewTitleField">
                        <label for="edit_title" class="form-label fw-bold">Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control shadow-sm">
                    </div>

                    {{-- ===== AllReview & Tourism共通：★評価 ===== --}}
                    <div class="mb-2" id="editStarRatingField">
                        <label class="form-label fw-bold">Rate</label>
                        <div class="d-flex align-items-center gap-2">
                            <div id="edit_starRating" class="d-flex gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-regular fa-star edit-star-btn" data-value="{{ $i }}"
                                        onmouseover="editHoverStar({{ $i }})" onmouseout="editResetStars()"
                                        onclick="editSelectStar({{ $i }})"></i>
                                @endfor
                            </div>
                            <span id="edit_ratingScore" class="fw-bold" style="font-size:1.4rem; color:#ffc107;">—</span>
                            <span class="text-muted" style="font-size:0.85rem;">/5</span>
                            <div id="edit_ratingLabel" class="text-muted" style="font-size:0.8rem;"></div>
                        </div>
                    </div>

                    {{-- ===== Working専用：4軸評価 ===== --}}
                    <div id="editWorkingFields" class="d-none">
                        @foreach ([
                            ['key' => 'customer_vibe', 'label' => '客層', 'icon' => 'fa-users'],
                            ['key' => 'eye_fatigue_level', 'label' => '照明', 'icon' => 'fa-lightbulb'],
                            ['key' => 'chair_comfort', 'label' => 'イス', 'icon' => 'fa-chair'],
                            ['key' => 'desk_stability', 'label' => '机', 'icon' => 'fa-table'],
                        ] as $axis)
                            <div class="mb-2">
                                <label class="form-label fw-bold small mb-1">
                                    <i class="fa-solid {{ $axis['icon'] }} me-1"></i>{{ $axis['label'] }}
                                </label>
                                <input type="hidden" name="{{ $axis['key'] }}" id="edit_input_{{ $axis['key'] }}" value="">
                                <div class="d-flex gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" class="btn btn-sm btn-outline-secondary edit-axis-btn"
                                            data-axis="{{ $axis['key'] }}" data-value="{{ $i }}">{{ $i }}</button>
                                    @endfor
                                </div>
                            </div>
                        @endforeach

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label fw-bold small">👍 Good Point</label>
                                <input type="text" name="good_point" id="edit_good_point" class="form-control form-control-sm" maxlength="255">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">気になるPoint</label>
                                <input type="text" name="bad_point" id="edit_bad_point" class="form-control form-control-sm" maxlength="255">
                            </div>
                        </div>

                        {{-- Working用：単一写真 --}}
                        <div class="mb-2">
                            <label class="form-label fw-bold">Photo</label>
                            <div class="d-flex align-items-start gap-2 flex-wrap">
                                <div id="edit_workingAddImageBtn" onclick="document.getElementById('edit_workingImageInput').click()"
                                    style="width:90px; height:90px; border-radius:12px;
                                           border:2px dashed #13bdbd; background:rgba(19,189,189,0.05);
                                           display:flex; flex-direction:column; align-items:center;
                                           justify-content:center; cursor:pointer;">
                                    <i class="fa-solid fa-camera" style="font-size:1.4rem; color:#13bdbd;"></i>
                                    <span style="font-size:0.68rem; color:#13bdbd; margin-top:4px; font-weight:600;">Change</span>
                                </div>
                                <div id="edit_workingImagePreviewArea" class="d-flex gap-2 flex-wrap"></div>
                            </div>
                            <input type="file" class="d-none" id="edit_workingImageInput" name="photo" accept="image/*"
                                onchange="editPreviewWorkingImage(this)">
                        </div>
                    </div>

                    {{-- ===== AllReview専用：複数画像 ===== --}}
                    <div class="mb-2" id="editAllReviewImagesField">
                        <label class="form-label fw-bold">Images (up to 5)</label>
                        <div class="d-flex align-items-start gap-2 flex-wrap">
                            <div id="edit_addImageBtn" onclick="document.getElementById('edit_imageInput').click()"
                                style="width:90px; height:90px; border-radius:12px;
                                       border:2px dashed #13bdbd; background:rgba(19,189,189,0.05);
                                       display:flex; flex-direction:column; align-items:center;
                                       justify-content:center; cursor:pointer;">
                                <i class="fa-solid fa-camera" style="font-size:1.4rem; color:#13bdbd;"></i>
                                <span style="font-size:0.72rem; color:#13bdbd; margin-top:4px; font-weight:600;">Add Images</span>
                            </div>
                            <div class="d-flex gap-2 flex-wrap align-items-start" id="edit_imagePreviewArea"></div>
                        </div>
                        <input type="file" class="d-none" id="edit_imageInput" name="images[]" multiple
                            accept="image/*" onchange="editPreviewImages(this)">
                        <div id="edit_deletedImagesContainer"></div>
                    </div>

                    {{-- ===== 共通：Text ===== --}}
                    <div class="mb-3">
                        <label for="edit_comment" class="form-label fw-bold">Text</label>
                        <textarea name="comment" id="edit_comment" class="form-control" rows="3" maxlength="1000"></textarea>
                    </div>

                    {{-- ===== AllReview専用：Amenities ===== --}}
                    <div class="mb-2" id="editAllReviewAmenitiesField">
                        <label class="form-label fw-bold">Amenities & Services</label>
                        <div class="d-flex gap-2 flex-wrap" id="edit_amenitiesArea">
                            @php
                                $amenities = [
                                    ['value' => 'wifi', 'icon' => 'fa-wifi', 'label' => 'Wi-Fi'],
                                    ['value' => 'outlet', 'icon' => 'fa-plug', 'label' => 'Power Outlet'],
                                    ['value' => 'air-conditioner', 'icon' => 'fa-snowflake', 'label' => 'Air-conditioner'],
                                    ['value' => 'parking', 'icon' => 'fa-square-parking', 'label' => 'Parking'],
                                    ['value' => 'toilet', 'icon' => 'fa-restroom', 'label' => 'Toilet'],
                                ];
                            @endphp
                            @foreach ($amenities as $a)
                                <label class="amenity-label" for="edit_amenity_{{ $a['value'] }}">
                                    <input type="checkbox" id="edit_amenity_{{ $a['value'] }}" name="amenities[]"
                                        value="{{ $a['value'] }}" class="edit-amenity-check d-none">
                                    <i class="fa-solid {{ $a['icon'] }} mb-1" style="font-size:1.2rem; color:#adb5bd;"></i>
                                    <span style="font-size:0.72rem; color:#2d3033; font-weight:600;">{{ $a['label'] }}</span>
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

@push('scripts')
    <script>
        (function() {
            const LABELS = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            let editRating = 0;
            let editFiles = [];
            let editWorkingPhotoFile = null;
            const MAX_IMG = 5;

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

            // ── AllReview用：複数画像プレビュー ──
            function makePreviewItem(src, index) {
                const area = document.getElementById('edit_imagePreviewArea');
                const wrap = document.createElement('div');
                wrap.style.cssText = 'position:relative; width:90px; height:90px; flex-shrink:0;';
                wrap.dataset.fileIndex = index;

                const img = document.createElement('img');
                img.src = src;
                img.style.cssText = 'width:90px; height:90px; object-fit:cover; border-radius:12px; border:1px solid #dee2e6;';

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
                    if (item.isExisting && item.path) {
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'delete_images[]';
                        hidden.value = item.path;
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

            window.editPreviewImages = function(input) {
                const remaining = MAX_IMG - editFiles.length;
                if (remaining <= 0) return;
                Array.from(input.files).slice(0, remaining).forEach(file => {
                    editFiles.push({ file, isExisting: false, path: null });
                    const reader = new FileReader();
                    reader.onload = (e) => makePreviewItem(e.target.result, editFiles.length - 1);
                    reader.readAsDataURL(file);
                });
                if (editFiles.length >= MAX_IMG) {
                    document.getElementById('edit_addImageBtn').style.display = 'none';
                }
                input.value = '';
            };

            // ── Working用：単一写真プレビュー ──
            window.editPreviewWorkingImage = function(input) {
                const file = input.files[0];
                if (!file) return;
                editWorkingPhotoFile = file;
                const area = document.getElementById('edit_workingImagePreviewArea');
                area.innerHTML = '';
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:90px; height:90px; object-fit:cover; border-radius:12px; border:1px solid #dee2e6;';
                    area.appendChild(img);
                };
                reader.readAsDataURL(file);
            };

            document.addEventListener('DOMContentLoaded', function() {

                document.querySelectorAll('.edit-amenity-check').forEach(cb => {
                    cb.addEventListener('change', function() {
                        this.closest('.amenity-label').classList.toggle('selected', this.checked);
                    });
                });

                document.querySelectorAll('.edit-axis-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const axis = this.dataset.axis;
                        const value = this.dataset.value;
                        document.getElementById(`edit_input_${axis}`).value = value;
                        document.querySelectorAll(`.edit-axis-btn[data-axis="${axis}"]`).forEach(b => {
                            b.classList.toggle('active', b.dataset.value === value);
                        });
                    });
                });

                const form = document.getElementById('editForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const newImages = editFiles.filter(f => !f.isExisting).map(f => f.file);
                        if (newImages.length > 0) {
                            const dt = new DataTransfer();
                            newImages.forEach(f => dt.items.add(f));
                            document.getElementById('edit_imageInput').files = dt.files;
                        }
                        if (editWorkingPhotoFile) {
                            const dt2 = new DataTransfer();
                            dt2.items.add(editWorkingPhotoFile);
                            document.getElementById('edit_workingImageInput').files = dt2.files;
                        }
                    });
                }

                document.querySelectorAll('.edit-review-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const source = this.dataset.source;
                        const id = this.dataset.id;

                        // フィールドの表示切り替え
                        document.getElementById('editAllReviewTitleField').classList.toggle('d-none', source !== 'all_review');
                        document.getElementById('editStarRatingField').classList.toggle('d-none', source === 'working');
                        document.getElementById('editWorkingFields').classList.toggle('d-none', source !== 'working');
                        document.getElementById('editAllReviewImagesField').classList.toggle('d-none', source !== 'all_review');
                        document.getElementById('editAllReviewAmenitiesField').classList.toggle('d-none', source !== 'all_review');

                        // action / method
                        editFiles = [];
                        editWorkingPhotoFile = null;
                        const form = document.getElementById('editForm');
                        if (source === 'working') {
                            form.action = `/reviews/${id}`;
                            document.getElementById('edit_methodField').value = 'PUT';
                        } else if (source === 'tourism') {
                            form.action = `/tourist_reviews/${id}`;
                            document.getElementById('edit_methodField').value = 'PUT';
                        } else {
                            form.action = `/all_reviews/${id}/update`;
                            document.getElementById('edit_methodField').value = 'PATCH';
                        }

                        // 共通：コメント
                        document.getElementById('edit_comment').value = this.dataset.comment ?? '';

                        // AllReview: Title
                        document.getElementById('edit_title').value = this.dataset.title ?? '';

                        // AllReview & Tourism: ★評価
                        const rating = parseInt(this.dataset.rating ?? 0);
                        editRating = rating;
                        document.getElementById('edit_ratingInput').value = rating;
                        document.getElementById('edit_ratingScore').textContent = rating || '—';
                        document.getElementById('edit_ratingLabel').textContent = LABELS[rating] ?? '';
                        paintStars(rating);

                        // Working: 4軸 + Good/Bad Point + Photo
                        if (source === 'working') {
                            ['customer_vibe', 'eye_fatigue_level', 'chair_comfort', 'desk_stability'].forEach(axis => {
                                const val = this.dataset[axis.replace(/_([a-z])/g, (_, c) => c.toUpperCase())] ??
                                            this.dataset[axis] ?? '';
                                document.getElementById(`edit_input_${axis}`).value = val;
                                document.querySelectorAll(`.edit-axis-btn[data-axis="${axis}"]`).forEach(b => {
                                    b.classList.toggle('active', b.dataset.value === String(val));
                                });
                            });
                            document.getElementById('edit_good_point').value = this.dataset.goodPoint ?? '';
                            document.getElementById('edit_bad_point').value = this.dataset.badPoint ?? '';

                            const photoArea = document.getElementById('edit_workingImagePreviewArea');
                            photoArea.innerHTML = '';
                            const photo = this.dataset.photo;
                            if (photo) {
                                const img = document.createElement('img');
                                img.src = `/storage/${photo}`;
                                img.style.cssText = 'width:90px; height:90px; object-fit:cover; border-radius:12px; border:1px solid #dee2e6;';
                                photoArea.appendChild(img);
                            }
                        }

                        // AllReview: 複数画像 + Amenities
                        if (source === 'all_review') {
                            const area = document.getElementById('edit_imagePreviewArea');
                            area.innerHTML = '';
                            document.getElementById('edit_deletedImagesContainer').innerHTML = '';
                            document.getElementById('edit_addImageBtn').style.display = 'flex';

                            const existingImages = JSON.parse(this.dataset.images || '[]');
                            existingImages.forEach((path, i) => {
                                editFiles.push({ file: null, isExisting: true, path });
                                makePreviewItem(`/storage/${path}`, i);
                            });
                            if (editFiles.length >= MAX_IMG) {
                                document.getElementById('edit_addImageBtn').style.display = 'none';
                            }

                            const amenities = JSON.parse(this.dataset.amenities || '[]');
                            document.querySelectorAll('.edit-amenity-check').forEach(cb => {
                                cb.checked = amenities.includes(cb.value);
                                cb.closest('.amenity-label').classList.toggle('selected', cb.checked);
                            });
                        }
                    });
                });
            });
        })();
    </script>
@endpush