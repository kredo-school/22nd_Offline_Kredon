@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .container {
            display: flex;
            width: 100%;
            height: calc(100vh - 70px);
            margin-top: 70px;
        }

        .content-section {
            width: 100%;
            padding: 10px 20px 40px 20px;
            overflow-y: auto;
        }

        .detail-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
            color: #666;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: 0.2s;
        }

        .back-link:hover {
            color: #1e8b9b;
            transform: translateX(-4px);
        }

        .detail-card {
            background-color: white;
            border-radius: 16px;
            padding: 20px 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        /* 🌟 修正ポイント1：左右の高さを強制的に同期させる（stretch） */
        .spot-layout-wrapper {
            display: flex;
            gap: 30px;
            align-items: stretch;
        }

        .spot-left-col {
            flex: 1.4;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* 🌟 修正ポイント2：高さを固定せず、右カラムに合わせて自動で伸びるようにする（flex: 1） */
        .main-photo-wrapper {
            width: 100%;
            flex: 1;
            min-height: 300px;
            background-color: #f4f8fb;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #eee;
            position: relative;
        }

        /* 🌟 修正ポイント3：伸びた枠に対して、比率を崩さずに画像を敷き詰める（object-fit: cover & absolute） */
        .main-photo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            transition: opacity 0.2s;
        }

        .thumbnail-list {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .thumbnail-list::-webkit-scrollbar {
            height: 6px;
        }

        .thumbnail-list::-webkit-scrollbar-thumb {
            background: #c9d8e4;
            border-radius: 3px;
        }

        .thumb {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 3px solid transparent;
            opacity: 0.6;
            transition: 0.2s;
        }

        .thumb:hover {
            opacity: 1;
        }

        .thumb.active {
            border-color: #1e8b9b;
            opacity: 1;
        }

        /* 🌟 修正ポイント4：1画面に収めるため、右カラム全体の余白（gap）と要素サイズを圧縮 */
        .spot-right-col {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .spot-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .spot-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 0 0 5px 0;
        }

        .spot-rating {
            font-size: 14px;
            color: #f0932b;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .bookmark-btn {
            background: none;
            border: 1px solid #ddd;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.2s;
            font-size: 16px;
            color: #888;
        }

        .bookmark-btn.active {
            background-color: #fff2e6;
            border-color: #f0932b;
            color: #f0932b;
        }

        .bookmark-btn:hover {
            background-color: #f4f8fb;
        }

        .section-label {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            border-left: 4px solid #1e8b9b;
            padding-left: 8px;
            margin-bottom: 8px;
        }

        .benefit-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .benefit-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .benefit-card.active-facility:hover {
            border-color: #1e8b9b;
            background: #f0f7fa;
        }

        .benefit-card i {
            font-size: 22px;
            color: #1e8b9b;
        }

        .benefit-title {
            font-weight: bold;
            font-size: 13px;
            color: #333;
        }

        .benefit-desc {
            font-size: 11px;
            color: #666;
        }

        /* マップの高さを180pxから140pxへ圧縮 */
        .mini-map {
            width: 100%;
            height: 140px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .spot-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 2px;
        }

        .spot-tag {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .primary-btn {
            background-color: #1e8b9b;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 4px 10px rgba(30, 139, 155, 0.2);
            transition: 0.2s;
            margin-top: 5px;
        }

        .primary-btn:hover {
            background-color: #166b78;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .spot-layout-wrapper {
                flex-direction: column;
            }

            .main-photo-wrapper {
                height: 280px;
                flex: none;
                position: static;
            }

            .main-photo-wrapper img {
                position: static;
            }

            .benefit-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .detail-card {
                padding: 15px;
            }
        }

        .review-section {
            margin-top: 40px;
        }

        .review-card-item {
            background: white;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .custom-modal.is-show {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            background: none;
            border: none;
            color: #888;
        }

        .rating-group {
            display: flex;
            justify-content: space-between;
            gap: 6px;
            margin-top: 8px;
        }

        .rating-radio {
            display: none;
        }

        .rating-label {
            flex: 1;
            text-align: center;
            background-color: #f4f8fb;
            border: 1px solid #c9d8e4;
            border-radius: 8px;
            padding: 10px 0;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            color: #555;
            transition: all 0.2s ease;
        }

        .rating-radio:checked+.rating-label {
            background-color: #1e8b9b;
            color: white;
            border-color: #1e8b9b;
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-btn {
            background-color: #f4f8fb;
            border: 2px dashed #4a82b3;
            color: #4a82b3;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            display: block;
            cursor: pointer;
        }

        .file-upload-input {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            height: 100%;
        }
    </style>

    @if (session('success'))
        <div id="flash-message"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #1e8b9b; color: white; padding: 12px 24px; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 10000; transition: opacity 0.5s ease;">
            {{ session('success') }}
        </div>
        <script>setTimeout(() => { const msg = document.getElementById('flash-message'); if (msg) { msg.style.opacity = '0'; setTimeout(() => msg.remove(), 500); } }, 3000);</script>
    @endif

    <div class="container">
        <div class="content-section">
            <div class="detail-container">

                <a href="{{ url('/') }}" class="back-link"><i class="fa-solid fa-chevron-left"></i> 一覧に戻る</a>

                <div class="detail-card">
                    <div class="spot-layout-wrapper">

                        <div class="spot-left-col">
                            <div class="main-photo-wrapper">
                                @if($spot->photos->count() > 0)
                                    <img id="mainGalleryImage"
                                        src="{{ asset('storage/' . $spot->photos->first()->photo_path) }}"
                                        alt="{{ $spot->name }}">
                                @elseif($spot->photo_path)
                                    <img id="mainGalleryImage" src="{{ asset('storage/' . $spot->photo_path) }}"
                                        alt="{{ $spot->name }}">
                                @else
                                    <img id="mainGalleryImage" src="https://placehold.co/800x600/e6f0f9/4a82b3?text=No+Photo"
                                        alt="写真なし">
                                @endif
                            </div>

                            @if($spot->photos->count() > 1)
                                <div class="thumbnail-list">
                                    @foreach($spot->photos as $index => $photo)
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}"
                                            class="thumb {{ $index === 0 ? 'active' : '' }}"
                                            onclick="changeMainImage(this, '{{ asset('storage/' . $photo->photo_path) }}')"
                                            alt="サムネイル">
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="spot-right-col">
                            <div class="spot-header-top">
                                <div>
                                    <h1 class="spot-title">{{ $spot->name }}</h1>
                                    <div class="spot-rating">
                                        <i class="fa-solid fa-star"></i>
                                        {{ $spot->reviews->count() > 0 ? number_format($spot->reviews->avg('customer_vibe') ?? 4.6, 1) : '-.-' }}
                                        <span style="color: #999; font-size: 13px; font-weight: normal;">/
                                            {{ $spot->reviews->count() }}件</span>
                                    </div>
                                </div>
                                <form action="{{ route('bookmarks.toggle', $spot->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit"
                                        class="bookmark-btn {{ Auth::check() && $spot->isBookmarkedBy(Auth::user()) ? 'active' : '' }}"
                                        title="お気に入り">
                                        <i class="fa-solid fa-bookmark"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="benefit-grid">
    
    <div class="benefit-card {{ $spot->has_wifi ? 'active-facility' : '' }}" style="{{ $spot->has_wifi ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
        <i class="fa-solid fa-wifi" style="color: {{ $spot->has_wifi ? '#1e8b9b' : '#999' }};"></i>
        <div>
            <div class="benefit-title" style="color: {{ $spot->has_wifi ? '#333' : '#888' }};">高速Wi-Fi</div>
            <div class="benefit-desc">{{ $spot->has_wifi ? '通信環境良好' : '設備なし' }}</div>
        </div>
    </div>
    
    <div class="benefit-card {{ $spot->has_power ? 'active-facility' : '' }}" style="{{ $spot->has_power ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
        <i class="fa-solid fa-plug" style="color: {{ $spot->has_power ? '#1e8b9b' : '#999' }};"></i>
        <div>
            <div class="benefit-title" style="color: {{ $spot->has_power ? '#333' : '#888' }};">電源完備</div>
            <div class="benefit-desc">{{ $spot->has_power ? '各席に完備' : '設備なし' }}</div>
        </div>
    </div>

    @php
        // 🌟 クチコミの件数と平均点を計算
        $reviewCount = $spot->reviews->count();
        
        // 客層(5=もくもく)と照明(5=明るい)の平均
        $focusScore = $reviewCount > 0 
            ? ($spot->reviews->avg('customer_vibe') + $spot->reviews->avg('eye_fatigue_level')) / 2 
            : 0;
            
        // イス(5=ふかふか)と机(5=広い)の平均
        $comfortScore = $reviewCount > 0 
            ? ($spot->reviews->avg('chair_comfort') + $spot->reviews->avg('desk_stability')) / 2 
            : 0;
            
        // 基準値（平均3以上なら true となる）
        $isFocus = $focusScore >= 3;
        $isComfort = $comfortScore >= 3;
    @endphp

    <div class="benefit-card {{ $isFocus ? 'active-facility' : '' }}" style="{{ $isFocus ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
        <i class="fa-solid fa-user-ninja" style="color: {{ $isFocus ? '#1e8b9b' : '#999' }};"></i>
        <div>
            <div class="benefit-title" style="color: {{ $isFocus ? '#333' : '#888' }};">ノイズレス環境</div>
            <div class="benefit-desc" style="color: {{ $isFocus ? '#1e8b9b' : '#999' }}; font-weight: {{ $isFocus ? 'bold' : 'normal' }};">
                @if($reviewCount == 0)
                    クチコミ待ち
                @elseif($isFocus)
                    集中作業◎
                @else
                    少し賑やかかも
                @endif
            </div>
        </div>
    </div>

    <div class="benefit-card {{ $isComfort ? 'active-facility' : '' }}" style="{{ $isComfort ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
        <i class="fa-solid fa-chair" style="color: {{ $isComfort ? '#1e8b9b' : '#999' }};"></i>
        <div>
            <div class="benefit-title" style="color: {{ $isComfort ? '#333' : '#888' }};">快適なイス・机</div>
            <div class="benefit-desc" style="color: {{ $isComfort ? '#1e8b9b' : '#999' }}; font-weight: {{ $isComfort ? 'bold' : 'normal' }};">
                @if($reviewCount == 0)
                    クチコミ待ち
                @elseif($isComfort)
                    長時間の作業◎
                @else
                    長時間はキツイかも
                @endif
            </div>
        </div>
    </div>

</div>
                        

                        <div class="mini-map">
                            <iframe width="100%" height="100%" style="border:0;" loading="lazy" allowfullscreen
                                src="https://maps.google.com/maps?q={{ urlencode($spot->name . ' ' . $spot->area . ' Cebu') }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                            </iframe>
                        </div>

                        <div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 3px;">📍 エリア：{{ $spot->area }}</div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 8px;">🕒
                                営業時間：{{ $spot->hours ?? '未設定' }}</div>
                            <div class="spot-tags">
                                @if($spot->has_wifi)<span class="spot-tag">フリーWi-Fi</span>@endif
                                @if($spot->has_power)<span class="spot-tag">コンセント</span>@endif
                            </div>
                        </div>

                        @if(Auth::check() && Auth::id() === $spot->user_id)
                            <button onclick="document.getElementById('editSpotModal').classList.add('is-show')"
                                style="background-color: white; color: #4a82b3; border: 1px solid #4a82b3; padding: 6px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 12px; transition: 0.2s;">
                                <i class="fa-solid fa-pen"></i> 店舗情報を編集
                            </button>
                        @endif

                        <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.add('is-show')"
                            class="primary-btn">
                            レビューを書く
                        </button>

                    </div>
                </div>
            </div>

            <!-- 💬 レビュー一覧 -->
            <div class="review-section">
                <h3
                    style="font-size: 20px; color: #333; border-bottom: 2px solid #1e8b9b; padding-bottom: 10px; margin-bottom: 20px;">
                    みんなのリアルな感想（{{ $spot->reviews->count() }}件）
                </h3>

                @if($spot->reviews->isEmpty())
                    <p
                        style="color: #999; text-align: center; padding: 20px 0; background: white; border-radius: 12px; border: 1px dashed #ccc;">
                        まだ感想が投稿されていません。最初の発見者になりましょう！</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        @foreach($spot->reviews()->latest()->get() as $review)
                            <div class="review-card-item">
                                @if(Auth::check() && Auth::id() === $review->user_id)
                                    <div style="display: flex; gap: 10px; justify-content: flex-end; margin-bottom: 10px;">
                                        <button
                                            onclick="document.getElementById('editReviewModal-{{ $review->id }}').classList.add('is-show')"
                                            style="color: #1e8b9b; background: none; border: none; font-size: 13px; cursor: pointer; font-weight: bold;"><i
                                                class="fa-solid fa-pen"></i> 編集</button>
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                            onsubmit="return confirm('削除しますか？');" style="margin: 0;">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                style="color: #e53e3e; background: none; border: none; font-size: 13px; cursor: pointer; font-weight: bold;"><i
                                                    class="fa-regular fa-trash-can"></i> 削除</button>
                                        </form>
                                    </div>
                                @endif

                                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px;">
                                    @if($review->customer_vibe)<span
                                        style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">👥
                                    客層: {{ $review->customer_vibe }}</span>@endif
                                    @if($review->eye_fatigue_level)<span
                                        style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">👁️
                                    照明: {{ $review->eye_fatigue_level }}</span>@endif
                                    @if($review->chair_comfort)<span
                                        style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">🪑
                                    イス: {{ $review->chair_comfort }}</span>@endif
                                    @if($review->desk_stability)<span
                                        style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">🏢
                                    机: {{ $review->desk_stability }}</span>@endif
                                </div>

                                @if($review->photo_path)
                                    <img src="{{ asset('storage/' . $review->photo_path) }}"
                                        style="max-width: 100%; max-height: 250px; border-radius: 8px; object-fit: cover; margin-bottom: 15px;">
                                @endif

                                @if($review->comment)
                                    <div
                                        style="color: #333; line-height: 1.6; font-size: 14px; white-space: pre-wrap; margin-bottom: 15px;">
                                {{ $review->comment }}</div>@endif

                                @if($review->good_point || $review->bad_point)
                                    <div
                                        style="display: flex; gap: 15px; font-size: 12px; background: #fafafa; padding: 10px; border-radius: 6px; border: 1px dashed #eee;">
                                        @if($review->good_point)
                                            <div style="flex: 1; color: #e53e3e; font-weight: bold;">👍 Good: <span
                                        style="font-weight: normal; color: #555;">{{ $review->good_point }}</span></div>@endif
                                        @if($review->bad_point)
                                            <div style="flex: 1; color: #3182ce; font-weight: bold;">👎 Bad: <span
                                        style="font-weight: normal; color: #555;">{{ $review->bad_point }}</span></div>@endif
                                    </div>
                                @endif
                            </div>

                            <!-- 🌟 既存レビュー編集モーダル -->
                            @if(Auth::check() && Auth::id() === $review->user_id)
                                <div class="custom-modal" id="editReviewModal-{{ $review->id }}">
                                    <div class="modal-content" style="padding: 0;">
                                        <div
                                            style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                                            <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">レビューを編集</h2>
                                            <button type="button"
                                                onclick="document.getElementById('editReviewModal-{{ $review->id }}').classList.remove('is-show')"
                                                class="close-btn" style="position: static;">×</button>
                                        </div>

                                        <form action="{{ route('reviews.update', $review->id) }}" method="POST"
                                            enctype="multipart/form-data" style="padding: 20px;">
                                            @csrf
                                            @method('PUT')

                                            <div style="margin-bottom: 20px;">
                                                <label
                                                    style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸
                                                    写真を変更（そのままなら未選択でOK）</label>
                                                <input type="file" name="photo" accept="image/*" style="width: 100%;">
                                            </div>

                                            <div
                                                style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
                                                <p
                                                    style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">
                                                    🔍 ニッチな評価をシェア（1〜5で選択）</p>

                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥
                                                        客層</label>
                                                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                        name="customer_vibe" id="vibe_{{ $review->id }}_{{ $i }}" value="{{ $i }}"
                                                        class="rating-radio" {{ $review->customer_vibe == $i ? 'checked' : '' }}><label for="vibe_{{ $review->id }}_{{ $i }}"
                                                    class="rating-label">{{ $i }}</label>@endfor</div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← ワイワイ</span><span>もくもく作業 →</span></div>
                                                </div>

                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️
                                                        照明</label>
                                                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                        name="eye_fatigue_level" id="eye_{{ $review->id }}_{{ $i }}"
                                                        value="{{ $i }}" class="rating-radio" {{ $review->eye_fatigue_level == $i ? 'checked' : '' }}><label for="eye_{{ $review->id }}_{{ $i }}"
                                                    class="rating-label">{{ $i }}</label>@endfor</div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← 暗め（雰囲気重視）</span><span>明るい（読書向き） →</span></div>
                                                </div>

                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑
                                                        イス</label>
                                                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                        name="chair_comfort" id="chair_{{ $review->id }}_{{ $i }}" value="{{ $i }}"
                                                        class="rating-radio" {{ $review->chair_comfort == $i ? 'checked' : '' }}><label for="chair_{{ $review->id }}_{{ $i }}"
                                                    class="rating-label">{{ $i }}</label>@endfor</div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← 硬い（長居キツイ）</span><span>ふかふか（快適） →</span></div>
                                                </div>

                                                <div style="margin-bottom: 0;">
                                                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢
                                                        机</label>
                                                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                        name="desk_stability" id="desk_{{ $review->id }}_{{ $i }}" value="{{ $i }}"
                                                        class="rating-radio" {{ $review->desk_stability == $i ? 'checked' : '' }}><label for="desk_{{ $review->id }}_{{ $i }}"
                                                    class="rating-label">{{ $i }}</label>@endfor</div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← 狭い・ガタつく</span><span>広い・安定感バツグン →</span></div>
                                                </div>
                                            </div>
                                            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                                <div style="flex: 1;"><label
                                                        style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍
                                                        Good</label><input type="text" name="good_point"
                                                        value="{{ $review->good_point }}"
                                                        style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                                </div>
                                                <div style="flex: 1;"><label
                                                        style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">👎
                                                        Bad</label><input type="text" name="bad_point" value="{{ $review->bad_point }}"
                                                        style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 25px;"><label
                                                    style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝
                                                    感想</label><textarea name="comment" rows="3"
                                                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none;">{{ $review->comment }}</textarea>
                                            </div>
                                            <div style="text-align: center;"><button type="submit"
                                                    style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; cursor: pointer; width: 100%;">更新する</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
    </div>

    <!-- 🌟 新規レビュー投稿モーダル -->
    <div class="custom-modal" id="reviewModal-{{ $spot->id }}">
        <div class="modal-content" style="padding: 0;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">レビュー・最新情報を投稿</h2>
                <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.remove('is-show')"
                    class="close-btn" style="position: static;">×</button>
            </div>

            <form action="{{ route('reviews.store', $spot->id) }}" method="POST" enctype="multipart/form-data"
                style="padding: 20px;">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸
                        席の様子やメニューの写真（任意）</label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-btn">
                            <i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>
                            写真を選択（またはドラッグ＆ドロップ）
                        </div>
                        <input type="file" name="photo" class="file-upload-input" accept="image/*">
                    </div>
                </div>

                <div
                    style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
                    <p style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">🔍
                        ニッチな評価をシェア（1〜5で選択）</p>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥 客層</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="customer_vibe"
                            id="new_vibe_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_vibe_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← ワイワイ</span><span>もくもく作業 →</span></div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️ 照明</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="eye_fatigue_level"
                            id="new_eye_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_eye_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← 暗め（雰囲気重視）</span><span>明るい（読書向き） →</span></div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑 イス</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="chair_comfort"
                            id="new_chair_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_chair_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← 硬い（長居キツイ）</span><span>ふかふか（快適） →</span></div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢 机</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="desk_stability"
                            id="new_desk_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_desk_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← 狭い・ガタつく</span><span>広い・安定感バツグン →</span></div>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;"><label
                            style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍
                            Goodポイント</label><input type="text" name="good_point"
                            style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <div style="flex: 1;"><label
                            style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">
                            気になるポイント</label><input type="text" name="bad_point"
                            style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                </div>
                <div style="margin-bottom: 25px;"><label
                        style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝
                        リアルな感想・最新状況</label><textarea name="comment" rows="3"
                        style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; resize: none;"></textarea>
                </div>
                <div style="text-align: center;"><button type="submit"
                        style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">シェアする</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 🌟 スポット編集モーダル -->
    @if(Auth::check() && Auth::id() === $spot->user_id)
        <div class="custom-modal" id="editSpotModal">
            <div class="modal-content" style="padding: 0;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                    <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">スポット情報を更新</h2>
                    <button type="button" onclick="document.getElementById('editSpotModal').classList.remove('is-show')"
                        class="close-btn" style="position: static;">×</button>
                </div>

                <form action="{{ route('spots.update', $spot->id) }}" method="POST" enctype="multipart/form-data"
                    style="padding: 20px;">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🏢
                            スポット名</label>
                        <input type="text" name="name" value="{{ $spot->name }}" required
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
                    </div>

                    <div
                        style="margin-bottom: 15px; display: flex; gap: 20px; background-color: #f4f8fb; padding: 15px; border-radius: 8px; border: 1px solid #c9d8e4; justify-content: center;">
                        <label
                            style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 15px;">
                            <input type="checkbox" name="has_power" value="1" {{ $spot->has_power ? 'checked' : '' }}
                                style="transform: scale(1.3);"> 🔌 コンセントあり
                        </label>
                        <label
                            style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 15px;">
                            <input type="checkbox" name="has_wifi" value="1" {{ $spot->has_wifi ? 'checked' : '' }}
                                style="transform: scale(1.3);"> 📶 Wi-Fiあり
                        </label>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">📍
                            エリア</label>
                        <select name="area" required
                            style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; background-color: white;">
                            <option value="ITパーク" {{ $spot->area == 'ITパーク' ? 'selected' : '' }}>ITパーク</option>
                            <option value="アヤラ" {{ $spot->area == 'アヤラ' ? 'selected' : '' }}>アヤラ</option>
                            <option value="その他（タクシー圏内）" {{ $spot->area == 'その他（タクシー圏内）' ? 'selected' : '' }}>その他（タクシー圏内）</option>
                        </select>
                    </div>

                    <div
                        style="margin-bottom: 15px; background-color: #fafafa; padding: 10px; border-radius: 6px; border: 1px solid #eee;">
                        <span style="color: #666; font-size: 13px; font-weight: bold; display: block; margin-bottom: 8px;">🕒
                            営業時間 (現在: {{ $spot->hours ?: '未設定' }})</span>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="time" name="open_time" step="1800"
                                style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <span style="color: #999;">〜</span>
                            <input type="time" name="close_time" step="1800"
                                style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸
                            写真を追加・変更する（複数選択可）</label>
                        <input type="file" name="photos[]" multiple accept="image/*" style="width: 100%; font-size: 14px;">
                        <div style="font-size: 11px; color: #888; margin-top: 5px;">※Ctrlキー（MacはCommandキー）を押しながらで複数枚選択できます（最大5枚）
                        </div>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit"
                            style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">
                            最新情報に上書きする
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        function changeMainImage(thumbElement, imageUrl) {
            const mainImg = document.getElementById('mainGalleryImage');
            mainImg.style.opacity = 0.5;
            setTimeout(() => { mainImg.src = imageUrl; mainImg.style.opacity = 1; }, 150);
            document.querySelectorAll('.thumb').forEach(el => el.classList.remove('active'));
            thumbElement.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('click', function (e) {
                if (e.target.classList.contains('custom-modal')) { e.target.classList.remove('is-show'); }
            });

            const fileInput = document.querySelector('.file-upload-input');
            const fileLabel = document.querySelector('.file-upload-btn');
            if (fileInput && fileLabel) {
                fileInput.addEventListener('change', function (e) {
                    if (e.target.files.length > 0) {
                        fileLabel.innerHTML = '<i class="fa-solid fa-check" style="font-size: 24px; margin-bottom: 5px; display: block; color: #297a6a;"></i>画像を選択しました！';
                        fileLabel.style.borderColor = '#297a6a';
                        fileLabel.style.color = '#297a6a';
                    }
                });
            }
        });
    </script>
@endsection