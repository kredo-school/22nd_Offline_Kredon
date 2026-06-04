@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* --- 全体の枠組み（大元のレイアウトに素直に従う） --- */
        .container {
            display: flex;
            width: 100%;
            height: calc(100vh - 70px);
            margin-top: 70px;
        }

        .content-section {
            width: 100%;
            padding: 20px 20px 80px 20px;
            overflow-y: auto;
        }

        /* --- ページ内部の2カラムレイアウト --- */
        .top-page-wrapper {
            display: flex;
            gap: 30px;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            align-items: flex-start;
        }

        .main-column {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 25px;
            min-width: 0;
        }

        .side-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: sticky;
            top: 0;
            min-width: 280px;
        }

        /* --- ヒーローバナー --- */
        .hero-banner {
            background: linear-gradient(135deg, #1e8b9b, #4a82b3);
            border-radius: 16px;
            padding: 40px 30px;
            color: white;
            box-shadow: 0 4px 15px rgba(30, 139, 155, 0.2);
            position: relative;
            overflow: hidden;
        }

        .hero-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .hero-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        /* --- 横型スポットカード --- */
        .spot-card-horizontal {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            border: 1px solid #eee;
            overflow: hidden;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .spot-card-horizontal:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(30, 139, 155, 0.15);
            border-color: #c9d8e4;
        }

        .spot-card-img-area {
            width: 200px;
            min-height: 150px;
            background-color: #f4f8fb;
            flex-shrink: 0;
            border-right: 1px solid #eee;
        }

        .spot-card-img-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .spot-card-info {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
        }

        .spot-card-horizontal:hover .spot-title {
            color: #1e8b9b;
        }

        .spot-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            transition: color 0.2s;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .spot-desc {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .spot-tags {
            display: flex;
            gap: 10px;
            font-size: 12px;
            color: #555;
            font-weight: bold;
            flex-wrap: wrap;
        }

        .tag-item i {
            color: #1e8b9b;
            margin-right: 4px;
        }

        /* --- 右側のボックス --- */
        .side-box {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .side-box-title {
            font-size: 15px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #f4f8fb;
            padding-bottom: 10px;
        }

        .search-input,
        .area-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 10px;
            box-sizing: border-box;
            outline: none;
        }

        .search-btn {
            width: 100%;
            background-color: #1e8b9b;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-btn:hover {
            background-color: #166b78;
        }

        @media (max-width: 768px) {
            .top-page-wrapper {
                flex-direction: column;
            }

            .spot-card-horizontal {
                flex-direction: column;
            }

            .spot-card-img-area {
                width: 100%;
                height: 200px;
                border-right: none;
                border-bottom: 1px solid #eee;
            }

            .side-column {
                min-width: 100%;
            }
        }
    </style>

    <div class="container">
        <div class="content-section">
            <div class="top-page-wrapper">

                <div class="main-column">
                    <div class="hero-banner">
                        <div class="hero-title">セブ島が繋ぐ、思いとご縁 🌴</div>
                        <div class="hero-subtitle">あなただけの最高の集中スポット・学習環境を見つけよう！</div>
                        <button onclick="document.getElementById('newSpotModal').classList.add('is-show')"
                            style="background-color: white; color: #1e8b9b; border: none; padding: 10px 24px; border-radius: 20px; font-weight: bold; font-size: 14px; cursor: pointer;">
                            ＋ 新規スポットを登録
                        </button>
                    </div>

                    <h3
                        style="font-size: 18px; color: #333; border-left: 4px solid #1e8b9b; padding-left: 10px; margin: 10px 0 0 0;">
                        @if(request()->has('keyword') || request()->has('area') || request()->has('wifi') || request()->has('power'))
                            🔍 検索結果：{{ $spots->count() }}件
                        @else
                            ✨ 最近登録されたスポット
                        @endif
                    </h3>

                    @if($spots->isEmpty())
                        <div
                            style="text-align: center; padding: 40px 20px; background: white; border-radius: 12px; border: 1px dashed #ccc; color: #666;">
                            条件に一致するスポットが見つかりませんでした。<br>条件を変えて再度検索してみてください。
                        </div>
                    @else
                        @foreach($spots as $spot)
                            <a href="{{ route('spots.show', $spot->id) }}" class="spot-card-horizontal">
                                <div class="spot-card-img-area">
                                    @if($spot->photo_path)
                                        <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="スポット写真">
                                    @else
                                        <img src="https://placehold.co/400x300/e6f0f9/4a82b3?text=No+Photo" alt="写真なし">
                                    @endif
                                </div>
                                <div class="spot-card-info">
                                    <div>
                                        <div class="spot-title">{{ $spot->name }}</div>
                                        <div class="spot-desc">
                                            📍 エリア：{{ $spot->area }}<br>
                                            営業時間：{{ $spot->hours ?? '情報なし' }}
                                        </div>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div class="spot-tags">
                                            @if($spot->has_wifi)
                                                <span class="tag-item"><i class="fa-solid fa-wifi"></i> WiFi完備</span>
                                            @endif
                                            @if($spot->has_power)
                                                <span class="tag-item"><i class="fa-solid fa-plug-circle-bolt"></i> 電源あり</span>
                                            @endif
                                        </div>
                                        <div style="color: #ccc; font-size: 14px;">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    <div style="margin-top: 30px; margin-bottom: 20px;">
                        {{ $spots->withQueryString()->links() }}
                    </div>
                </div>
                <div class="side-column">
                    <div class="side-box">
                        <div class="side-box-title">🔍 スポットを検索</div>
                        <form action="{{ route('search') }}" method="GET">
                            <input type="text" name="keyword" class="search-input" placeholder="キーワード（例：カフェ、静か）"
                                value="{{ request('keyword') }}">

                            <select name="area" class="area-select">
                                <option value="">-- エリアで絞り込む --</option>
                                <option value="it-park" {{ request('area') == 'it-park' ? 'selected' : '' }}>ITパーク内</option>
                                <option value="ayala" {{ request('area') == 'ayala' ? 'selected' : '' }}>アヤラモール内</option>
                                <option value="lahug" {{ request('area') == 'lahug' ? 'selected' : '' }}>ラホグ</option>
                                <option value="mabolo" {{ request('area') == 'mabolo' ? 'selected' : '' }}>マボロ</option>
                            </select>

                            <div style="margin-bottom: 15px; font-size: 13px; color: #555;">
                                <label style="margin-right: 10px;"><input type="checkbox" name="wifi" value="1" {{ request('wifi') == '1' ? 'checked' : '' }}> WiFiあり</label>
                                <label><input type="checkbox" name="power" value="1" {{ request('power') == '1' ? 'checked' : '' }}> 電源あり</label>
                            </div>

                            <button type="submit" class="search-btn">検索する</button>
                        </form>
                    </div>

                    <div class="side-box">
                        <div class="side-box-title">🔥 注目のスポット</div>
                        <div style="text-align: center; color: #666; font-size: 13px; padding: 20px 0;">
                            <img src="https://placehold.co/300x150/d8c3b4/white?text=Featured+Spot"
                                style="width: 100%; border-radius: 8px; margin-bottom: 10px;">
                            <div style="font-weight: bold; color: #333;">Cebu CoWork Hub</div>
                            <div>⭐ 4.8 (ITパーク)</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('new_spot_modal')
@endsection