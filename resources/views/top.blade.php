@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* --- ページ全体の2カラムレイアウト --- */
        .top-page-container {
            display: flex;
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 20px 80px 20px;
            align-items: flex-start; /* 上揃え */
            margin-top: 70px; /* ヘッダーの高さ分だけ下にズラす */
            height: calc(100vh - 70px); /* 画面の高さからヘッダー分を引く */
            overflow-y: auto; /* はみ出た分はスクロールできるようにする */
        }

        /* 左側（メイン：全体の約65%） */
        .main-column {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        /* 右側（サイドバー：全体の約35%） */
        .side-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: sticky;
            top: 20px; /* スクロールしても右側だけ追従させる魔法 */
        }

        /* --- ヒーローバナー（左側トップ） --- */
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

        /* --- 横型スポットカード（画像左・テキスト右） --- */
        .spot-card-horizontal {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            border: 1px solid #eee;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .spot-card-horizontal:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        .spot-card-img-area {
            width: 200px;
            min-height: 150px;
            background-color: #f4f8fb;
            flex-shrink: 0;
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
        }

        .spot-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
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
        }

        .tag-item i {
            color: #1e8b9b;
            margin-right: 4px;
        }

        /* --- 右側のボックス（検索・ピックアップなど） --- */
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

        /* 検索フォーム用 */
        .search-input, .area-select {
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

        /* レスポンシブ（スマホの時は縦1列にする魔法） */
        @media (max-width: 768px) {
            .top-page-container {
                flex-direction: column;
            }
            .spot-card-horizontal {
                flex-direction: column;
            }
            .spot-card-img-area {
                width: 100%;
                height: 200px;
            }
        }
    </style>

    <div class="top-page-container">
        
        <div class="main-column">
            
            <div class="hero-banner">
                <div class="hero-title">セブ島が繋ぐ、思いとご縁 🌴</div>
                <div class="hero-subtitle">あなただけの最高の集中スポット・学習環境を見つけよう！</div>
                <button onclick="document.getElementById('newSpotModal').classList.add('is-show')"
                    style="background-color: white; color: #1e8b9b; border: none; padding: 10px 24px; border-radius: 20px; font-weight: bold; font-size: 14px; cursor: pointer;">
                    ＋ 新規スポットを登録
                </button>
            </div>

            <h3 style="font-size: 18px; color: #333; border-left: 4px solid #1e8b9b; padding-left: 10px; margin: 10px 0 0 0;">
                ✨ 最近登録されたスポット
            </h3>

            @foreach($spots as $spot)
                <div class="spot-card-horizontal">
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
                        <div class="spot-tags">
                            @if($spot->has_wifi)
                                <span class="tag-item"><i class="fa-solid fa-wifi"></i> WiFi完備</span>
                            @endif
                            @if($spot->has_power)
                                <span class="tag-item"><i class="fa-solid fa-plug-circle-bolt"></i> 電源あり</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="side-column">
            
            <div class="side-box">
                <div class="side-box-title">🔍 スポットを検索</div>
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="keyword" class="search-input" placeholder="キーワード（例：カフェ、静か）">
                    <select name="area" class="area-select">
                        <option value="">-- エリアで絞り込む --</option>
                        <option value="it-park">ITパーク周辺</option>
                        <option value="ayala">アヤラ周辺</option>
                        <option value="lahug">ラホグ</option>
                        <option value="mabolo">マボロ</option>
                    </select>
                    
                    <div style="margin-bottom: 15px; font-size: 13px; color: #555;">
                        <label style="margin-right: 10px;"><input type="checkbox" name="wifi" value="1"> WiFiあり</label>
                        <label><input type="checkbox" name="power" value="1"> 電源あり</label>
                    </div>

                    <button type="submit" class="search-btn">検索する</button>
                </form>
            </div>

            <div class="side-box">
                <div class="side-box-title">🔥 注目のスポット</div>
                <div style="text-align: center; color: #666; font-size: 13px; padding: 20px 0;">
                    <img src="https://placehold.co/300x150/d8c3b4/white?text=Featured+Spot" style="width: 100%; border-radius: 8px; margin-bottom: 10px;">
                    <div style="font-weight: bold; color: #333;">Cebu CoWork Hub</div>
                    <div>⭐ 4.8 (ITパーク)</div>
                </div>
            </div>

        </div>

    </div>

    @include('new_spot_modal')

@endsection