@extends('layouts.app')

@section('content')
    <style>
        .mypage-wrapper { padding: 0 15px 80px 15px; max-width: 1200px; margin: 0 auto; }
        .top-dashboard { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 50px; }
        .user-profile-box { flex: 1; min-width: 300px; background: linear-gradient(135deg, #1e8b9b, #3b9db0); color: white; padding: 30px; border-radius: 12px; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); box-sizing: border-box; }
        .pickup-box { flex: 1; min-width: 300px; background: white; padding: 25px; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: center; box-sizing: border-box; perspective: 1000px; /* 3D空間を作成 */ }
        
        /* 🌟 ゾクゾクする3Dフリップのアニメーション設定 */
        .flip-container { width: 100%; height: 90px; position: relative; }
        .flip-inner { width: 100%; height: 100%; position: absolute; transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-style: preserve-3d; }
        .is-flipped .flip-inner { transform: rotateY(180deg); }
        .flip-front, .flip-back { width: 100%; height: 100%; position: absolute; backface-visibility: hidden; display: flex; gap: 15px; align-items: center; background: #fafafa; padding: 10px; border-radius: 8px; box-sizing: border-box; }
        .flip-back { transform: rotateY(180deg); background: #fffaf0; border: 1px solid #fde7cc; } /* 観光スポット側の色分け */

        .section-header-custom { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; }
        .grid-layout-custom { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        
        @media (max-width: 768px) {
            .top-dashboard { flex-direction: column; gap: 15px; margin-bottom: 30px; }
            .user-profile-box, .pickup-box { min-width: 100%; padding: 20px; }
            .section-header-custom { flex-direction: column; align-items: flex-start; gap: 12px; }
            .section-header-custom form { width: 100%; }
            .filter-select { width: 100%; box-sizing: border-box; }
            .grid-layout-custom { grid-template-columns: 1fr; }
        }
    </style>

    @if (session('success'))
        <div id="flash-message" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #1e8b9b; color: white; padding: 12px 24px; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 10000; transition: opacity 0.5s ease;">
            {{ session('success') }}
        </div>
        <script>setTimeout(() => { const msg = document.getElementById('flash-message'); if (msg) { msg.style.opacity = '0'; setTimeout(() => msg.remove(), 500); } }, 3000);</script>
    @endif

    <div class="mypage-wrapper">

        <div class="top-dashboard">
            <div class="user-profile-box">
                <div class="user-avatar" style="font-size: 40px; background: rgba(255,255,255,0.2); width: 80px; height: 80px; display: flex; justify-content: center; align-items: center; border-radius: 50%; flex-shrink: 0;">👤</div>
                <div>
                    <h1 class="user-name" style="margin: 0 0 5px 0; font-size: 24px; font-weight: bold;">{{ Auth::user()->name }} さん</h1>
                    <div class="user-date" style="font-size: 14px; opacity: 0.9;">登録日: {{ Auth::user()->created_at->format('Y/m/d') }}</div>
                </div>
            </div>

            <div class="pickup-box">
                <h3 style="font-size: 14px; font-weight: bold; color: #f0932b; margin: 0 0 15px 0; display: flex; justify-content: space-between; align-items: center;">
                    <span>💡 今週のおすすめスポット</span>
                    <span style="font-size: 10px; color: #aaa; font-weight: normal;">10秒で切り替わります🔄</span>
                </h3>
                
                {{-- 🌟 3Dフリップコンテナ --}}
                <div class="flip-container" id="pickupFlipBox">
                    <div class="flip-inner">
                        
                        {{-- 表面：学習スポット（Controllerから $learningPickup が渡る想定） --}}
                        <div class="flip-front">
                            @php $frontSpot = $learningPickup ?? $pickupSpot ?? null; @endphp
                            @if($frontSpot)
                                <a href="{{ route('spots.show', $frontSpot->id) }}" style="display: flex; gap: 15px; align-items: center; text-decoration: none; color: inherit; width: 100%;">
                                    <div style="width: 70px; height: 70px; border-radius: 8px; background-color: #ddd; overflow: hidden; flex-shrink: 0;">
                                        @if($frontSpot->photo_path)
                                            <img src="{{ asset('storage/' . $frontSpot->photo_path) }}" alt="{{ $frontSpot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background: #eee; color: #aaa; font-size: 10px;">No Photo</div>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 10px; color: #fff; background: #007b8f; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-bottom: 5px;">📚 集中したい時に！</div>
                                        <h4 style="font-size: 14px; font-weight: bold; color: #333; margin: 0 0 5px 0;">{{ $frontSpot->name }}</h4>
                                        <p style="font-size: 11px; color: #666; margin: 0; line-height: 1.4;">いま一番人気の学習スポットです！🔥</p>
                                    </div>
                                </a>
                            @else
                                <p style="font-size: 12px; color: #888; text-align: center; width: 100%;">データがありません。</p>
                            @endif
                        </div>

                        {{-- 裏面：観光スポット（Controllerから $touristPickup が渡る想定） --}}
                        <div class="flip-back">
                            @php $backSpot = $touristPickup ?? $pickupSpot ?? null; @endphp
                            @if($backSpot)
                                <a href="{{ route('tourist_spots.show', $backSpot->id) }}" style="display: flex; gap: 15px; align-items: center; text-decoration: none; color: inherit; width: 100%;">
                                    <div style="width: 70px; height: 70px; border-radius: 8px; background-color: #ddd; overflow: hidden; flex-shrink: 0;">
                                        @if($backSpot->photo_path)
                                            <img src="{{ asset('storage/' . $backSpot->photo_path) }}" alt="{{ $backSpot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background: #eee; color: #aaa; font-size: 10px;">No Photo</div>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 10px; color: #fff; background: #f0932b; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-bottom: 5px;">🌴 週末の息抜きに！</div>
                                        <h4 style="font-size: 14px; font-weight: bold; color: #333; margin: 0 0 5px 0;">{{ $backSpot->name }}</h4>
                                        <p style="font-size: 11px; color: #666; margin: 0; line-height: 1.4;">勉強の疲れを癒やすリフレッシュ旅へ！✈️</p>
                                    </div>
                                </a>
                            @else
                                <p style="font-size: 12px; color: #888; text-align: center; width: 100%;">データがありません。</p>
                            @endif
                        </div>

                    </div>
                </div>
                {{-- 10秒ごとにクラスを付け外して裏返すJavaScript --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const flipBox = document.getElementById('pickupFlipBox');
                        setInterval(() => {
                            flipBox.classList.toggle('is-flipped');
                        }, 10000); // 10秒（10000ミリ秒）
                    });
                </script>
            </div>
        </div>

        {{-- ==========================================================================
             📚 セクション1：保存した学習スポット
             ========================================================================== --}}
        <div class="section-header-custom">
            <h2 class="section-title" style="font-size: 20px; font-weight: bold; color: #007b8f; margin: 0;">📚 保存した学習スポット</h2>

            <form action="{{ route('mypage') }}" method="GET" style="margin: 0;">
                <select name="filter" class="filter-select" onchange="this.form.submit()" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc; font-size: 13px;">
                    <option value="">-- 並び替え・絞り込み --</option>
                    <option value="recent" {{ request('filter') == 'recent' ? 'selected' : '' }}>🕒 最近登録した順</option>
                    <option value="wifi" {{ request('filter') == 'wifi' ? 'selected' : '' }}>📶 WiFiあり</option>
                    <option value="power" {{ request('filter') == 'power' ? 'selected' : '' }}>🔌 電源あり</option>
                </select>
            </form>
        </div>
        
        @if($myBookmarks->isEmpty())
            <p style="color: #999; background: white; padding: 40px; border-radius: 12px; text-align: center; border: 1px dashed #ccc; margin-bottom: 50px;">
                保存された学習スポットはまだありません。
            </p>
        @else
            <div class="grid-layout-custom">
                @foreach($myBookmarks as $spot)
                    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s;">
                        <div>
                            <div class="spot-img-wrapper" style="position: relative; width: 100%; height: 160px; background-color: #eee;">
                                @if($spot->photo_path)
                                    <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="{{ $spot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; color: #aaa; font-size: 13px;">No Photo</div>
                                @endif
                                <span style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.6); color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                                    📍 {{ $spot->area }}
                                </span>
                            </div>
                            <div class="spot-card-content" style="padding: 15px;">
                                <div class="spot-name" style="font-size: 15px; font-weight: bold; color: #333; margin: 0 0 10px 0; line-height: 1.4; height: 42px; overflow: hidden;">
                                    {{ $spot->name }}
                                </div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">📶 WiFi: {{ $spot->has_wifi ? 'あり' : 'なし' }}</div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">🔌 電源: {{ $spot->has_power ? 'あり' : 'なし' }}</div>
                            </div>
                        </div>
                        <div style="padding: 0 15px 15px 15px;">
                            <a href="{{ route('spots.show', $spot->id) }}" style="display: block; text-align: center; background-color: #007b8f; color: white; text-decoration: none; padding: 10px; border-radius: 6px; font-weight: bold; font-size: 13px; transition: 0.3s;">
                                詳細を見る
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 25px; margin-bottom: 50px;">
                {{ $myBookmarks->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

        {{-- ==========================================================================
             🌴 セクション2：保存した観光スポット
             ========================================================================== --}}
        <div class="section-header-custom" style="margin-top: 60px;">
            <h2 class="section-title" style="font-size: 20px; font-weight: bold; color: #f0932b; margin: 0;">
                🌴 保存した観光スポット
            </h2>

            {{-- 🌟 改善：観光スポット用の具体的絞り込み --}}
            <form action="{{ route('mypage') }}" method="GET" style="margin: 0;">
                <select name="tourist_filter" class="filter-select" onchange="this.form.submit()" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc; font-size: 13px;">
                    <option value="">-- 並び替え・絞り込み --</option>
                    <option value="recent" {{ request('tourist_filter') == 'recent' ? 'selected' : '' }}>🕒 最近保存した順</option>
                    <option value="area_cebu" {{ request('tourist_filter') == 'area_cebu' ? 'selected' : '' }}>📍 セブ市内（近場でサクッと）</option>
                    <option value="area_far" {{ request('tourist_filter') == 'area_far' ? 'selected' : '' }}>📍 マクタン・遠方（海・ガッツリ）</option>
                </select>
            </form>
        </div>

        @if(!isset($bookmarkedTouristSpots) || $bookmarkedTouristSpots->isEmpty())
            <div style="background: white; padding: 40px; text-align: center; border-radius: 12px; border: 1px dashed #ccc; color: #999; margin-bottom: 50px;">
                <p style="margin-bottom: 15px;">保存された観光スポットはまだありません。</p>
                <a href="{{ route('tourist_spots.index') }}" style="display: inline-block; background-color: #f0932b; color: white; text-decoration: none; padding: 8px 18px; border-radius: 20px; font-weight: bold; font-size: 13px;">
                    観光スポットを探す
                </a>
            </div>
        @else
            <div class="grid-layout-custom" style="margin-bottom: 50px;">
                @foreach($bookmarkedTouristSpots as $spot)
                    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s;">
                        <div>
                            <div style="position: relative; width: 100%; height: 160px; background-color: #eee;">
                                @if($spot->photo_path)
                                    <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="{{ $spot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; color: #aaa; font-size: 13px;">No Photo</div>
                                @endif
                                <span style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.6); color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                                    📍 {{ $spot->area }}
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <h3 style="font-size: 15px; font-weight: bold; color: #333; margin: 0 0 10px 0; line-height: 1.4; height: 42px; overflow: hidden;">
                                    {{ $spot->name }}
                                </h3>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">💰 予算: {{ $spot->budget ?? '情報なし' }}</div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">🕒 時間: {{ $spot->hours ?? '未定' }}</div>
                            </div>
                        </div>
                        <div style="padding: 0 15px 15px 15px;">
                            <a href="{{ route('tourist_spots.show', $spot->id) }}" style="display: block; text-align: center; background-color: #f0932b; color: white; text-decoration: none; padding: 10px; border-radius: 6px; font-weight: bold; font-size: 13px; transition: 0.3s;">
                                詳細を見る
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection