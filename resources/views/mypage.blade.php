@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .mypage-container { max-width: 1000px; margin: 90px auto 40px auto; padding: 0 20px; }
    .user-profile-box { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eee; margin-bottom: 30px; display: flex; align-items: center; gap: 15px; }
    .user-avatar { width: 60px; height: 60px; background-color: #e6f0f9; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 24px; color: #1e8b9b; }
    .user-name { font-size: 20px; font-weight: bold; color: #333; margin: 0; }
    
    .tabs-container { display: flex; gap: 20px; border-bottom: 2px solid #eee; margin-bottom: 25px; }
    .tab-item { font-size: 16px; font-weight: bold; color: #666; padding-bottom: 10px; cursor: pointer; text-decoration: none; position: relative; }
    .tab-item.active { color: #1e8b9b; }
    .tab-item.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 2px; background-color: #1e8b9b; }

    .grid-layout { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
    .spot-mini-card { background: white; border-radius: 8px; border: 1px solid #eee; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; }
    .spot-link { font-size: 16px; font-weight: bold; color: #1e8b9b; text-decoration: none; }
    .spot-link:hover { text-decoration: underline; }

    .review-card-item { background: white; border: 1px solid #eee; border-radius: 8px; padding: 20px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
</style>

<div class="mypage-container">
    
    <div class="user-profile-box">
        <div class="user-avatar">👤</div>
        <div>
            <h1 class="user-name">{{ Auth::user()->name }} さんのマイページ</h1>
            <span style="font-size: 13px; color: #888;">登録日: {{ Auth::user()->created_at->format('Y年m月d日') }}</span>
        </div>
    </div>

    <h2 style="font-size: 18px; color: #333; border-left: 4px solid #1e8b9b; padding-left: 10px; margin-bottom: 20px; margin-top: 40px;">⭐ お気に入り登録したスポット（{{ $myBookmarks->count() }}件）</h2>
    
    @if($myBookmarks->isEmpty())
        <p style="color: #999; background: white; padding: 30px; border-radius: 8px; text-align: center; border: 1px dashed #ccc;">お気に入り登録されたスポットはまだありません。</p>
    @else
        <div class="grid-layout">
            @foreach($myBookmarks as $spot)
                <div class="spot-mini-card">
                    <div>
                        <a href="{{ route('spots.show', $spot->id) }}" class="spot-link">🏢 {{ $spot->name }}</a>
                        <div style="font-size: 13px; color: #666; margin-top: 5px;">📍 エリア：{{ $spot->area }}</div>
                    </div>
                    <div style="margin-top: 15px; display: flex; gap: 10px; font-size: 12px;">
                        @if($spot->has_wifi)<span style="color: #1e8b9b;"><i class="fa-solid fa-wifi"></i> WiFi</span>@endif
                        @if($spot->has_power)<span style="color: #1e8b9b;"><i class="fa-solid fa-plug-circle-bolt"></i> 電源</span>@endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h2 style="font-size: 18px; color: #333; border-left: 4px solid #1e8b9b; padding-left: 10px; margin-bottom: 20px; margin-top: 40px;">💬 自分が投稿したクチコミ一覧（{{ $myReviews->count() }}件）</h2>

    @if($myReviews->isEmpty())
        <p style="color: #999; background: white; padding: 30px; border-radius: 8px; text-align: center; border: 1px dashed #ccc;">投稿したクチコミはまだありません。</p>
    @else
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @foreach($myReviews as $review)
                <div class="review-card-item">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                        <a href="{{ route('spots.show', $review->spot->id) }}" style="font-weight: bold; color: #333; text-decoration: none; font-size: 16px;">🏢 {{ $review->spot->name }} への投稿</a>
                        <span style="font-size: 12px; color: #999;">📅 {{ $review->created_at->format('Y年m月d日') }}</span>
                    </div>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px;">
                        @if($review->customer_vibe)<span style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">👥 客層: {{ $review->customer_vibe }}</span>@endif
                        @if($review->eye_fatigue_level)<span style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">👁️ 照明: {{ $review->eye_fatigue_level }}</span>@endif
                        @if($review->chair_comfort)<span style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">🪑 イス: {{ $review->chair_comfort }}</span>@endif
                        @if($review->desk_stability)<span style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 2px 8px; border-radius: 20px; font-size: 11px; color: #555;">🏢 机: {{ $review->desk_stability }}</span>@endif
                    </div>

                    @if($review->comment)<p style="color: #444; font-size: 14px; line-height: 1.5; white-space: pre-wrap; margin: 0 0 10px 0;">{{ $review->comment }}</p>@endif

                    @if($review->good_point || $review->bad_point)
                        <div style="display: flex; gap: 15px; font-size: 12px; background: #fafafa; padding: 10px; border-radius: 6px; border: 1px dashed #eee;">
                            @if($review->good_point)<div style="color: #e53e3e; font-weight: bold;">👍 Good: <span style="font-weight: normal; color: #555;">{{ $review->good_point }}</span></div>@endif
                            @if($review->bad_point)<div style="color: #3182ce; font-weight: bold;">👎 Bad: <span style="font-weight: normal; color: #555;">{{ $review->bad_point }}</span></div>@endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection