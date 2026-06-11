@extends('layouts.app')
{{-- Takaさん専用の共通CSSを読み込む --}}
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@section('content')
    <style>
        .top-page-wrapper { display: flex; gap: 30px; width: 100%; max-width: 1100px; margin: 0 auto; align-items: flex-start; }
        .main-column { flex: 2; display: flex; flex-direction: column; gap: 25px; min-width: 0; }
        .side-column { flex: 1; max-width: 320px; display: flex; flex-direction: column; gap: 20px; position: sticky; top: 20px; max-height: calc(100vh - 110px); overflow-y: auto; }
        .side-column::-webkit-scrollbar { display: none; }
        .hero-banner { background-color: #1e8b9b; color: white; border-radius: 12px; padding: 40px 20px; margin-top: -24px; text-align: center; position: relative; overflow: hidden; }
        .hero-title { font-size: 28px; font-weight: bold; margin-bottom: 10px; }
        .hero-subtitle { font-size: 14px; margin-bottom: 20px; opacity: 0.9; }
        .spot-card-horizontal { display: flex; background: white; border-radius: 12px; overflow: hidden; border: 1px solid #eee; text-decoration: none; color: inherit; transition: 0.2s; }
        .spot-card-horizontal:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.05); }
        .spot-card-img-area { width: 180px; flex-shrink: 0; }
        .spot-card-img-area img { width: 100%; height: 100%; object-fit: cover; }
        .spot-card-info { padding: 15px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .spot-title { font-size: 18px; font-weight: bold; margin-bottom: 8px; color: #333; }
        .spot-desc { font-size: 13px; color: #666; line-height: 1.5; margin-bottom: 10px; }
        .spot-tags { display: flex; gap: 8px; flex-wrap: wrap; }
        .tag-item { font-size: 11px; font-weight: bold; color: #1e8b9b; background: #e6f0f9; padding: 4px 8px; border-radius: 4px; }
        .side-box { background: white; border-radius: 12px; border: 1px solid #eee; padding: 20px; }
        .side-box-title { font-size: 16px; font-weight: bold; color: #333; margin-bottom: 15px; border-bottom: 2px solid #1e8b9b; padding-bottom: 8px; }
        .search-input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; margin-bottom: 15px; }
        .search-btn { width: 100%; padding: 12px; background-color: #1e8b9b; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.2s; }
        .search-btn:hover { background-color: #166b78; }

        /* 🌟 追加：注目スポット用のアニメーションCSS */
        .featured-spot-card {
            display: block;
            text-decoration: none;
            color: inherit;
            background: #fafafa;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }
        .featured-spot-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(30, 139, 155, 0.15);
            background: white;
            border-color: #1e8b9b;
        }

        /* 📱 ここから追加：スマホ対応（レスポンシブ）マジック！ */
        @media (max-width: 768px) {
            .top-page-wrapper { flex-direction: column; gap: 20px; }
            .main-column { display: contents; } /* 枠を解除して並べ替え可能に */
            
            .error-box { order: 1; width: 100%; }
            
            .hero-banner { 
                order: 2; 
                margin-top: 0; 
                padding: 25px 15px; 
                width: 100%; 
                box-sizing: border-box; 
            }
            .hero-title { font-size: 22px; margin-bottom: 5px; }
            .hero-subtitle { font-size: 12px; margin-bottom: 15px; }

            .side-column { 
                order: 3; 
                position: static; 
                max-height: none; 
                overflow-y: visible; 
                width: 100%; 
                max-width: 100%; 
            }

            .spot-list-container { 
                order: 4; 
                width: 100%; 
                display: flex; 
                flex-direction: column; 
                gap: 20px; 
            }

            .spot-card-horizontal { flex-direction: column; }
            .spot-card-img-area { width: 100%; height: 200px; }
        }
    </style>

    <div class="container" style="padding-top: 0; margin-top: 0;">
        <div class="content-section" style="padding-top: 0; margin-top: 0;">
            <div class="top-page-wrapper" style="padding-top: 0; margin-top: 0;">
                
                <div class="main-column" style="padding-top: 0; margin-top: 0;">
                    
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

                    <div class="hero-banner">
                        <div style="position: absolute; top: 15px; right: 25px; width: 60px; height: 40px; display: flex; align-items: center; user-select: none;">
                            <img src="https://flagcdn.com/w80/jp.png" alt="Japan" style="width: 34px; transform: rotate(-15deg); margin-right: -12px; z-index: 2; position: relative; top: 8px; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.4)); border-radius: 3px;">
                            <img src="https://flagcdn.com/w80/ph.png" alt="Philippines" style="width: 34px; transform: rotate(12deg); z-index: 1; position: relative; top: -6px; filter: drop-shadow(2px 2px 5px rgba(0,0,0,0.3)); border-radius: 3px;">
                        </div>

                        <div class="hero-title">CEBU STUDY 🌴</div>
                        <div class="hero-subtitle">あなただけの最高の集中スポット・学習環境を見つけよう</div>
                        <button onclick="document.getElementById('newSpotModal').classList.add('is-show')"
                            style="background-color: white; color: #1e8b9b; border: none; padding: 10px 24px; border-radius: 20px; font-weight: bold; font-size: 14px; cursor: pointer;">
                            ＋ 新規スポットを登録
                        </button>
                    </div>

                    {{-- 🌟 スポット一覧コンテナ --}}
                    <div class="spot-list-container">
                        <h3 style="font-size: 18px; color: #333; border-left: 4px solid #1e8b9b; padding-left: 10px; margin: 10px 0 0 0;">
                            @if(request()->has('keyword') || request()->has('area') || request()->has('wifi') || request()->has('power'))
                                🔍 検索結果：{{ $spots->count() }}件
                            @else
                                ✨ 最近登録されたスポット
                            @endif
                        </h3>

                        @if($spots->isEmpty())
                            <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 12px; border: 1px dashed #ccc; color: #666;">
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
                        
                        <div style="margin-top: 10px; margin-bottom: 20px;">
                            {{ $spots->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div> {{-- /.spot-list-container --}}
                </div>
                
                <div class="side-column">
                    <div class="side-box">
                        <div class="side-box-title">🔍 スポットを検索</div>
                        <form action="/" method="GET">
                            <div style="margin-bottom: 15px; font-size: 14px; color: #555; display: flex; gap: 15px; padding-left: 5px;">
                                <label style="cursor: pointer; display: flex; align-items: center; gap: 5px; font-weight: bold;">
                                    <input type="checkbox" name="has_power" value="1" {{ request('has_power') ? 'checked' : '' }}> 🔌 コンセント
                                </label>
                                <label style="cursor: pointer; display: flex; align-items: center; gap: 5px; font-weight: bold;">
                                    <input type="checkbox" name="has_wifi" value="1" {{ request('has_wifi') ? 'checked' : '' }}> 📶 Wi-Fi
                                </label>
                            </div>
                            <input type="text" name="keyword" class="search-input" placeholder="キーワード（例：カフェ、静か）" value="{{ request('keyword') }}">
                            <select name="sort" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px; background-color: white; margin-bottom: 15px; border-color: #1e8b9b; color: #1e8b9b; font-weight: bold; cursor: pointer;">
                                <option value="new" @selected(request('sort') == 'new' || !request()->has('sort'))>✨ 新着順（デフォルト）</option>
                                <option value="old" @selected(request('sort') == 'old')>⏳ 古い順</option>
                                <option value="reviews" @selected(request('sort') == 'reviews')>💬 クチコミの多い順</option>
                            </select>
                            <select name="area" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; background-color: white; margin-bottom: 15px;">
                                <option value="">-- エリアで絞り込む --</option>
                                <option value="ITパーク" {{ request('area') == 'ITパーク' ? 'selected' : '' }}>ITパーク</option>
                                <option value="アヤラ" {{ request('area') == 'アヤラ' ? 'selected' : '' }}>アヤラ</option>
                                <option value="その他（タクシー圏内）" {{ request('area') == 'その他（タクシー圏内）' ? 'selected' : '' }}>その他（タクシー圏内）</option>
                            </select>

                            <button type="submit" class="search-btn">検索する</button>
                        </form>
                    </div>

                    {{-- 🌟 注目スポット＆マッサージエリア --}}
                    <div class="side-box">
                        <div class="side-box-title">🔥 注目のスポット</div>
                        
                        @php
                            // --- 注目スポットの選出ロジック ---
                            $featuredSpot = null;
                            $featuredBadge = "";
                            
                            if ($spots->isNotEmpty()) {
                                // 1. 1週間以内の新規スポットを探す
                                $featuredSpot = $spots->first(function($spot) {
                                    return $spot->created_at >= now()->subDays(7);
                                });

                                if ($featuredSpot) {
                                    $featuredBadge = "🆕 今週のNEWスポット";
                                } else {
                                    // 2. なければ、評価が一番高いスポットを選出
                                    $featuredSpot = $spots->sortByDesc('reviews_avg_rating')->first();
                                    $featuredBadge = "👑 殿堂入り高評価";
                                }
                            }
                            
                            // プレミアムユーザー向け：ランダムでマッサージ店を表示（1/3の確率）
                            // ※本番環境でユーザーテーブルに is_premium ができたら Auth::user()->is_premium に変更
                            $showMassageAd = Auth::check() && rand(1, 3) === 1;
                        @endphp

                        @if($featuredSpot)
                            <a href="{{ route('spots.show', $featuredSpot->id) }}" class="featured-spot-card">
                                <div style="font-size: 11px; color: white; background-color: #f0932b; display: inline-block; padding: 3px 8px; border-radius: 4px; font-weight: bold; margin-bottom: 8px;">
                                    {{ $featuredBadge }}
                                </div>
                                
                                <div style="width: 100%; height: 120px; border-radius: 8px; overflow: hidden; margin-bottom: 10px;">
                                    @if($featuredSpot->photo_path)
                                        <img src="{{ asset('storage/' . $featuredSpot->photo_path) }}" alt="{{ $featuredSpot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="https://placehold.co/300x150/e6f0f9/1e8b9b?text=Featured" style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                </div>
                                
                                <div style="font-weight: bold; color: #333; font-size: 15px; margin-bottom: 4px;">{{ $featuredSpot->name }}</div>
                                <div style="font-size: 12px; color: #666; display: flex; justify-content: space-between; align-items: center;">
                                    <span>
                                        @if($featuredSpot->reviews_avg_rating)
                                            <span style="color: #f0932b;">⭐ {{ number_format($featuredSpot->reviews_avg_rating, 1) }}</span>
                                        @else
                                            <span style="color: #ccc;">⭐ -.-</span>
                                        @endif
                                        ({{ $featuredSpot->area }})
                                    </span>
                                    <i class="fa-solid fa-arrow-right" style="color: #1e8b9b;"></i>
                                </div>
                            </a>
                        @else
                            <p style="font-size: 12px; color: #888; text-align: center;">現在注目のスポットを集計中です</p>
                        @endif

                        {{-- 💆‍♂️ プレミアムユーザー限定のマッサージ広告（ランダム表示） --}}
                        @if($showMassageAd)
                            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed #ddd;">
                                <div style="font-size: 11px; color: #888; margin-bottom: 8px; font-weight: bold;">💎 Premium会員様へのおすすめ</div>
                                <a href="#" style="display: block; text-decoration: none; background: linear-gradient(135deg, #2c3e50, #4ca1af); padding: 15px; border-radius: 8px; color: white; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="font-size: 24px;">💆‍♀️</div>
                                        <div>
                                            <div style="font-size: 13px; font-weight: bold; margin-bottom: 2px;">Cebu Relax Spa</div>
                                            <div style="font-size: 10px; opacity: 0.9;">勉強の疲れを癒やしませんか？<br>会員限定20%OFFクーポン配布中！</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('new_spot_modal')
@endsection