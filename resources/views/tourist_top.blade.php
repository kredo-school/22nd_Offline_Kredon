@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@section('content')
    <style>
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
            max-width: 320px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 110px);
            overflow-y: auto;
        }

        .side-column::-webkit-scrollbar {
            display: none;
        }

        /* 🌟 観光スポットバナー */
        .hero-banner {
            background-color: #f0932b;
            color: white;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .hero-subtitle {
            font-size: 14px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .spot-card-horizontal {
            display: flex;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
            text-decoration: none;
            color: inherit;
            transition: 0.2s;
        }

        .spot-card-horizontal:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
        }

        .spot-card-img-area {
            width: 180px;
            flex-shrink: 0;
        }

        .spot-card-img-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .spot-card-info {
            padding: 15px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .spot-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .spot-desc {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .spot-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tag-item {
            font-size: 11px;
            font-weight: bold;
            color: #f0932b;
            background: #fff4e6;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .side-box {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 20px;
        }

        .side-box-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #f0932b;
            padding-bottom: 8px;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .search-btn {
            width: 100%;
            padding: 12px;
            background-color: #f0932b;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        /* 🌟 ポップアップ（モーダル）用の追加CSS */
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

        /* 📱 ここから追加：スマホ対応（レスポンシブ）マジック！ */
        @media (max-width: 768px) {
            .top-page-wrapper {
                flex-direction: column;
                gap: 20px;
            }
            .main-column {
                display: contents; /* main-column の枠を解除し、中身を並べ替え可能にする */
            }
            
            /* 1. エラーがあれば一番上 */
            .error-box { order: 1; width: 100%; }
            
            /* 2. オレンジのバナーを上に配置し、少し縦を縮める */
            .hero-banner {
                order: 2;
                margin-top: 0;
                padding: 25px 15px;
                width: 100%;
                box-sizing: border-box;
            }
            .hero-title { font-size: 22px; margin-bottom: 5px; }
            .hero-subtitle { font-size: 12px; margin-bottom: 15px; }

            /* 3. 検索ボックス（右カラムだったもの）をバナーの下に配置 */
            .side-column {
                order: 3;
                position: static;
                max-height: none;
                overflow-y: visible;
                width: 100%;
                max-width: 100%;
            }

            /* 4. スポット一覧エリアを一番下に配置 */
            .spot-list-container {
                order: 4;
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            /* カードを縦長に */
            .spot-card-horizontal {
                flex-direction: column;
            }
            .spot-card-img-area {
                width: 100%;
                height: 200px;
            }
        }
    </style>

    <div class="container" style="padding-top: 0; margin-top: 0;">
        <div class="content-section" style="padding-top: 0; margin-top: 0;">
            <div class="top-page-wrapper" style="padding-top: 0; margin-top: 0;">

                <div class="main-column" style="padding-top: 0; margin-top: 0;">
                    
                    {{-- エラー表示エリア --}}
                    @if ($errors->any())
                        <div class="error-box" style="background-color: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
                            ⚠️ 登録に失敗しました。以下の原因を確認してください：<br>
                            <ul style="margin-top: 10px; margin-bottom: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- ヒーローバナーエリア --}}
                    <div class="hero-banner">
                        <div class="hero-title">CEBU TOURIST 🏖️</div>
                        <div style="position: absolute; top: 15px; right: 25px; display: flex; align-items: center; user-select: none;">
                            <img src="https://flagcdn.com/w80/jp.png" alt="Japan" style="width: 34px; transform: rotate(-15deg); margin-right: -12px; z-index: 2; position: relative; top: 8px; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.4)); border-radius: 3px;">
                            <img src="https://flagcdn.com/w80/ph.png" alt="Philippines" style="width: 34px; transform: rotate(12deg); z-index: 1; position: relative; top: -6px; filter: drop-shadow(2px 2px 5px rgba(0,0,0,0.3)); border-radius: 3px;">
                        </div>
                        <div class="hero-subtitle">あなただけの最高の観光スポット・体験を見つけよう</div>
                        <button onclick="document.getElementById('newTouristSpotModal').classList.add('is-show')" style="background-color: white; color: #f0932b; border: none; padding: 10px 24px; border-radius: 20px; font-weight: bold; font-size: 14px; cursor: pointer;">
                            ＋ 新規観光スポットを登録
                        </button>
                    </div>

                    {{-- 🌟 魔法の箱：スポット一覧をスマホで丸ごと下に移動させるためのコンテナ --}}
                    <div class="spot-list-container">
                        <h3 style="font-size: 18px; color: #333; border-left: 4px solid #f0932b; padding-left: 10px; margin: 10px 0 0 0;">
                            @if(request()->has('keyword') || request()->has('area'))
                                🔍 検索結果：{{ $tourist_spots->count() }}件
                            @else
                                ✨ 最近登録された観光スポット
                            @endif
                        </h3>

                        @if($tourist_spots->isEmpty())
                            <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 12px; border: 1px dashed #ccc; color: #666;">
                                条件に一致するスポットが見つかりませんでした。<br>条件を変えて再度検索してみてください。
                            </div>
                        @else
                            @foreach($tourist_spots as $tourist_spot)
                                <a href="{{ route('tourist_spots.show', $tourist_spot->id) }}" class="spot-card-horizontal">
                                    <div class="spot-card-img-area">
                                        @if($tourist_spot->photo_path)
                                            <img src="{{ asset('storage/' . $tourist_spot->photo_path) }}" alt="スポット写真">
                                        @else
                                            <img src="https://placehold.co/400x300/fff4e6/f0932b?text=No+Photo" alt="写真なし">
                                        @endif
                                    </div>
                                    <div class="spot-card-info">
                                        <div>
                                            <div class="spot-title">{{ $tourist_spot->name }}</div>
                                            <div class="spot-desc">
                                                📍 エリア：{{ $tourist_spot->area }}<br>
                                                💰 予算目安：{{ $tourist_spot->budget ?? '情報なし' }}
                                            </div>

                                            <div style="margin: 5px 0; display: flex; align-items: center; gap: 5px;">
                                                @if($tourist_spot->reviews_avg_rating)
                                                    @php $ratingRound = round($tourist_spot->reviews_avg_rating); @endphp
                                                    <span style="color: #f0932b; font-weight: bold; font-size: 14px;">{{ str_repeat('⭐', $ratingRound) }}</span>
                                                    <span style="font-size: 12px; color: #666; font-weight: bold; margin-left: 2px;">{{ number_format($tourist_spot->reviews_avg_rating, 1) }}</span>
                                                @else
                                                    <span style="font-size: 11px; color: #aaa;">⭐ クチコミなし</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div class="spot-tags">
                                                @if($tourist_spot->has_activity) <span class="tag-item"><i class="fa-solid fa-person-swimming"></i> 遊ぶ</span> @endif
                                                @if($tourist_spot->has_view) <span class="tag-item"><i class="fa-solid fa-camera"></i> 見る</span> @endif
                                                @if($tourist_spot->has_shopping) <span class="tag-item"><i class="fa-solid fa-bag-shopping"></i> 買う</span> @endif
                                                @if($tourist_spot->has_food) <span class="tag-item"><i class="fa-solid fa-utensils"></i> 食べる</span> @endif
                                            </div>
                                            <div style="color: #ccc; font-size: 14px;"><i class="fa-solid fa-chevron-right"></i></div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif

                        <div style="margin-top: 10px; margin-bottom: 20px;">
                            {{ $tourist_spots->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div> {{-- /.spot-list-container --}}
                </div>

                <div class="side-column">
                    <div class="side-box">
                        <div class="side-box-title">🔍 観光スポットを検索</div>
                        <form action="{{ route('tourist_spots.index') }}" method="GET">

                            <input type="text" name="keyword" class="search-input" placeholder="キーワード（例：ビーチ、教会）" value="{{ request('keyword') }}">

                            <select name="area" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; background-color: white; margin-bottom: 15px;">
                                <option value="">-- エリアで絞り込む --</option>
                                <option value="マクタン島" {{ request('area') == 'マクタン島' ? 'selected' : '' }}>マクタン島</option>
                                <option value="セブ市街" {{ request('area') == 'セブ市街' ? 'selected' : '' }}>セブ市街</option>
                                <option value="オスロブ・モアルボアル" {{ request('area') == 'オスロブ・モアルボアル' ? 'selected' : '' }}>オスロブ・モアルボアル</option>
                            </select>

                            <div style="margin-bottom: 15px; background: #fafafa; padding: 12px; border-radius: 6px; border: 1px solid #eee;">
                                <div style="font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px;">✨ 体験で絞り込む</div>
                                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    <label style="font-size: 13px; color: #444; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                        <input type="checkbox" name="activity" value="1" {{ request('activity') ? 'checked' : '' }}> 🏊 遊ぶ
                                    </label>
                                    <label style="font-size: 13px; color: #444; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                        <input type="checkbox" name="view" value="1" {{ request('view') ? 'checked' : '' }}> 📷 見る
                                    </label>
                                    <label style="font-size: 13px; color: #444; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                        <input type="checkbox" name="shopping" value="1" {{ request('shopping') ? 'checked' : '' }}> 🛍️ 買う
                                    </label>
                                    <label style="font-size: 13px; color: #444; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                        <input type="checkbox" name="food" value="1" {{ request('food') ? 'checked' : '' }}> 🍽️ 食べる
                                    </label>
                                </div>
                            </div>

                            <select name="sort" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; background-color: white; margin-bottom: 15px;">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🕒 新着順</option>
                                <option value="bookmark_count" {{ request('sort') == 'bookmark_count' ? 'selected' : '' }}>🔥 人気順（保存数）</option>
                            </select>

                            <button type="submit" class="search-btn">検索する</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('new_tourist_spot_modal')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('click', function (e) {
                if (e.target.classList.contains('custom-modal')) {
                    e.target.classList.remove('is-show');
                }
            });
        });
    </script>
@endsection