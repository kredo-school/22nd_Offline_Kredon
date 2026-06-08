@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .mypage-container {
            max-width: 1000px;
            margin: 30px auto 40px auto;
            padding: 0 20px;
        }

        .top-dashboard {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        /* 🌟 トップページのヒーローバナーと同じ「深いグラデーションカラー」と「サイズ感」に統一！ */
        .user-profile-box {
            flex: 1;
            min-width: 300px;
            background: linear-gradient(135deg, #1e8b9b, #4a82b3);
            padding: 35px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(30, 139, 155, 0.2);
            border: none;
            display: flex;
            align-items: center;
            gap: 20px;
            color: white;
        }

        .user-avatar {
            width: 70px;
            height: 70px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            color: #1e8b9b;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .user-name {
            font-size: 22px;
            font-weight: bold;
            color: white;
            margin: 0 0 5px 0;
        }

        .user-date {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }

        .todo-box {
            flex: 1;
            min-width: 300px;
            background: #fafafa;
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #eee;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .todo-box h3 {
            font-size: 15px;
            color: #1e8b9b;
            margin-top: 0;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .todo-list {
            padding-left: 20px;
            margin: 0;
            color: #666;
        }

        .todo-list li {
            margin-bottom: 12px;
        }

        .todo-list input[type="text"] {
            border: none;
            background: transparent;
            width: 90%;
            font-size: 14px;
            color: #444;
            outline: none;
            font-family: inherit;
        }

        .todo-list input[type="text"]:focus {
            border-bottom: 1px dashed #1e8b9b;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .section-title {
            font-size: 18px;
            color: #333;
            border-left: 4px solid #1e8b9b;
            padding-left: 10px;
            margin: 0;
        }

        .filter-select {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-weight: bold;
            color: #555;
            background-color: white;
            cursor: pointer;
            outline: none;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .spot-mini-card {
            background: white;
            border-radius: 10px;
            border: 1px solid #eee;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .spot-mini-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(30, 139, 155, 0.15);
            border-color: #c9d8e4;
        }

        .spot-img-wrapper {
            height: 140px;
            background-color: #f4f8fb;
            width: 100%;
        }

        .spot-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .spot-card-content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
        }

        .spot-name {
            font-size: 16px;
            font-weight: bold;
            color: #1e8b9b;
            margin-bottom: 5px;
        }

        .popularity-badge {
            display: inline-block;
            background-color: #fff0f0;
            color: #e53e3e;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 12px;
            border: 1px solid #ffd6d6;
            align-self: flex-start;
        }

        .review-card-item {
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
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
            box-shadow: 0 2px 6px rgba(30, 139, 155, 0.3);
        }
    </style>

    @if (session('success'))
        <div id="flash-message"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #1e8b9b; color: white; padding: 12px 24px; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 10000; transition: opacity 0.5s ease;">
            {{ session('success') }}
        </div>
        <script>setTimeout(() => { const msg = document.getElementById('flash-message'); if (msg) { msg.style.opacity = '0'; setTimeout(() => msg.remove(), 500); } }, 3000);</script>
    @endif

    <div class="mypage-container">

        <div class="top-dashboard">
            <div class="user-profile-box">
                <div class="user-avatar">👤</div>
                <div>
                    <h1 class="user-name">{{ Auth::user()->name }} さんのマイページ</h1>
                    <div class="user-date">登録日: {{ Auth::user()->created_at->format('Y年m月d日') }}</div>
                </div>
            </div>

            <div class="todo-box">
                <h3>📝 今日の目標（クリックして編集）</h3>
                <ul class="todo-list">
                    <li><input type="text" value="get my homework done" placeholder="目標を入力..."></li>
                    <li><input type="text" value="make portfolio" placeholder="目標を入力..."></li>
                    <li><input type="text" value="review today's lesson" placeholder="目標を入力..."></li>
                </ul>
            </div>
        </div>

        <div class="section-header">
            <h2 class="section-title">⭐ お気に入り登録したスポット（{{ $myBookmarks->total() }}件）</h2>

            <form action="{{ route('mypage') }}" method="GET" style="margin: 0;">
                <select name="filter" class="filter-select" onchange="this.form.submit()">
                    <option value="">-- 並び替え・絞り込み --</option>
                    <option value="recent" {{ request('filter') == 'recent' ? 'selected' : '' }}>🕒 最近登録した順</option>
                    <option value="wifi" {{ request('filter') == 'wifi' ? 'selected' : '' }}>📶 WiFiあり</option>
                    <option value="power" {{ request('filter') == 'power' ? 'selected' : '' }}>🔌 電源あり</option>
                </select>
            </form>
        </div>

        @if($myBookmarks->isEmpty())
            <p
                style="color: #999; background: white; padding: 30px; border-radius: 8px; text-align: center; border: 1px dashed #ccc; margin-bottom: 50px;">
                お気に入り登録されたスポットはまだありません。</p>
        @else
            <div class="grid-layout">
                @foreach($myBookmarks as $spot)
                    <a href="{{ route('spots.show', $spot->id) }}" class="spot-mini-card">
                        <div class="spot-img-wrapper">
                            @if($spot->photo_path)
                                <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="{{ $spot->name }}">
                            @else
                                <img src="https://placehold.co/400x300/e6f0f9/4a82b3?text=No+Photo" alt="写真なし">
                            @endif
                        </div>
                        <div class="spot-card-content">
                            <div>
                                <div class="spot-name">🏢 {{ $spot->name }}</div>
                                <div style="font-size: 13px; color: #666; margin-top: 5px;">📍 エリア：{{ $spot->area }}</div>
                                <div style="margin-top: 10px; display: flex; gap: 10px; font-size: 11px;">
                                    @if($spot->has_wifi)<span
                                        style="color: #1e8b9b; background: #f4f8fb; padding: 2px 6px; border-radius: 4px;"><i
                                    class="fa-solid fa-wifi"></i> WiFi</span>@endif
                                    @if($spot->has_power)<span
                                        style="color: #1e8b9b; background: #f4f8fb; padding: 2px 6px; border-radius: 4px;"><i
                                    class="fa-solid fa-plug-circle-bolt"></i> 電源</span>@endif
                                </div>
                            </div>
                            <div class="popularity-badge">
                                🔥 {{ $spot->bookmarks()->count() }}人がお気に入り
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="margin-top: 25px; margin-bottom: 50px;">
             {{ $myBookmarks->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

        <div class="section-header" style="margin-top: 50px;">
            <h2 class="section-title">💬 自分が投稿したクチコミ一覧（{{ $myReviews->total() }}件）</h2>
        </div>

        @if($myReviews->isEmpty())
            <p
                style="color: #999; background: white; padding: 30px; border-radius: 8px; text-align: center; border: 1px dashed #ccc;">
                投稿したクチコミはまだありません。</p>
        @else
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach($myReviews as $review)
                    <div class="review-card-item">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                            <a href="{{ route('spots.show', $review->spot->id) }}"
                                style="font-weight: bold; color: #333; text-decoration: none; font-size: 16px;">🏢
                                {{ $review->spot->name }} への投稿</a>
                            <span style="font-size: 12px; color: #999;">📅 {{ $review->created_at->format('Y年m月d日') }}</span>
                        </div>

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

                        @if($review->comment)
                            <p style="color: #444; font-size: 14px; line-height: 1.5; white-space: pre-wrap; margin: 0 0 10px 0;">
                                {{ $review->comment }}
                        </p>@endif

                        @if($review->good_point || $review->bad_point)
                            <div
                                style="display: flex; gap: 15px; font-size: 12px; background: #fafafa; padding: 10px; border-radius: 6px; border: 1px dashed #eee;">
                                @if($review->good_point)
                                    <div style="color: #e53e3e; font-weight: bold;">✨ 良かった点: <span
                                style="font-weight: normal; color: #555;">{{ $review->good_point }}</span></div>@endif
                                @if($review->bad_point)
                                    <div style="color: #3182ce; font-weight: bold;">🤔 気になる点: <span
                                style="font-weight: normal; color: #555;">{{ $review->bad_point }}</span></div>@endif
                            </div>
                        @endif

                        <div
                            style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 15px; border-top: 1px dashed #eee; padding-top: 15px;">
                            <button onclick="document.getElementById('editReviewModal-{{ $review->id }}').classList.add('is-show')"
                                style="color: #555; background: #fff; border: 1px solid #ddd; padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <i class="fa-solid fa-pen" style="color: #1e8b9b;"></i> 編集
                            </button>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                onsubmit="return confirm('本当にこのクチコミを削除しますか？');" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="color: #555; background: #fff; border: 1px solid #ddd; padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    <i class="fa-regular fa-trash-can" style="color: #e53e3e;"></i> 削除
                                </button>
                            </form>
                        </div>

                        <div class="custom-modal" id="editReviewModal-{{ $review->id }}">
                            <div class="modal-content" style="padding: 0;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                                    <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">クチコミを編集</h2>
                                    <button type="button"
                                        onclick="document.getElementById('editReviewModal-{{ $review->id }}').classList.remove('is-show')"
                                        class="close-btn" style="position: static;">×</button>
                                </div>
                                <form action="{{ route('reviews.update', $review->id) }}" method="POST"
                                    enctype="multipart/form-data" style="padding: 20px;">
                                    @csrf @method('PUT')
                                    <div
                                        style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
                                        <p
                                            style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">
                                            🔍 ニッチな評価をシェア（1〜5で選択）</p>
                                        <div style="margin-bottom: 20px;">
                                            <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥
                                                客層</label>
                                            <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                name="customer_vibe" id="mypage_vibe_{{ $review->id }}_{{ $i }}"
                                                value="{{ $i }}" class="rating-radio" {{ $review->customer_vibe == $i ? 'checked' : '' }}><label for="mypage_vibe_{{ $review->id }}_{{ $i }}"
                                            class="rating-label">{{ $i }}</label>@endfor</div>
                                            <div
                                                style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                <span>← ワイワイ</span><span>もくもく作業 →</span>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px;">
                                            <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️
                                                照明</label>
                                            <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                name="eye_fatigue_level" id="mypage_eye_{{ $review->id }}_{{ $i }}"
                                                value="{{ $i }}" class="rating-radio" {{ $review->eye_fatigue_level == $i ? 'checked' : '' }}><label for="mypage_eye_{{ $review->id }}_{{ $i }}"
                                            class="rating-label">{{ $i }}</label>@endfor</div>
                                            <div
                                                style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                <span>← 暗め</span><span>明るい →</span>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px;">
                                            <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑
                                                イス</label>
                                            <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                name="chair_comfort" id="mypage_chair_{{ $review->id }}_{{ $i }}"
                                                value="{{ $i }}" class="rating-radio" {{ $review->chair_comfort == $i ? 'checked' : '' }}><label for="mypage_chair_{{ $review->id }}_{{ $i }}"
                                            class="rating-label">{{ $i }}</label>@endfor</div>
                                            <div
                                                style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                <span>← 硬い</span><span>ふかふか →</span>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 0;">
                                            <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢
                                                机</label>
                                            <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio"
                                                name="desk_stability" id="mypage_desk_{{ $review->id }}_{{ $i }}"
                                                value="{{ $i }}" class="rating-radio" {{ $review->desk_stability == $i ? 'checked' : '' }}><label for="mypage_desk_{{ $review->id }}_{{ $i }}"
                                            class="rating-label">{{ $i }}</label>@endfor</div>
                                            <div
                                                style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;">
                                                <span>← 狭い</span><span>広い →</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                        <div style="flex: 1;"><label
                                                style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">✨
                                                良かった点</label><input type="text" name="good_point" value="{{ $review->good_point }}"
                                                style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                        </div>
                                        <div style="flex: 1;"><label
                                                style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">🤔
                                                気になる点</label><input type="text" name="bad_point" value="{{ $review->bad_point }}"
                                                style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 25px;"><label
                                            style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝
                                            感想</label><textarea name="comment" rows="3"
                                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none;">{{ $review->comment }}</textarea>
                                    </div>
                                    <div style="text-align: center;"><button type="submit"
                                            style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; cursor: pointer; width: 100%;">更新する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 25px; margin-bottom: 50px;">
              {{ $myReviews->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

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