@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        .view-counter-tooltip {
            position: relative;
            display: inline-flex;
            align-items: center;
            color: #aaa;
            font-size: 13px;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: 0.2s;
        }
        .view-counter-tooltip:hover {
            background-color: #f1f5f9;
            color: #4a82b3;
        }
        .view-counter-tooltip .tooltip-text {
            visibility: hidden;
            width: 170px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 6px 0;
            position: absolute;
            z-index: 10;
            bottom: 125%;
            left: 50%;
            margin-left: -85px;
            opacity: 0;
            transition: opacity 0.2s;
            font-size: 11px;
            font-weight: normal;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .view-counter-tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }
        .view-counter-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .coupon-container {
            background: linear-gradient(135deg, #ff6b6b, #ff8e8b);
            border-radius: 14px;
            padding: 18px;
            color: white;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            margin-top: 10px;
            margin-bottom: 10px;
            border: 2px dashed rgba(255,255,255,0.4);
            animation: pulseMotion 2.5s infinite;
        }
        @keyframes pulseMotion {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4); }
            100% { transform: scale(1); }
        }
        .activate-coupon-btn {
            background: white;
            color: #ff6b6b;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 14px;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            margin-top: 10px;
        }
        .activate-coupon-btn:hover { background: #fff0f0; }
        .activate-coupon-btn:disabled { background: #e0e0e0 !important; color: #a0a0a0 !important; cursor: not-allowed; box-shadow: none !important; }

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

        @media (max-width: 768px) {
            .container { height: auto; margin-top: 60px; }
            .content-section { padding: 10px 15px 60px 15px; }
            .spot-detail-header { align-items: center !important; gap: 10px; }
            .spot-title-top { font-size: 20px !important; }
            .spot-layout-wrapper { flex-direction: column; gap: 20px; }
            .main-photo-wrapper { height: 240px; min-height: auto; flex: none; position: relative; }
            .main-photo-wrapper img { position: absolute; }
            .benefit-grid { grid-template-columns: repeat(2, 1fr); }
            .detail-card { padding: 15px; }
            .modal-content { width: 95%; padding: 15px; }
            .rating-label { padding: 8px 0; font-size: 14px; }
            .time-row-responsive { flex-direction: column; align-items: flex-start !important; gap: 5px !important; }
            .time-row-responsive div { width: 100%; display: flex; align-items: center; gap: 10px; }
            .time-row-responsive input { flex: 1; }
            .good-bad-responsive { flex-direction: column; gap: 10px; }
            
            .activate-coupon-btn { display: block; }
            .pc-coupon-notice { display: none !important; }
        }

        @media (min-width: 769px) {
            .activate-coupon-btn { display: none; }
            .pc-coupon-notice { display: block !important; }
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

                <div class="spot-detail-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; width: 100%;">
                    <h1 class="spot-title-top" style="font-size: 26px; font-weight: bold; color: #333; margin: 0;">{{ $spot->name }}</h1>
                    <a href="{{ url('/') }}" class="back-link"><i class="fa-solid fa-chevron-left"></i> 一覧に戻る</a>
                </div>

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
                                    <div class="spot-rating" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                        <div style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid fa-star"></i>
                                            {{ $spot->reviews->count() > 0 ? number_format($spot->reviews->avg('customer_vibe') ?? 4.6, 1) : '-.-' }}
                                            <span style="color: #999; font-size: 13px; font-weight: normal;">/ {{ $spot->reviews->count() }}件</span>
                                        </div>
                                        
                                        {{-- 🌟 改善版：お気に入り数とネガティブ・ソーシャルプルーフ対策 --}}
                                        @php
                                            // データベースからこのスポットのお気に入り数を安全に取得
                                            $bookmarkCount = $spot->bookmarks()->count();
                                        @endphp
                                        <div class="view-counter-tooltip">
                                            <i class="fa-solid fa-heart" style="margin-right: 4px; color: #e53e3e;"></i> お気に入り
                                            <span class="tooltip-text">
                                                @if($bookmarkCount < 5)
                                                    ✨ 新着スポット！
                                                @else
                                                    ❤️ {{ $bookmarkCount }}人がお気に入り登録中
                                                @endif
                                            </span>
                                        </div>
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
                                        <div class="benefit-desc">{{ $spot->has_wifi ? '独自wi-fiあり' : '設備なし' }}</div>
                                    </div>
                                </div>
                                
                                <div class="benefit-card {{ $spot->has_power ? 'active-facility' : '' }}" style="{{ $spot->has_power ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
                                    <i class="fa-solid fa-plug" style="color: {{ $spot->has_power ? '#1e8b9b' : '#999' }};"></i>
                                    <div>
                                        <div class="benefit-title" style="color: {{ $spot->has_power ? '#333' : '#888' }};">電源完備</div>
                                        <div class="benefit-desc">{{ $spot->has_power ? '設備あり' : '設備なし' }}</div>
                                    </div>
                                </div>

                                @php
                                    $reviewCount = $spot->reviews->count();
                                    $focusScore = $reviewCount > 0 
                                        ? ($spot->reviews->avg('customer_vibe') + $spot->reviews->avg('eye_fatigue_level')) / 2 
                                        : 0;
                                    $comfortScore = $reviewCount > 0 
                                        ? ($spot->reviews->avg('chair_comfort') + $spot->reviews->avg('desk_stability')) / 2 
                                        : 0;
                                    $isFocus = $focusScore >= 3;
                                    $isComfort = $comfortScore >= 3;
                                @endphp

                                <div class="benefit-card {{ $isFocus ? 'active-facility' : '' }}" style="{{ $isFocus ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
                                    <i class="fa-solid fa-user-ninja" style="color: {{ $isFocus ? '#1e8b9b' : '#999' }};"></i>
                                    <div>
                                        <div class="benefit-title" style="color: {{ $isFocus ? '#333' : '#888' }};">ノイズレス環境</div>
                                        <div class="benefit-desc" style="color: {{ $isFocus ? '#1e8b9b' : '#999' }}; font-weight: {{ $isFocus ? 'bold' : 'normal' }};">
                                            @if($reviewCount == 0) クチコミ待ち @elseif($isFocus) 集中作業◎ @else 少し賑やかかも @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="benefit-card {{ $isComfort ? 'active-facility' : '' }}" style="{{ $isComfort ? '' : 'opacity: 0.4; background: #f9f9f9;' }}">
                                    <i class="fa-solid fa-chair" style="color: {{ $isComfort ? '#1e8b9b' : '#999' }};"></i>
                                    <div>
                                        <div class="benefit-title" style="color: {{ $isComfort ? '#333' : '#888' }};">快適なイス・机</div>
                                        <div class="benefit-desc" style="color: {{ $isComfort ? '#1e8b9b' : '#999' }}; font-weight: {{ $isComfort ? 'bold' : 'normal' }};">
                                            @if($reviewCount == 0) クチコミ待ち @elseif($isComfort) 長時間の作業◎ @else 長時間はキツイかも @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mini-map">
                                <iframe width="100%" height="100%" style="border:0;" loading="lazy" allowfullscreen
                                    src="https://maps.google.com/maps?q={{ urlencode($spot->name . ' ' . $spot->area . ' Cebu') }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                                </iframe>
                            </div>

                            {{-- 🌟 改善：不要なタグを消し、エリアと営業時間の視認性を大幅アップ！ --}}
                            <div style="background-color: #f8fafc; padding: 12px 15px; border-radius: 8px; border: 1px solid #e2e8f0; margin-top: 5px;">
                                <div style="font-size: 14px; font-weight: bold; color: #475569; margin-bottom: 6px;">
                                    📍 エリア：<span style="color: #333; font-size: 15px;">{{ $spot->area }}</span>
                                </div>
                                <div style="font-size: 14px; font-weight: bold; color: #475569;">
                                    🕒 営業時間：<span style="color: #333; font-size: 15px;">{{ $spot->hours ?? '未設定' }}</span>
                                </div>
                            </div>

                            {{-- 🎁 改善版：サーバー連携型クーポンエリア --}}
                            <div class="coupon-container">
                                <div style="font-size: 11px; font-weight: bold; margin-bottom: 4px; letter-spacing: 0.5px;">💎 KREDONユーザー限定特典</div>
                                <div style="font-size: 16px; font-weight: bold; margin-bottom: 5px;">
                                    お店で提示すると <span style="font-size: 22px; color: #ffeaa7; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">10% OFF</span>
                                </div>
                                <div style="font-size: 11px; opacity: 0.9; margin-bottom: 10px;">※ご注文時にこの画面をスタッフにご提示ください</div>
                                
                                @php
                                    // Spotモデルに isCouponUsedByMonth() メソッドが追加されている前提の判定
                                    // まだメソッドが未作成でもエラーにならないようにmethod_existsで安全に判定
                                    $isCouponUsed = Auth::check() && method_exists($spot, 'isCouponUsedByMonth') ? $spot->isCouponUsedByMonth(Auth::user()) : false;
                                @endphp

                                @if(!Auth::check())
                                    <button type="button" onclick="alert('クーポンの利用にはログインが必要です。')" class="activate-coupon-btn mobile-only-btn">
                                        ログインしてクーポンを使う
                                    </button>
                                @elseif($isCouponUsed)
                                    <button type="button" disabled class="activate-coupon-btn mobile-only-btn">
                                        ✅ 今月は使用済み
                                    </button>
                                @else
                                    <button type="button" onclick="handleCouponActivation()" id="activeCouponBtn" class="activate-coupon-btn mobile-only-btn">
                                        スタッフの前でタップして使う
                                    </button>
                                @endif
                                
                                <div class="pc-coupon-notice" style="font-size: 11px; font-weight: bold; opacity: 0.9;">※クーポンはスマートフォンからご利用ください📱</div>
                            </div>

                           {{-- 🌟 改善：ログインしていれば誰でも編集可能（Wiki型） --}}
                            @if(Auth::check())
                                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                    <div style="font-size: 12px; color: #475569; display: flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-clock-rotate-left" style="color: #1e8b9b;"></i>
                                        最終更新: <strong>{{ $spot->lastEditor->name ?? $spot->user->name ?? '不明' }}</strong>さん
                                        
                                        {{-- 🌟 追加：履歴を見るボタン --}}
                                        <button onclick="document.getElementById('historyModal-{{ $spot->id }}').classList.add('is-show')" style="background: none; border: none; color: #4a82b3; text-decoration: underline; cursor: pointer; font-size: 11px; margin-left: 4px; padding: 0;">
                                            (履歴を見る)
                                        </button>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        <button onclick="alert('「いいね」を送信しました！更新ありがとうございます！')" style="background: none; border: 1px solid #cbd5e1; border-radius: 20px; padding: 4px 10px; font-size: 11px; cursor: pointer; color: #64748b; transition: 0.2s;">
                                            <i class="fa-regular fa-thumbs-up"></i> いいね
                                        </button>
                                        <button onclick="alert('運営に報告を送信しました。')" style="background: none; border: 1px solid #cbd5e1; border-radius: 20px; padding: 4px 10px; font-size: 11px; cursor: pointer; color: #e53e3e; transition: 0.2s;">
                                            <i class="fa-solid fa-triangle-exclamation"></i> 報告
                                        </button>
                                    </div>
                                </div>

                                <button onclick="document.getElementById('editSpotModal').classList.add('is-show')"
                                    style="background-color: white; color: #4a82b3; border: 1px solid #4a82b3; padding: 10px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 12px; transition: 0.2s; width: 100%; margin-bottom: 15px;">
                                    <i class="fa-solid fa-pen"></i> スポット情報を編集（Wiki）
                                </button>
                            @endif

                            <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.add('is-show')"
                                class="primary-btn">
                                レビューを書く
                            </button>

                        </div>
                    </div>
                </div>

                <div class="review-section">
                    <h3 style="font-size: 20px; color: #333; border-bottom: 2px solid #1e8b9b; padding-bottom: 10px; margin-bottom: 20px;">
                        みんなのリアルな感想（{{ $spot->reviews->count() }}件）
                    </h3>

                    @if($spot->reviews->isEmpty())
                        <p style="color: #999; text-align: center; padding: 20px 0; background: white; border-radius: 12px; border: 1px dashed #ccc;">
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
                                        <div style="color: #333; line-height: 1.6; font-size: 14px; white-space: pre-wrap; margin-bottom: 15px;">{{ $review->comment }}</div>
                                    @endif

                                    @if($review->good_point || $review->bad_point)
                                        <div style="display: flex; gap: 15px; font-size: 12px; background: #fafafa; padding: 10px; border-radius: 6px; border: 1px dashed #eee;">
                                            @if($review->good_point)
                                                <div style="flex: 1; color: #e53e3e; font-weight: bold;">👍 Good: <span
                                            style="font-weight: normal; color: #555;">{{ $review->good_point }}</span></div>@endif
                                            @if($review->bad_point)
                                                <div style="flex: 1; color: #3182ce; font-weight: bold;">気になる点: <span
                                            style="font-weight: normal; color: #555;">{{ $review->bad_point }}</span></div>@endif
                                        </div>
                                    @endif
                                </div>

                                @if(Auth::check() && Auth::id() === $review->user_id)
                                    <div class="custom-modal" id="editReviewModal-{{ $review->id }}">
                                        <div class="modal-content" style="padding: 0;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
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
                                                    <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸 写真を変更（そのままなら未選択でOK）</label>
                                                    <input type="file" name="photo" accept="image/*" style="width: 100%;">
                                                </div>

                                                <div style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
                                                    <p style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">🔍 ニッチな評価をシェア（1〜5で選択）</p>

                                                    <div style="margin-bottom: 20px;">
                                                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥 客層</label>
                                                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                            name="customer_vibe" id="vibe_{{ $review->id }}_{{ $i }}" value="{{ $i }}"
                                                            class="rating-radio" {{ $review->customer_vibe == $i ? 'checked' : '' }}><label for="vibe_{{ $review->id }}_{{ $i }}"
                                                        class="rating-label">{{ $i }}</label>@endfor</div>
                                                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← ワイワイ</span><span>もくもく作業 →</span></div>
                                                    </div>

                                                    <div style="margin-bottom: 20px;">
                                                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️ 照明</label>
                                                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                            name="eye_fatigue_level" id="eye_{{ $review->id }}_{{ $i }}"
                                                            value="{{ $i }}" class="rating-radio" {{ $review->eye_fatigue_level == $i ? 'checked' : '' }}><label for="eye_{{ $review->id }}_{{ $i }}"
                                                        class="rating-label">{{ $i }}</label>@endfor</div>
                                                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 暗め（雰囲気重視）</span><span>明るい（読書向き） →</span></div>
                                                    </div>

                                                    <div style="margin-bottom: 20px;">
                                                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑 イス</label>
                                                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                            name="chair_comfort" id="chair_{{ $review->id }}_{{ $i }}" value="{{ $i }}"
                                                            class="rating-radio" {{ $review->chair_comfort == $i ? 'checked' : '' }}><label for="chair_{{ $review->id }}_{{ $i }}"
                                                        class="rating-label">{{ $i }}</label>@endfor</div>
                                                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 硬い（長居キツイ）</span><span>ふかふか（快適） →</span></div>
                                                    </div>

                                                    <div style="margin-bottom: 0;">
                                                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢 机</label>
                                                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                            name="desk_stability" id="desk_{{ $review->id }}_{{ $i }}" value="{{ $i }}"
                                                            class="rating-radio" {{ $review->desk_stability == $i ? 'checked' : '' }}><label for="desk_{{ $review->id }}_{{ $i }}"
                                                        class="rating-label">{{ $i }}</label>@endfor</div>
                                                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 狭い・ガタつく</span><span>広い・安定感バツグン →</span></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="good-bad-responsive" style="display: flex; gap: 10px; margin-bottom: 15px;">
                                                    <div style="flex: 1;"><label style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍 Good</label>
                                                        <input type="text" name="good_point" value="{{ $review->good_point }}" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                                    </div>
                                                    <div style="flex: 1;"><label style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">気になる点</label>
                                                        <input type="text" name="bad_point" value="{{ $review->bad_point }}" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                                    </div>
                                                </div>
                                                <div style="margin-bottom: 25px;"><label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝 感想</label>
                                                    <textarea name="comment" rows="3" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none;">{{ $review->comment }}</textarea>
                                                </div>
                                                <div style="text-align: center;"><button type="submit" style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; cursor: pointer; width: 100%;">更新する</button></div>
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

    <div class="custom-modal" id="reviewModal-{{ $spot->id }}">
        <div class="modal-content" style="padding: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">レビュー・最新情報を投稿</h2>
                <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.remove('is-show')"
                    class="close-btn" style="position: static;">×</button>
            </div>

            <form action="{{ route('reviews.store', $spot->id) }}" method="POST" enctype="multipart/form-data"
                style="padding: 20px;">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸 席の様子やメニューの写真（任意）</label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-btn">
                            <i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>
                            写真を選択（またはドラッグ＆ドロップ）
                        </div>
                        <input type="file" name="photo" class="file-upload-input" accept="image/*">
                    </div>
                </div>

                <div style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
                    <p style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">🔍 ニッチな評価をシェア（1〜5で選択）</p>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥 客層</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="customer_vibe"
                            id="new_vibe_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_vibe_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← ワイワイ</span><span>もくもく作業 →</span></div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️ 照明</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="eye_fatigue_level"
                            id="new_eye_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_eye_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 暗め（雰囲気重視）</span><span>明るい（読書向き） →</span></div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑 イス</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="chair_comfort"
                            id="new_chair_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_chair_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 硬い（長居キツイ）</span><span>ふかふか（快適） →</span></div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢 机</label>
                        <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="desk_stability"
                            id="new_desk_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label
                        for="new_desk_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 狭い・ガタつく</span><span>広い・安定感バツグン →</span></div>
                    </div>
                </div>
                
                <div class="good-bad-responsive" style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;"><label style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍 Goodポイント</label>
                        <input type="text" name="good_point" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <div style="flex: 1;"><label style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;"> 気になるポイント</label>
                        <input type="text" name="bad_point" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                </div>
                <div style="margin-bottom: 25px;"><label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝 リアルな感想・最新状況</label>
                    <textarea name="comment" rows="3" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; resize: none;"></textarea>
                </div>
                <div style="text-align: center;"><button type="submit" style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">シェアする</button></div>
            </form>
        </div>
    </div>

    @if(Auth::check() && Auth::id() === $spot->user_id)
        <div class="custom-modal" id="editSpotModal">
            <div class="modal-content" style="padding: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                    <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">スポット情報を更新</h2>
                    <button type="button" onclick="document.getElementById('editSpotModal').classList.remove('is-show')"
                        class="close-btn" style="position: static;">×</button>
                </div>

                <form action="{{ route('spots.update', $spot->id) }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
                    @csrf
                    @version_helper
                    @method('PUT')

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🏢 スポット名</label>
                        <input type="text" name="name" value="{{ $spot->name }}" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
                    </div>

                    <div style="margin-bottom: 15px; display: flex; gap: 20px; background-color: #f4f8fb; padding: 15px; border-radius: 8px; border: 1px solid #c9d8e4; justify-content: center;">
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 15px;">
                            <input type="checkbox" name="has_power" value="1" {{ $spot->has_power ? 'checked' : '' }} style="transform: scale(1.3);"> 🔌 コンセントあり
                        </label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 15px;">
                            <input type="checkbox" name="has_wifi" value="1" {{ $spot->has_wifi ? 'checked' : '' }} style="transform: scale(1.3);"> 📶 Wi-Fiあり
                        </label>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">📍 エリア</label>
                        <select name="area" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; background-color: white;">
                            <option value="ITパーク" {{ $spot->area == 'ITパーク' ? 'selected' : '' }}>ITパーク</option>
                            <option value="アヤラ" {{ $spot->area == 'アヤラ' ? 'selected' : '' }}>アヤラ</option>
                            <option value="その他（タクシー圏内）" {{ $spot->area == 'その他（タクシー圏内）' ? 'selected' : '' }}>その他（タクシー圏内）</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 15px; background-color: #fafafa; padding: 10px; border-radius: 6px; border: 1px solid #eee;">
                        <span style="color: #666; font-size: 13px; font-weight: bold; display: block; margin-bottom: 8px;">🕒 営業時間 (現在: {{ $spot->hours ?: '未設定' }})</span>
                        <div class="time-row-responsive" style="display: flex; align-items: center; gap: 10px;">
                            <input type="time" name="open_time" step="1800" style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <span style="color: #999;">〜</span>
                            <input type="time" name="close_time" step="1800" style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸 写真を追加・変更する（複数選択可）</label>
                        <input type="file" name="photos[]" multiple accept="image/*" style="width: 100%; font-size: 14px;">
                        <div style="font-size: 11px; color: #888; margin-top: 5px;">※Ctrlキー（MacはCommandキー）を押しながらで複数枚選択できます（最大5枚）</div>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit" style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">
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

        // 🌟 バックエンド連携：クーポンボタンのクリックイベント処理
        function handleCouponActivation() {
            const btn = document.getElementById('activeCouponBtn');
            const isConfirmed = confirm("【確認】\n必ず店員さんの目の前でボタンを押してください。\nこのクーポンを使用済みにしますか？");
            
            if (isConfirmed) {
                // Fetch APIでバックエンドに非同期でデータを送信
                fetch('{{ route('spots.coupon.use', ['spot' => $spot->id]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message + "\nお会計時に店員さんに見せてください。");
                        btn.innerHTML = "✅ 今月は使用済み";
                        btn.style.backgroundColor = "#e0e0e0";
                        btn.style.color = "#a0a0a0";
                        btn.style.boxShadow = "none";
                        btn.disabled = true;
                    } else {
                        // Laravelから送られてきたエラーメッセージ（今月は使用済み等）を表示
                        alert("エラー: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("通信エラーが発生しました。");
                });
            }
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
    {{-- 🌟 追加：編集履歴一覧モーダル --}}
    <div class="custom-modal" id="historyModal-{{ $spot->id }}">
        <div class="modal-content" style="padding: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">📝 編集・更新履歴</h2>
                <button type="button" onclick="document.getElementById('historyModal-{{ $spot->id }}').classList.remove('is-show')" class="close-btn" style="position: static;">×</button>
            </div>
            <div style="padding: 20px; max-height: 350px; overflow-y: auto;">
                
                @if($spot->editHistories && $spot->editHistories->count() > 0)
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($spot->editHistories as $history)
                            <li style="border-bottom: 1px dashed #eee; padding: 12px 0; font-size: 13px; color: #333;">
                                <div style="color: #888; font-size: 11px; margin-bottom: 4px;">
                                    {{ $history->created_at->format('Y年m月d日 H:i') }}
                                </div>
                                <strong>{{ $history->user->name ?? '退会したユーザー' }}</strong> さんが情報を更新しました
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="text-align: center; color: #999; font-size: 13px; margin-bottom: 0;">まだ情報の更新履歴はありません。</p>
                @endif
                
                {{-- 一番最初の「新規登録」の記録も一番下に表示する粋な演出 --}}
                <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #f4f8fb; font-size: 13px; color: #333;">
                    <div style="color: #888; font-size: 11px; margin-bottom: 4px;">
                        {{ $spot->created_at->format('Y年m月d日 H:i') }}
                    </div>
                    <strong>{{ $spot->user->name ?? '不明' }}</strong> さんがスポットを新規登録しました
                </div>
                
            </div>
        </div>
    </div>{{-- 🌟 自分の画面専用！Enterキーで次の入力項目へ移動する魔法 --}}
    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;

                // テキストエリア（感想）やボタンは本来のEnterの動きを優先
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