@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* --- 基本レイアウト --- */
        .spot-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .spot-card {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        .spot-card-header {
            margin-bottom: 10px;
        }

        .spot-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        .spot-hours {
            font-size: 12px;
            color: #666;
        }

        .spot-photo-section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .spot-photos-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 15px;
        }

        .photo-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-dummy {
            width: 100%;
            height: 70px;
            background-color: #d8c3b4;
            border-radius: 6px;
            margin-bottom: 4px;
            object-fit: cover;
        }

        .photo-label {
            font-size: 11px;
            color: #555;
            font-weight: bold;
        }

        .spot-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
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
            color: #555;
            font-size: 14px;
        }

        .spot-map-link {
            font-size: 12px;
            color: #297a6a;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .spot-map-link:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .content-section {
            width: 100%;
            padding: 20px;
            overflow-y: scroll;
        }

        .app-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .filter-options {
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        /* --- 設備絞り込みのトグルスイッチ --- */
        .switch-container {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .toggle-label {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            background-color: #e8e8e8;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .toggle-input {
            display: none;
        }

        .toggle-input:checked+.toggle-label {
            background-color: #297a6a;
            color: white;
        }

        /* --- エリア検索行 --- */
        .search-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .area-select {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .search-btn {
            padding: 6px 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #f8f8f8;
        }

        .search-btn:hover {
            background-color: #eee;
        }

        /* --- ポップアップ（モーダル）共通の見た目 --- */
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

        .close-btn:hover {
            color: #333;
        }

        /* 🌟 今回追加：タップしやすい評価ボタンのスタイル */
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
            box-shadow: 0 2px 6px rgba(30, 139, 155, 0.3);
        }

        .rating-caption {
            font-size: 9px;
            display: block;
            margin-top: 2px;
            font-weight: normal;
            color: inherit;
        }
    </style>

    <!-- ✨ 成功メッセージ表示エリア -->
    @if (session('success'))
        <div id="flash-message"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #1e8b9b; color: white; padding: 12px 24px; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 10000; transition: opacity 0.5s ease;">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <div class="container">
        <div class="content-section">

            <div class="title-area"
                style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
                <h2 class="app-title">セブ島の学習スポットを探す</h2>
                <button onclick="document.getElementById('newSpotModal').classList.add('is-show')"
                    style="background-color: #1e8b9b; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    ＋ 新規スポットを登録
                </button>
            </div>

            <form action="{{ url('/') }}" method="GET">
                <div class="filter-options">
                    <div class="filter-title">設備で絞り込む（最優先）</div>
                    <div class="switch-container">
                        <input type="checkbox" id="wifiToggle" class="toggle-input" name="wifi" value="1" {{ request('wifi') == '1' ? 'checked' : '' }}>
                        <label for="wifiToggle" class="toggle-label">
                            <i class="fa-solid fa-wifi" style="margin-right: 6px;"></i>WIFI
                        </label>
                        <input type="checkbox" id="powerToggle" class="toggle-input" name="power" value="1" {{ request('power') == '1' ? 'checked' : '' }}>
                        <label for="powerToggle" class="toggle-label">
                            <i class="fa-solid fa-plug-circle-bolt" style="margin-right: 6px;"></i>コンセント
                        </label>
                    </div>
                </div>
                <div class="filter-options">
                    <div class="filter-title">エリアで絞り込む</div>
                    <div class="search-row">
                        <select name="area" class="area-select">
                            <option value="">-- エリアを選択 --</option>
                            <option value="it-park" {{ request('area') == 'it-park' ? 'selected' : '' }}>ITパーク周辺</option>
                            <option value="ayala" {{ request('area') == 'ayala' ? 'selected' : '' }}>アヤラ周辺</option>
                            <option value="lahug" {{ request('area') == 'lahug' ? 'selected' : '' }}>ラホグ</option>
                            <option value="mabolo" {{ request('area') == 'mabolo' ? 'selected' : '' }}>マボロ</option>
                            <option value="others" {{ request('area') == 'others' ? 'selected' : '' }}>その他</option>
                        </select>
                        <button type="submit" class="search-btn">
                            <i class="fa-solid fa-magnifying-glass"></i> 検索する
                        </button>
                    </div>
                </div>
            </form>

            <div class="spot-list">
                @foreach($spots as $spot)
                    <div class="spot-card">
                        <div class="spot-card-header">
                            <span class="spot-name">{{ $spot->name }}</span>
                            <div class="spot-hours">営業時間：{{ $spot->hours }}</div>
                        </div>

                        <div class="spot-photo-section-title">写真</div>
                        <div class="spot-photos-grid">
                            <div class="photo-item">
                                <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="外観">
                                <span class="photo-label">外観</span>
                            </div>
                            <div class="photo-item">
                                <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="内観">
                                <span class="photo-label">内観</span>
                            </div>
                            <div class="photo-item">
                                <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="メニュー表">
                                <span class="photo-label">メニュー表</span>
                            </div>
                            <div class="photo-item">
                                <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="食べたもの">
                                <span class="photo-label">食べたもの</span>
                            </div>
                        </div>

                        <div class="spot-area" style="padding: 10px 0; color: #666; font-size: 13px;">
                            📍 エリア：{{ $spot->area }}
                        </div>

                        <div class="spot-card-footer">
                            <div class="spot-facilities">
                                @if($spot->has_wifi)
                                    <span class="amenity-item" style="margin-right: 10px;">
                                        <i class="fa-solid fa-wifi"></i> WiFi
                                    </span>
                                @endif
                                @if($spot->has_power)
                                    <span class="amenity-item">
                                        <i class="fa-solid fa-plug-circle-bolt"></i> 電源
                                    </span>
                                @endif
                            </div>
                            <a href="#" class="spot-map-link open-map-btn" data-url="{{ $spot->map_url }}">地図で見る</a>
                        </div>

                        <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px; text-align: right;">
                            <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.add('is-show')"
                                style="background-color: #1e8b9b; color: white; border: none; padding: 8px 20px; border-radius: 20px; font-weight: bold; font-size: 13px; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                ✍️ レビューを書く
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="custom-modal" id="mapModal">
        <div class="modal-content" style="text-align: center;">
            <button class="close-btn" id="closeMapBtn">×</button>
            <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 18px; color: #333;">店舗の位置マップ</h3>
            <div style="width: 100%; height: 350px; background: #eee; border-radius: 8px; overflow: hidden;">
                <iframe id="modalMapIframe" src="" width="100%" height="100%" style="border:0;" allowfullscreen=""
                    loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <div class="custom-modal" id="newSpotModal">
        <div class="modal-content" style="padding: 0;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">新規スポットを登録する</h2>
                <button onclick="document.getElementById('newSpotModal').classList.remove('is-show')" class="close-btn"
                    style="position: static;">×</button>
            </div>

            <form action="{{ route('spots.store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
                @csrf

                <div style="border: 1px solid #c9d8e4; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                    <div
                        style="background-color: #4a82b3; color: white; font-size: 12px; font-weight: bold; padding: 6px 12px;">
                        Spot Information (基本情報)
                    </div>
                    <div
                        style="background-color: #f4f8fb; padding: 12px; display: flex; flex-direction: column; gap: 10px;">
                        <input type="text" name="name" placeholder="スポット名（例：Cebu CoWork Hub）"
                            style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; outline: none;">

                        <div style="display: flex; align-items: center; gap: 8px; color: #666;">
                            📍
                            <select name="area"
                                style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; color: #555; outline: none;">
                                <option value="">-- エリアを選択 --</option>
                                <option value="it-park">ITパーク周辺</option>
                                <option value="ayala">アヤラ周辺</option>
                                <option value="lahug">ラホグ</option>
                                <option value="mabolo">マボロ</option>
                                <option value="others">その他</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 13px; font-weight: bold; color: #333; margin-bottom: 8px;">Photo
                        (外観や内観)</label>
                    <label
                        style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100px; height: 70px; background-color: #f4f8fb; border: 1px dashed #4a82b3; border-radius: 6px; cursor: pointer; font-size: 11px; color: #4a82b3; font-weight: bold;">
                        <i class="fa-solid fa-camera" style="font-size: 20px; margin-bottom: 4px;"></i>
                        add photo
                        <input type="file" name="photo" style="display: none;" accept="image/*">
                    </label>
                </div>

                <div style="margin-bottom: 25px;">
                    <label
                        style="display: block; font-size: 13px; font-weight: bold; color: #333; margin-bottom: 8px;">Amenities
                        & Services (設備)</label>
                    <div style="display: flex; gap: 10px;">
                        <label style="cursor: pointer;">
                            <input type="checkbox" name="has_wifi" value="1" style="display: none;"
                                onchange="this.nextElementSibling.style.backgroundColor = this.checked ? '#e6f0f9' : 'white'; this.nextElementSibling.style.borderColor = this.checked ? '#1e8b9b' : '#c9d8e4'; this.nextElementSibling.style.color = this.checked ? '#1e8b9b' : '#4a82b3';">
                            <div
                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #c9d8e4; border-radius: 8px; width: 75px; height: 60px; color: #4a82b3; font-size: 11px; font-weight: bold; background-color: white; transition: all 0.2s;">
                                <i class="fa-solid fa-wifi" style="font-size: 18px; margin-bottom: 4px;"></i> Wi-Fi
                            </div>
                        </label>

                        <label style="cursor: pointer;">
                            <input type="checkbox" name="has_power" value="1" style="display: none;"
                                onchange="this.nextElementSibling.style.backgroundColor = this.checked ? '#e6f0f9' : 'white'; this.nextElementSibling.style.borderColor = this.checked ? '#1e8b9b' : '#c9d8e4'; this.nextElementSibling.style.color = this.checked ? '#1e8b9b' : '#4a82b3';">
                            <div
                                style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #c9d8e4; border-radius: 8px; width: 75px; height: 60px; color: #4a82b3; font-size: 11px; font-weight: bold; background-color: white; transition: all 0.2s;">
                                <i class="fa-solid fa-plug-circle-bolt" style="font-size: 18px; margin-bottom: 4px;"></i>
                                Power
                            </div>
                        </label>
                    </div>
                </div>

                <div
                    style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #eee;">
                    <p style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">🔍
                        集中環境の初期データをセット</p>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🥷 空間快適度
                            (視線の気にならなさ)</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="dead_spot_rating" id="new_ds_{{ $i }}" value="{{ $i }}"
                                    class="rating-radio" {{ $i == 3 ? 'checked' : '' }}>
                                <label for="new_ds_{{ $i }}" class="rating-label"
                                    style="padding: 6px 0; font-size: 14px;">{{ $i }}</label>
                            @endfor
                        </div>
                        <div style="text-align: center; font-size: 10px; color: #777; margin-top: 4px;">1:丸見え 〜 5:完全に自分の世界
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">❄️ 冷房の強さ</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="aircon_level" id="new_ac_{{ $i }}" value="{{ $i }}"
                                    class="rating-radio" {{ $i == 3 ? 'checked' : '' }}>
                                <label for="new_ac_{{ $i }}" class="rating-label"
                                    style="padding: 6px 0; font-size: 14px;">{{ $i }}</label>
                            @endfor
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🧱
                            壁際・角席の確保しやすさ</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="wall_seat_rating" id="new_wall_{{ $i }}" value="{{ $i }}"
                                    class="rating-radio" {{ $i == 3 ? 'checked' : '' }}>
                                <label for="new_wall_{{ $i }}" class="rating-label"
                                    style="padding: 6px 0; font-size: 14px;">{{ $i }}</label>
                            @endfor
                        </div>
                    </div>

                    <div style="margin-bottom: 0;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🎵 BGMのボリューム</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="bgm_volume_level" id="new_bgm_{{ $i }}" value="{{ $i }}"
                                    class="rating-radio" {{ $i == 3 ? 'checked' : '' }}>
                                <label for="new_bgm_{{ $i }}" class="rating-label"
                                    style="padding: 6px 0; font-size: 14px;">{{ $i }}</label>
                            @endfor
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="document.getElementById('newSpotModal').classList.remove('is-show')"
                        style="flex: 1; background-color: white; color: #1e8b9b; border: 1px solid #1e8b9b; padding: 14px; border-radius: 25px; font-weight: bold; font-size: 14px; cursor: pointer;">
                        キャンセル
                    </button>
                    <button type="submit"
                        style="flex: 1; background-color: #1e8b9b; color: white; border: none; padding: 14px; border-radius: 25px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        スポットを登録する
                    </button>
                </div>
            </form>
        </div>
    </div>

    @foreach($spots as $spot)
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

                    <div style="border: 1px solid #c9d8e4; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <div
                            style="background-color: #4a82b3; color: white; font-size: 12px; font-weight: bold; padding: 6px 12px;">
                            Review Target
                        </div>
                        <div style="background-color: #f4f8fb; padding: 12px; display: flex; align-items: center;">
                            <div style="width: 40px; height: 40px; background-color: #ccc; border-radius: 4px; flex-shrink: 0;">
                            </div>
                            <div style="margin-left: 15px;">
                                <div style="font-weight: bold; font-size: 14px; color: #333;">{{ $spot->name }}</div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 5px;">📸
                            最新の写真（メニューや席の様子）</label>
                        <label
                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100px; height: 70px; background-color: #f4f8fb; border: 1px dashed #4a82b3; border-radius: 6px; cursor: pointer; font-size: 11px; color: #4a82b3; font-weight: bold;">
                            <i class="fa-solid fa-camera" style="font-size: 20px; margin-bottom: 4px;"></i>
                            add photo
                            <input type="file" name="photo" style="display: none;" accept="image/*">
                        </label>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label
                                style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍
                                Goodポイント</label>
                            <input type="text" name="good_point" placeholder="例: ケーキが美味しい"
                                style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;">
                        </div>
                        <div style="flex: 1;">
                            <label
                                style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">👎
                                Badポイント</label>
                            <input type="text" name="bad_point" placeholder="例: Wi-Fiがたまに切れる"
                                style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝
                            リアルな感想・最新状況</label>
                        <textarea name="comment" rows="3" placeholder="今日の混み具合や、新メニューの感想など..."
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; background-color: #f9f9f9; resize: none; outline: none;"></textarea>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit"
                            style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; transition: background-color 0.2s;">
                            最新情報をシェアする
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mapModal = document.getElementById('mapModal');
            const newSpotModal = document.getElementById('newSpotModal');
            const closeMapBtn = document.getElementById('closeMapBtn');
            const modalMapIframe = document.getElementById('modalMapIframe');
            const openMapBtns = document.querySelectorAll('.open-map-btn');

            if (mapModal && modalMapIframe) {
                openMapBtns.forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        const mapUrl = this.getAttribute('data-url');
                        if (mapUrl) {
                            modalMapIframe.src = mapUrl;
                            mapModal.classList.add('is-show');
                        }
                    });
                });

                if (closeMapBtn) {
                    closeMapBtn.addEventListener('click', function () {
                        mapModal.classList.remove('is-show');
                        modalMapIframe.src = '';
                    });
                }
            }

            window.addEventListener('click', function (e) {
                if (e.target === mapModal) {
                    mapModal.classList.remove('is-show');
                    if (modalMapIframe) modalMapIframe.src = '';
                }
                if (e.target === newSpotModal) {
                    newSpotModal.classList.remove('is-show');
                }
                if (e.target.classList.contains('custom-modal')) {
                    e.target.classList.remove('is-show');
                }
            });
        });
    </script>
@endsection