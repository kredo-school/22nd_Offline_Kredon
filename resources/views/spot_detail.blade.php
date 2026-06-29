@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

    <style>
        /* --- 基本レイアウト --- */
        .spot-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .spot-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            border: 1px solid #eee;
            width: 100%;
            box-sizing: border-box;
        }

        .spot-card-header {
            margin-bottom: 12px;
            border-bottom: 1px solid #f4f8fb;
            padding-bottom: 8px;
        }

        .spot-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
            display: block;
        }

        .spot-hours {
            font-size: 12px;
            color: #666;
        }

        .spot-main-photo {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .spot-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
        }

        .spot-facilities {
            font-size: 12px;
            color: #333;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .spot-facilities i {
            color: #1e8b9b;
            font-size: 14px;
        }

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
            margin-bottom: 0;
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

        /* 🌟 プロ仕様：無駄な背景グレーと余白を完全に廃止し、ドカンとダイナミックに魅せる */
        .main-photo-wrapper {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #eee;
            display: block;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
        }

        .main-photo-wrapper img {
            width: 100%;
            height: 420px;
            display: block;
            object-fit: cover;
            transition: opacity 0.25s ease;
        }

        /* 🌟 天才的アイデア：ポラロイド・ツインデッキスタックUIのコアCSS */
        .hover-stack {
            position: relative;
            width: 100%;
            height: 140px;
        }

        .stack-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            cursor: pointer;
        }

        .stack-front {
            z-index: 2;
        }

        .stack-back-left {
            z-index: 1;
            transform: scale(0.93) translate(14px, 12px) rotate(4.5deg);
            filter: brightness(0.88);
        }

        .stack-back-right {
            z-index: 1;
            transform: scale(0.93) translate(-14px, 12px) rotate(-4.5deg);
            filter: brightness(0.88);
        }

        /* マウスホバー時にトランプの山のようにシャッ！と広がる極上のギミック */
        @media (min-width: 769px) {
            .hover-stack:hover .stack-front {
                transform: scale(0.98) translateY(-4px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .hover-stack:hover .stack-back-left {
                transform: scale(1.02) translate(35px, 15px) rotate(8deg);
                filter: brightness(1);
                z-index: 3;
            }

            .hover-stack:hover .stack-back-right {
                transform: scale(1.02) translate(-35px, 15px) rotate(-8deg);
                filter: brightness(1);
                z-index: 3;
            }
        }

        .thumbnail-item {
            flex-shrink: 0;
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
            opacity: 0.6;
        }

        .thumbnail-item:hover {
            transform: scale(1.05);
            opacity: 1;
        }

        .thumbnail-item.active {
            border-color: #1e8b9b;
            opacity: 1;
            box-shadow: 0 2px 6px rgba(30, 139, 155, 0.3);
            transform: scale(1.05);
        }

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
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.2s;
            font-size: 18px;
            color: #888;
        }

        .bookmark-btn.active {
            background-color: #fff0f0;
            border-color: #ff6b6b;
            color: #ff6b6b;
        }

        .bookmark-btn:hover {
            background-color: #f4f8fb;
            transform: scale(1.05);
        }

        .benefit-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        /* 🌟 プロ仕様：標準カードとアクティブカードに圧倒的な格差をつけるデザイン設計 */
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

        .benefit-card.active-facility {
            border: 2px solid #4a82b3 !important;
            background-color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(74, 130, 179, 0.1);
        }

        .benefit-card.active-facility:hover {
            border-color: #1e8b9b !important;
            background: #f0f7fa !important;
            transform: translateY(-1px);
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

        .mini-map {
            width: 100%;
            height: 140px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #eee;
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

        .sortable-ghost {
            opacity: 0.4;
            background-color: #f0f7fa !important;
            border: 2px dashed #1e8b9b !important;
        }

        @media (max-width: 768px) {
            .container {
                height: auto;
                margin-top: 60px;
            }

            .content-section {
                padding: 10px 15px 60px 15px;
            }

            .spot-detail-header {
                align-items: center !important;
                gap: 10px;
            }

            .spot-title-top {
                font-size: 20px !important;
            }

            .spot-layout-wrapper {
                flex-direction: column;
                gap: 20px;
            }

            .main-photo-wrapper {
                border-radius: 12px;
            }

            .main-photo-wrapper img {
                height: 260px;
            }

            .hover-stack {
                height: 100px;
            }

            .stack-back-left {
                transform: scale(0.91) translate(10px, 10px) rotate(5deg);
            }

            .stack-back-right {
                transform: scale(0.91) translate(-10px, 10px) rotate(-5deg);
            }

            .benefit-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .detail-card {
                padding: 15px;
            }

            .modal-content {
                width: 95%;
                padding: 15px;
            }

            .rating-label {
                padding: 8px 0;
                font-size: 14px;
            }

            .time-row-responsive {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 5px !important;
            }

            .time-row-responsive div {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .time-row-responsive input {
                flex: 1;
            }

            .good-bad-responsive {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>

    <div class="container">
        <div class="content-section">
            <div class="spot-detail-header"
                style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; width: 100%; border-bottom: 2px solid #f4f8fb; padding-bottom: 12px;">
                <div style="flex: 1; padding-right: 15px;">
                    <div
                        style="font-size: 11px; font-weight: bold; color: #1e8b9b; letter-spacing: 1px; margin-bottom: 6px; display: inline-block; background: #e6f2f4; padding: 4px 10px; border-radius: 6px;">
                        <i class="fa-solid fa-book-open-reader"></i> 学習スポット詳細
                    </div>
                    <h1 class="spot-title-top"
                        style="font-size: 28px; font-weight: 900; color: #2d3748; margin: 0; line-height: 1.3; word-break: break-word;">
                        {{ $spot->name }}
                    </h1>
                </div>
                <a href="{{ url('/') }}" class="back-link" style="margin-bottom: 6px; flex-shrink: 0;">
                    <i class="fa-solid fa-chevron-left"></i> 一覧に戻る
                </a>
            </div>

            <div class="detail-card">
                <div class="spot-layout-wrapper">
                    <div class="spot-left-col">
                        <div class="main-photo-wrapper">
                            @if($spot->photo_path)
                                <img id="mainGalleryImage" src="{{ asset('storage/' . $spot->photo_path) }}"
                                    alt="{{ $spot->name }}">
                            @elseif($spot->photos->count() > 0)
                                <img id="mainGalleryImage"
                                    src="{{ asset('storage/' . $spot->photos->sortBy('sort_order')->first()->photo_path) }}"
                                    alt="{{ $spot->name }}">
                            @else
                                <img id="mainGalleryImage" src="https://placehold.co/800x600/e6f0f9/4a82b3?text=No+Photo"
                                    alt="写真なし">
                            @endif
                        </div>

                        {{-- 🌟 天才的設計：2カラム分割型のトランプポラロイドスタックUIのレンダリング --}}
                        @php
                            $subPhotos = $spot->photos->sortBy('sort_order')->skip(1)->values();
                        @endphp

                        @if($subPhotos->count() > 0)
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 10px 5px 15px 5px;">
                                {{-- 左カラム（2枚目を前面、4枚目があれば背面に配置） --}}
                                <div class="hover-stack">
                                    @if(isset($subPhotos[2]))
                                        <img src="{{ asset('storage/' . $subPhotos[2]->photo_path) }}"
                                            onclick="changeMainImage(this, '{{ asset('storage/' . $subPhotos[2]->photo_path) }}')"
                                            class="stack-img stack-back-left">
                                    @endif
                                    @if(isset($subPhotos[0]))
                                        <img src="{{ asset('storage/' . $subPhotos[0]->photo_path) }}"
                                            onclick="changeMainImage(this, '{{ asset('storage/' . $subPhotos[0]->photo_path) }}')"
                                            class="stack-img stack-front">
                                    @endif
                                </div>

                                {{-- 右カラム（3枚目を前面、5枚目があれば背面に配置） --}}
                                @if(isset($subPhotos[1]))
                                    <div class="hover-stack">
                                        @if(isset($subPhotos[3]))
                                            <img src="{{ asset('storage/' . $subPhotos[3]->photo_path) }}"
                                                onclick="changeMainImage(this, '{{ asset('storage/' . $subPhotos[3]->photo_path) }}')"
                                                class="stack-img stack-back-right">
                                        @endif
                                        <img src="{{ asset('storage/' . $subPhotos[1]->photo_path) }}"
                                            onclick="changeMainImage(this, '{{ asset('storage/' . $subPhotos[1]->photo_path) }}')"
                                            class="stack-img stack-front">
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="spot-right-col">
                        <div class="spot-header-top">
                            <div>
                                <div class="spot-rating"
                                    style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-star"></i>
                                        {{ $spot->reviews->count() > 0 ? number_format($spot->reviews->avg('customer_vibe') ?? 4.6, 1) : '-.-' }}
                                        <span style="color: #999; font-size: 13px; font-weight: normal;">/
                                            {{ $spot->reviews->count() }}件</span>
                                    </div>
                                </div>
                            </div>

                            @php $bookmarkCount = $spot->bookmarks()->count(); @endphp
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 13px; font-weight: bold; color: #888;">
                                    <span style="color: #ff6b6b;">{{ $bookmarkCount }}</span> 人がお気に入り
                                </span>
                                <form action="{{ route('bookmarks.toggle', $spot->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit"
                                        class="bookmark-btn {{ Auth::check() && $spot->isBookmarkedBy(Auth::user()) ? 'active' : '' }}"
                                        title="お気に入りに追加 / 解除">
                                        <i class="fa-solid fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="benefit-grid">
                            {{-- 1つ目：高速Wi-Fiカード --}}
                            <div class="benefit-card {{ $spot->has_wifi ? 'active-facility' : '' }}"
                                style="{{ $spot->has_wifi ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
                                <i class="fa-solid fa-wifi" style="color: {{ $spot->has_wifi ? '#1e8b9b' : '#999' }};"></i>
                                <div>
                                    <div class="benefit-title" style="color: {{ $spot->has_wifi ? '#333' : '#888' }};">
                                        高速Wi-Fi</div>
                                    <div class="benefit-desc"
                                        style="color: {{ $spot->has_wifi ? '#1e8b9b' : '#999' }}; font-weight: {{ $spot->has_wifi ? 'bold' : 'normal' }};">
                                        {{ $spot->has_wifi ? '独自wi-fiあり' : '設備なし' }}</div>
                                </div>
                            </div>

                            {{-- 2つ目：電源完備カード --}}
                            <div class="benefit-card {{ $spot->has_power ? 'active-facility' : '' }}"
                                style="{{ $spot->has_power ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
                                <i class="fa-solid fa-plug" style="color: {{ $spot->has_power ? '#1e8b9b' : '#999' }};"></i>
                                <div>
                                    <div class="benefit-title" style="color: {{ $spot->has_power ? '#333' : '#888' }};">電源完備
                                    </div>
                                    <div class="benefit-desc"
                                        style="color: {{ $spot->has_power ? '#1e8b9b' : '#999' }}; font-weight: {{ $spot->has_power ? 'bold' : 'normal' }};">
                                        {{ $spot->has_power ? '設備あり' : '設備なし' }}</div>
                                </div>
                            </div>

                            @php
                                $reviewCount = $spot->reviews->count();
                                $focusScore = $reviewCount > 0 ? ($spot->reviews->avg('customer_vibe') + $spot->reviews->avg('eye_fatigue_level')) / 2 : 0;
                                $comfortScore = $reviewCount > 0 ? ($spot->reviews->avg('chair_comfort') + $spot->reviews->avg('desk_stability')) / 2 : 0;
                                $isFocus = $focusScore >= 3;
                                $isComfort = $comfortScore >= 3;
                            @endphp

                            {{-- 3つ目：ノイズレスカード --}}
                            <div class="benefit-card {{ $isFocus ? 'active-facility' : '' }}"
                                style="{{ $isFocus ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
                                <i class="fa-solid fa-user-ninja" style="color: {{ $isFocus ? '#1e8b9b' : '#999' }};"></i>
                                <div>
                                    <div class="benefit-title" style="color: {{ $isFocus ? '#333' : '#888' }};">ノイズレス環境
                                    </div>
                                    <div class="benefit-desc"
                                        style="color: {{ $isFocus ? '#1e8b9b' : '#999' }}; font-weight: {{ $isFocus ? 'bold' : 'normal' }};">
                                        @if($reviewCount == 0) クチコミ待ち @elseif($isFocus) 集中作業◎ @else 少し賑やかかも @endif
                                    </div>
                                </div>
                            </div>

                            {{-- 4つ目：快適な机・椅子カード --}}
                            <div class="benefit-card {{ $isComfort ? 'active-facility' : '' }}"
                                style="{{ $isComfort ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
                                <i class="fa-solid fa-chair" style="color: {{ $isComfort ? '#1e8b9b' : '#999' }};"></i>
                                <div>
                                    <div class="benefit-title" style="color: {{ $isComfort ? '#333' : '#888' }};">快適なイス・机
                                    </div>
                                    <div class="benefit-desc"
                                        style="color: {{ $isComfort ? '#1e8b9b' : '#999' }}; font-weight: {{ $isComfort ? 'bold' : 'normal' }};">
                                        @if($reviewCount == 0) クチコミ待ち @elseif($isComfort) 長時間の作業◎ @else 長時間はキツイかも @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mini-map">
                            <iframe width="100%" height="100%" style="border:0;" loading="lazy" allowfullscreen
                                src="https://maps.google.com/maps?q={{ urlencode($spot->name . ' ' . $spot->area . ' Cebu') }}&t=&z=15&ie=UTF8&iwloc=&output=embed"></iframe>
                        </div>

                        <div
                            style="background-color: #f8fafc; padding: 12px 15px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 5px;">
                            <div style="font-size: 14px; font-weight: bold; color: #475569; margin-bottom: 6px;">📍
                                エリア：<span style="color: #333; font-size: 15px;">{{ $spot->area }}</span></div>
                            <div style="font-size: 14px; font-weight: bold; color: #475569;">🕒 営業時間：<span
                                    style="color: #333; font-size: 15px;">{{ $spot->hours ?? '未設定' }}</span></div>
                        </div>

                        @if($spot->description)
                        <div style="background-color: #ffffff; padding: 18px 15px; border-radius: 12px; border: 2px solid #e6f2f4; margin-top: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                            <h3 style="font-size: 14px; font-weight: bold; color: #1e8b9b; margin-top: 0; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-circle-info"></i> スポットの詳細・ニッチ情報
                            </h3>
                            <div style="font-size: 13.5px; color: #444; line-height: 1.8; letter-spacing: 0.3px;">
                                {!! nl2br(e($spot->description)) !!}
                            </div>
                        </div>
                        @endif

                        <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.add('is-show')"
                            class="primary-btn" style="margin-bottom: 12px; margin-top: 15px;">レビューを書く</button>

                        @if(Auth::check())
                            <button onclick="document.getElementById('editSpotModal').classList.add('is-show')"
                                style="background-color: white; color: #4a82b3; border: 1px solid #4a82b3; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 13px; transition: 0.2s; width: 100%; margin-bottom: 15px;">
                                <i class="fa-solid fa-pen"></i> スポット情報を編集（Wiki）
                            </button>
                            @if(Auth::id() === $spot->user_id)
                                <form action="{{ route('spots.destroy', $spot->id) }}" method="POST"
                                    onsubmit="return confirm('【警告】本当にこのスポットを削除しますか？\n※投稿されたレビューや写真もすべて消去されます。');"
                                    style="margin-bottom: 15px;">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="background-color: white; color: #e53e3e; border: 1px solid #e53e3e; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 13px; transition: 0.2s; width: 100%;">
                                        <i class="fa-solid fa-trash-can"></i> このスポットを削除する
                                    </button>
                                </form>
                            @endif

                            <div
                                style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                <div style="font-size: 11px; color: #64748b; display: flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-clock-rotate-left" style="color: #1e8b9b;"></i>
                                    最終更新: <strong>{{ $spot->lastEditor->name ?? $spot->user->name ?? '不明' }}</strong>さん
                                    <button type="button"
                                        onclick="document.getElementById('historyModal-{{ $spot->id }}').classList.add('is-show')"
                                        style="background: none; border: none; color: #4a82b3; text-decoration: underline; cursor: pointer; font-size: 11px; margin-left: 2px; padding: 0;">(履歴)</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

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
                                    @if($review->customer_vibe)
                                        <span
                                            style="background: #f0f7fa; border: 1px solid #c9e2e8; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: bold; color: #1e8b9b;">👥
                                            客層 <span
                                                style="color: #f0932b; margin-left: 2px;">★</span>{{ $review->customer_vibe }}</span>
                                    @endif
                                    @if($review->eye_fatigue_level)
                                        <span
                                            style="background: #f0f7fa; border: 1px solid #c9e2e8; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: bold; color: #1e8b9b;">👁️
                                            照明 <span
                                                style="color: #f0932b; margin-left: 2px;">★</span>{{ $review->eye_fatigue_level }}</span>
                                    @endif
                                    @if($review->chair_comfort)
                                        <span
                                            style="background: #f0f7fa; border: 1px solid #c9e2e8; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: bold; color: #1e8b9b;">🪑
                                            イス <span
                                                style="color: #f0932b; margin-left: 2px;">★</span>{{ $review->chair_comfort }}</span>
                                    @endif
                                    @if($review->desk_stability)
                                        <span
                                            style="background: #f0f7fa; border: 1px solid #c9e2e8; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: bold; color: #1e8b9b;">🏢
                                            机 <span
                                                style="color: #f0932b; margin-left: 2px;">★</span>{{ $review->desk_stability }}</span>
                                    @endif
                                </div>

                                @if($review->photo_path)
                                    <img src="{{ asset('storage/' . $review->photo_path) }}"
                                        style="max-width: 100%; max-height: 250px; border-radius: 8px; object-fit: cover; margin-bottom: 15px;">
                                @endif

                                @if($review->comment)
                                    <div style="color: #333; line-height: 1.6; font-size: 14px; margin-bottom: 15px;">
                                        {!! nl2br(e($review->comment)) !!}</div>
                                @endif

                                @if($review->good_point || $review->bad_point)
                                    <div
                                        style="display: flex; gap: 15px; font-size: 12px; background: #fafafa; padding: 10px; border-radius: 6px; border: 1px dashed #eee;">
                                        @if($review->good_point)
                                            <div style="flex: 1; color: #e53e3e; font-weight: bold;">👍 Good: <span
                                                    style="font-weight: normal; color: #555;">{{ $review->good_point }}</span></div>
                                        @endif
                                        @if($review->bad_point)
                                            <div style="flex: 1; color: #3182ce; font-weight: bold;">気になる点: <span
                                                    style="font-weight: normal; color: #555;">{{ $review->bad_point }}</span></div>
                                        @endif
                                    </div>
                                @endif
                            </div>

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
                                            @csrf @method('PUT')

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
                                                    <div class="rating-group">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <input type="radio" name="customer_vibe" id="vibe_{{ $review->id }}_{{ $i }}"
                                                                value="{{ $i }}" class="rating-radio" {{ $review->customer_vibe == $i ? 'checked' : '' }}><label for="vibe_{{ $review->id }}_{{ $i }}"
                                                                class="rating-label">{{ $i }}</label>
                                                        @endfor
                                                    </div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← ワイワイ</span><span>もくもく作業 →</span>
                                                    </div>
                                                </div>

                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️
                                                        照明</label>
                                                    <div class="rating-group">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <input type="radio" name="eye_fatigue_level" id="eye_{{ $review->id }}_{{ $i }}"
                                                                value="{{ $i }}" class="rating-radio" {{ $review->eye_fatigue_level == $i ? 'checked' : '' }}><label for="eye_{{ $review->id }}_{{ $i }}"
                                                                class="rating-label">{{ $i }}</label>
                                                        @endfor
                                                    </div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← 暗め（雰囲気重視）</span><span>明るい（読書向き） →</span>
                                                    </div>
                                                </div>

                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑
                                                        イス</label>
                                                    <div class="rating-group">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <input type="radio" name="chair_comfort" id="chair_{{ $review->id }}_{{ $i }}"
                                                                value="{{ $i }}" class="rating-radio" {{ $review->chair_comfort == $i ? 'checked' : '' }}><label for="chair_{{ $review->id }}_{{ $i }}"
                                                                class="rating-label">{{ $i }}</label>
                                                        @endfor
                                                    </div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← 硬い（長居キツイ）</span><span>ふかふか（快適） →</span>
                                                    </div>
                                                </div>

                                                <div style="margin-bottom: 0;">
                                                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢
                                                        机</label>
                                                    <div class="rating-group">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <input type="radio" name="desk_stability" id="desk_{{ $review->id }}_{{ $i }}"
                                                                value="{{ $i }}" class="rating-radio" {{ $review->desk_stability == $i ? 'checked' : '' }}><label for="desk_{{ $review->id }}_{{ $i }}"
                                                                class="rating-label">{{ $i }}</label>
                                                        @endfor
                                                    </div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                        <span>← 狭い・ガタつく</span><span>広い・安定感バツグン →</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="good-bad-responsive" style="display: flex; gap: 10px; margin-bottom: 15px;">
                                                <div style="flex: 1;">
                                                    <label
                                                        style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍
                                                        Good</label>
                                                    <input type="text" name="good_point" value="{{ $review->good_point }}"
                                                        style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                                </div>
                                                <div style="flex: 1;">
                                                    <label
                                                        style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">気になる点</label>
                                                    <input type="text" name="bad_point" value="{{ $review->bad_point }}"
                                                        style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 25px;">
                                                <label
                                                    style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝
                                                    感想</label>
                                                <textarea name="comment" rows="3"
                                                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none;">{{ $review->comment }}</textarea>
                                            </div>
                                            <div style="text-align: center;">
                                                <button type="submit"
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
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="customer_vibe" id="new_vibe_{{ $spot->id }}_{{ $i }}" value="{{ $i }}"
                                    class="rating-radio"><label for="new_vibe_{{ $spot->id }}_{{ $i }}"
                                    class="rating-label">{{ $i }}</label>
                            @endfor
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← ワイワイ</span><span>もくもく作業 →</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️ 照明</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="eye_fatigue_level" id="new_eye_{{ $spot->id }}_{{ $i }}"
                                    value="{{ $i }}" class="rating-radio"><label for="new_eye_{{ $spot->id }}_{{ $i }}"
                                    class="rating-label">{{ $i }}</label>
                            @endfor
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← 暗め（雰囲気重視）</span><span>明るい（読書向き） →</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑 イス</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="chair_comfort" id="new_chair_{{ $spot->id }}_{{ $i }}"
                                    value="{{ $i }}" class="rating-radio"><label for="new_chair_{{ $spot->id }}_{{ $i }}"
                                    class="rating-label">{{ $i }}</label>
                            @endfor
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← 硬い（長居キツイ）</span><span>ふかふか（快適） →</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢 机</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="desk_stability" id="new_desk_{{ $spot->id }}_{{ $i }}"
                                    value="{{ $i }}" class="rating-radio"><label for="new_desk_{{ $spot->id }}_{{ $i }}"
                                    class="rating-label">{{ $i }}</label>
                            @endfor
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                            <span>← 狭い・ガタつく</span><span>広い・安定感バツグン →</span>
                        </div>
                    </div>
                </div>

                <div class="good-bad-responsive" style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍
                            Goodポイント</label>
                        <input type="text" name="good_point"
                            style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">気になるポイント</label>
                        <input type="text" name="bad_point"
                            style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                </div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝
                        リアルな感想・最新状況</label>
                    <textarea name="comment" rows="3"
                        style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; resize: none;"></textarea>
                </div>
                <div style="text-align: center;">
                    <button type="submit"
                        style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">シェアする</button>
                </div>
            </form>
        </div>
    </div>

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
                    @csrf @method('PUT')

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
                        <div class="time-row-responsive" style="display: flex; align-items: center; gap: 10px;">
                            <input type="time" name="open_time" step="1800"
                                style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <span style="color: #999;">〜</span>
                            <input type="time" name="close_time" step="1800"
                                style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>
                    {{-- 🌟 追加：公式・ニッチ情報の入力欄 --}}
                    <div
                        style="margin-bottom: 15px; background-color: #fafafa; padding: 10px; border-radius: 6px; border: 1px solid #eee;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">
                            💡 スポットの詳細・ニッチ情報（公式）
                        </label>
                        <textarea name="description" rows="4" placeholder="例：ほぼ全てのテーブルにコンセント完備。2階は雰囲気最高でパソコン作業に最適です。"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none; font-size: 14px;">{{ $spot->description }}</textarea>
                    </div>
                    @if($spot->photos->count() > 0)
                        <div
                            style="margin-bottom: 15px; background-color: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px;">👑
                                トップ画像（メイン）の選択 ＆ 削除 (掴んで並び替え可能 🤝)</label>
                            <div id="sortable-photos" style="display: flex; gap: 12px; overflow-x: auto; padding-bottom: 8px;">
                                @foreach($spot->photos->sortBy('sort_order') as $photo)
                                    <div class="sortable-item" data-id="{{ $photo->id }}"
                                        style="flex-shrink: 0; text-align: center; width: 75px; cursor: grab; background: white; padding: 4px; border-radius: 8px; border: 1px solid #eee;">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}"
                                            style="width: 65px; height: 65px; object-fit: cover; border-radius: 6px; margin-bottom: 4px; user-select: none; -webkit-user-drag: none;">
                                        <label
                                            style="display: block; font-size: 11px; cursor: pointer; color: #333; font-weight: bold;">
                                            <input type="radio" name="main_photo_id" value="{{ $photo->id }}" {{ $loop->first ? 'checked' : '' }}> メイン
                                        </label>
                                        <label
                                            style="display: block; font-size: 11px; cursor: pointer; color: #e53e3e; margin-top: 4px;">
                                            <input type="checkbox" name="delete_photo_ids[]" value="{{ $photo->id }}"> 削除
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸
                            写真をさらに追加する（複数選択可）</label>
                        <input type="file" name="photos[]" multiple accept="image/*" style="width: 100%; font-size: 14px;">
                        <div style="font-size: 11px; color: #888; margin-top: 5px;">※Ctrlキー（MacはCommandキー）を押しながらで複数枚選択できます</div>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit"
                            style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">最新情報に上書きする</button>
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

            document.querySelectorAll('.thumbnail-item').forEach(el => el.classList.remove('active'));
            if (thumbElement) thumbElement.classList.add('active');
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

            /* 🌟 プロのバグ修正：クラッシュの原因となっていたBladeコメントの残骸を純粋なJSコメントへ完全駆逐 */
            const sortableEl = document.getElementById('sortable-photos');
            if (sortableEl) {
                Sortable.create(sortableEl, {
                    animation: 180,
                    ghostClass: 'sortable-ghost',
                    onEnd: function () {
                        const orderedIds = Array.from(sortableEl.querySelectorAll('.sortable-item')).map(item => item.dataset.id);

                        fetch('{{ route('spots.photos.reorder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ ids: orderedIds })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('並び順をリアルタイム自動保存しました！');
                                    const firstRadio = sortableEl.querySelector('.sortable-item:first-child input[type="radio"]');
                                    if (firstRadio) firstRadio.checked = true;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    }
                });
            }
        });
    </script>

    <div class="custom-modal" id="historyModal-{{ $spot->id }}">
        <div class="modal-content" style="padding: 0;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">📝 編集・更新履歴</h2>
                <button type="button"
                    onclick="document.getElementById('historyModal-{{ $spot->id }}').classList.remove('is-show')"
                    class="close-btn" style="position: static;">×</button>
            </div>
            <div style="padding: 20px; max-height: 350px; overflow-y: auto;">
                @if($spot->editHistories && $spot->editHistories->count() > 0)
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($spot->editHistories as $history)
                            <li style="border-bottom: 1px dashed #eee; padding: 12px 0; font-size: 13px; color: #333;">
                                <div style="color: #888; font-size: 11px; margin-bottom: 4px;">
                                    {{ $history->created_at->format('Y年m月d日 H:i') }}</div>
                                <strong>{{ $history->user->name ?? '退会したユーザー' }}</strong> さんが情報を更新しました
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="text-align: center; color: #999; font-size: 13px; margin-bottom: 0;">まだ情報の更新履歴はありません。</p>
                @endif

                <div
                    style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #f4f8fb; font-size: 13px; color: #333;">
                    <div style="color: #888; font-size: 11px; margin-bottom: 4px;">
                        {{ $spot->created_at->format('Y年m月d日 H:i') }}</div>
                    <strong>{{ $spot->user->name ?? '不明' }}</strong> さんがスポットを新規登録しました
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;

                if (activeElement.tagName === 'TEXTAREA' || activeElement.tagName === 'BUTTON' || activeElement.type === 'submit') {
                    return;
                }

                e.preventDefault();

                const form = activeElement.closest('form');
                if (!form) return;

                const focusableElements = Array.from(
                    form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled]), button[type="submit"]')
                );

                const currentIndex = focusableElements.indexOf(activeElement);
                if (currentIndex > -1 && currentIndex < focusableElements.length - 1) {
                    focusableElements[currentIndex + 1].focus();
                }
            }
        });
    </script>
@endsection