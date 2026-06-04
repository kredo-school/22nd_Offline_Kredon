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

        /* 一覧用のすっきりメイン写真エリア */
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
            padding: 20px 20px 80px 20px;
            overflow-y: auto;
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
    </style>

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
                        <select name="area" class="area-select" required>
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
                            <div class="spot-hours">🕒 営業時間：{{ $spot->hours ?? '情報なし' }}</div>
                        </div>

                        @if($spot->photo_path)
                            <img src="{{ asset('storage/' . $spot->photo_path) }}" class="spot-main-photo" alt="外観">
                        @else
                            <img src="https://placehold.co/600x200/e6f0f9/4a82b3?text=No+Image" class="spot-main-photo" alt="写真なし">
                        @endif

                        <div style="background-color: #f4f8fb; padding: 8px 12px; border-radius: 6px; margin-bottom: 12px; border: 1px solid #e6f0f9; display: flex; justify-content: space-between; font-size: 12px; font-weight: bold; color: #555;">
                            <span>👥 客層: <span style="color: #1e8b9b;">{{ $spot->reviews->avg('customer_vibe') ? number_format($spot->reviews->avg('customer_vibe'), 1) : '-' }}</span></span>
                            <span>👁️ 照明: <span style="color: #1e8b9b;">{{ $spot->reviews->avg('eye_fatigue_level') ? number_format($spot->reviews->avg('eye_fatigue_level'), 1) : '-' }}</span></span>
                            <span>🪑 イス: <span style="color: #1e8b9b;">{{ $spot->reviews->avg('chair_comfort') ? number_format($spot->reviews->avg('chair_comfort'), 1) : '-' }}</span></span>
                            <span>🏢 机: <span style="color: #1e8b9b;">{{ $spot->reviews->avg('desk_stability') ? number_format($spot->reviews->avg('desk_stability'), 1) : '-' }}</span></span>
                        </div>

                        <div style="color: #666; font-size: 13px; margin-bottom: 12px;">
                            📍 エリア：{{ $spot->area }}
                        </div>

                        <div class="spot-card-footer">
                            <div class="spot-facilities">
                                @if($spot->has_wifi)
                                    <span class="amenity-item"><i class="fa-solid fa-wifi"></i> WiFi</span>
                                @endif
                                @if($spot->has_power)
                                    <span class="amenity-item" style="margin-left: 8px;"><i class="fa-solid fa-plug-circle-bolt"></i> 電源</span>
                                @endif
                            </div>
                            
                            <a href="{{ route('spots.show', $spot->id) }}"
                                style="background-color: #1e8b9b; color: white; border: none; padding: 8px 16px; border-radius: 20px; font-weight: bold; font-size: 13px; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-decoration: none;">
                                詳細・クチコミを見る <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-left: 4px;"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('new_spot_modal')

@endsection