@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div id="flash-message" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #1e8b9b; color: white; padding: 12px 24px; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 10000; transition: opacity 0.5s ease;">
            {{ session('success') }}
        </div>
        <script>setTimeout(() => { const msg = document.getElementById('flash-message'); if (msg) { msg.style.opacity = '0'; setTimeout(() => msg.remove(), 500); } }, 3000);</script>
    @endif

    <div class="mypage-container" style="padding-bottom: 80px;">

        {{-- ==========================================================================
             👤 トップダッシュボード（プロフィール ＆ 今週のピックアップ）
             ========================================================================== --}}
        <div class="top-dashboard" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 50px;">
            {{-- 左側：プロフィール --}}
            <div class="user-profile-box" style="flex: 1; min-width: 300px; background: linear-gradient(135deg, #1e8b9b, #3b9db0); color: white; padding: 30px; border-radius: 12px; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="user-avatar" style="font-size: 40px; background: rgba(255,255,255,0.2); width: 80px; height: 80px; display: flex; justify-content: center; align-items: center; border-radius: 50%;">👤</div>
                <div>
                    <h1 class="user-name" style="margin: 0 0 5px 0; font-size: 24px; font-weight: bold;">{{ Auth::user()->name }} さん</h1>
                    <div class="user-date" style="font-size: 14px; opacity: 0.9;">登録日: {{ Auth::user()->created_at->format('Y/m/d') }}</div>
                </div>
            </div>

            {{-- 右側：偶然の出会い（ピックアップスポット） ※現在はモックアップ（仮表示）です --}}
           {{-- 右側：週替わりピックアップスポット（本番稼働） --}}
            <div style="flex: 1; min-width: 300px; background: white; padding: 25px; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: center;">
                <h3 style="font-size: 14px; font-weight: bold; color: #f0932b; margin: 0 0 15px 0; display: flex; align-items: center; gap: 8px;">
                    💡 今週のおすすめスポット
                </h3>
                
                @if($pickupSpot)
                    @php
                        // 学習スポットか観光スポットかで、色やリンク先を自動で切り替える賢い設定
                        $isTourist = ($pickupType === 'tourist');
                        $badgeColor = $isTourist ? '#f0932b' : '#007b8f';
                        $badgeText = $isTourist ? '🌴 息抜きに！' : '📚 人気急上昇！';
                        $route = $isTourist ? route('tourist_spots.show', $pickupSpot->id) : route('spots.show', $pickupSpot->id);
                    @endphp

                    <a href="{{ $route }}" style="display: flex; gap: 15px; align-items: center; text-decoration: none; color: inherit; background: #fafafa; padding: 10px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='#f0f8ff'" onmouseout="this.style.background='#fafafa'">
                        <div style="width: 70px; height: 70px; border-radius: 8px; background-color: #ddd; overflow: hidden; flex-shrink: 0;">
                            @if($pickupSpot->photo_path)
                                <img src="{{ asset('storage/' . $pickupSpot->photo_path) }}" alt="{{ $pickupSpot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background: #eee; color: #aaa; font-size: 10px;">No Photo</div>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 10px; color: #fff; background: {{ $badgeColor }}; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-bottom: 5px;">{{ $badgeText }}</div>
                            <h4 style="font-size: 14px; font-weight: bold; color: #333; margin: 0 0 5px 0;">{{ $pickupSpot->name }}</h4>
                            <p style="font-size: 11px; color: #666; margin: 0; line-height: 1.4;">
                                いま、Kredon Cebuで一番保存されているスポットです！🔥
                            </p>
                        </div>
                    </a>
                @else
                    <p style="font-size: 12px; color: #888;">データがありません。</p>
                @endif
            </div>
        </div>

        {{-- ==========================================================================
             📚 セクション1：保存した学習スポット（観光スポットと完全統一デザイン）
             ========================================================================== --}}
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
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
            <div class="grid-layout" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                @foreach($myBookmarks as $spot)
                    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s;">
                        
                        <div>
                            {{-- 写真＆バッジエリア --}}
                            <div class="spot-img-wrapper" style="position: relative; width: 100%; height: 160px; background-color: #eee;">
                                @if($spot->photo_path)
                                    <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="{{ $spot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; color: #aaa; font-size: 13px;">No Photo</div>
                                @endif
                                {{-- 📍 エリアバッジ（観光スポットと同じ位置） --}}
                                <span style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.6); color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                                    📍 {{ $spot->area }}
                                </span>
                            </div>

                            {{-- テキスト詳細エリア --}}
                            <div class="spot-card-content" style="padding: 15px;">
                                <div class="spot-name" style="font-size: 15px; font-weight: bold; color: #333; margin: 0 0 10px 0; line-height: 1.4; height: 42px; overflow: hidden;">
                                    {{ $spot->name }}
                                </div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">
                                    📶 WiFi: {{ $spot->has_wifi ? 'あり' : 'なし' }}
                                </div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">
                                    🔌 電源: {{ $spot->has_power ? 'あり' : 'なし' }}
                                </div>
                            </div>
                        </div>

                        {{-- 詳細を見るボタン（観光スポットと完全統一） --}}
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
             🌴 セクション2：保存した観光スポット（学習スポットと完全統一デザイン）
             ========================================================================== --}}
        <div class="section-header" style="margin-top: 60px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 20px;">
            <h2 class="section-title" style="font-size: 20px; font-weight: bold; color: #007b8f; margin: 0;">
                🌴 保存した観光スポット
            </h2>
        </div>

        @if(!isset($bookmarkedTouristSpots) || $bookmarkedTouristSpots->isEmpty())
            <div style="background: white; padding: 40px; text-align: center; border-radius: 12px; border: 1px dashed #ccc; color: #999; margin-bottom: 50px;">
                <p style="margin-bottom: 15px;">保存された観光スポットはまだありません。</p>
                <a href="{{ route('tourist_spots.index') }}" style="display: inline-block; background-color: #007b8f; color: white; text-decoration: none; padding: 8px 18px; border-radius: 20px; font-weight: bold; font-size: 13px;">
                    観光スポットを探す
                </a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-bottom: 50px;">
                @foreach($bookmarkedTouristSpots as $spot)
                    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s;">
                        
                        <div>
                            {{-- 写真＆バッジエリア --}}
                            <div style="position: relative; width: 100%; height: 160px; background-color: #eee;">
                                @if($spot->photo_path)
                                    <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="{{ $spot->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; color: #aaa; font-size: 13px;">No Photo</div>
                                @endif
                                {{-- 📍 エリアバッジ --}}
                                <span style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.6); color: white; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                                    📍 {{ $spot->area }}
                                </span>
                            </div>

                            {{-- テキスト詳細エリア --}}
                            <div style="padding: 15px;">
                                <h3 style="font-size: 15px; font-weight: bold; color: #333; margin: 0 0 10px 0; line-height: 1.4; height: 42px; overflow: hidden;">
                                    {{ $spot->name }}
                                </h3>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">💰 予算: {{ $spot->budget ?? '情報なし' }}</div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">🕒 時間: {{ $spot->hours ?? '未定' }}</div>
                            </div>
                        </div>

                        {{-- 詳細を見るボタン --}}
                        <div style="padding: 0 15px 15px 15px;">
                            <a href="{{ route('tourist_spots.show', $spot->id) }}" style="display: block; text-align: center; background-color: #007b8f; color: white; text-decoration: none; padding: 10px; border-radius: 6px; font-weight: bold; font-size: 13px; transition: 0.3s;">
                                詳細を見る
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection