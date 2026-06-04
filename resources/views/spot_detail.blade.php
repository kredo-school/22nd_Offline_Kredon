@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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

        .detail-container { max-width: 800px; margin: 0 auto; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #1e8b9b; text-decoration: none; font-weight: bold; font-size: 14px; }
        .back-link:hover { text-decoration: underline; }
        .detail-card { background-color: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #eee; }
        
        .spot-title { font-size: 24px; font-weight: bold; color: #333; margin: 0; }
        .spot-meta { font-size: 14px; color: #666; margin-bottom: 20px; display: flex; gap: 15px; margin-top: 10px; }
        .spot-photos-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 25px; }
        .photo-item { display: flex; flex-direction: column; align-items: center; }
        .photo-item img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
        .photo-dummy { width: 100%; height: 200px; background-color: #f4f8fb; border-radius: 8px; object-fit: cover; border: 1px dashed #c9d8e4; }
        .photo-label { font-size: 12px; color: #555; font-weight: bold; margin-top: 5px; }
        .avg-panel { background-color: #f4f8fb; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #e6f0f9; display: flex; justify-content: space-around; text-align: center; }
        .avg-item-title { font-size: 13px; color: #666; font-weight: bold; margin-bottom: 8px; }
        .avg-item-score { font-size: 22px; font-weight: bold; color: #1e8b9b; }

        .custom-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); display: none; justify-content: center; align-items: center; z-index: 9999; }
        .custom-modal.is-show { display: flex; }
        .modal-content { background-color: white; padding: 20px; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); }
        .close-btn { position: absolute; top: 15px; right: 15px; font-size: 20px; cursor: pointer; background: none; border: none; color: #888; }
        .rating-group { display: flex; justify-content: space-between; gap: 6px; margin-top: 8px; }
        .rating-radio { display: none; }
        .rating-label { flex: 1; text-align: center; background-color: #f4f8fb; border: 1px solid #c9d8e4; border-radius: 8px; padding: 10px 0; cursor: pointer; font-size: 16px; font-weight: bold; color: #555; transition: all 0.2s ease; }
        .rating-radio:checked+.rating-label { background-color: #1e8b9b; color: white; border-color: #1e8b9b; box-shadow: 0 2px 6px rgba(30, 139, 155, 0.3); }
        
        .file-upload-wrapper { position: relative; overflow: hidden; display: inline-block; width: 100%; }
        .file-upload-btn { background-color: #f4f8fb; border: 2px dashed #4a82b3; color: #4a82b3; padding: 15px; border-radius: 8px; font-weight: bold; text-align: center; display: block; cursor: pointer; transition: 0.2s; }
        .file-upload-btn:hover { background-color: #e6f0f9; }
        .file-upload-input { font-size: 100px; position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; height: 100%; }

        /* 🌟 ブックマークボタンのスタイル */
        .bookmark-btn {
            background: none;
            border: 1px solid #ddd;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .bookmark-btn.active {
            background-color: #fff2e6;
            border-color: #f0932b;
            color: #f0932b;
        }
        .bookmark-btn:hover {
            transform: scale(1.03);
        }
    </style>

    @if (session('success'))
        <div id="flash-message" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #1e8b9b; color: white; padding: 12px 24px; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 10000; transition: opacity 0.5s ease;">
            {{ session('success') }}
        </div>
        <script>setTimeout(() => { const msg = document.getElementById('flash-message'); if (msg) { msg.style.opacity = '0'; setTimeout(() => msg.remove(), 500); } }, 3000);</script>
    @endif

    <div class="container">
        <div class="content-section">
            
            <div class="detail-container">
                <a href="{{ url('/') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> 一覧に戻る</a>

                <div class="detail-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                <h1 class="spot-title">{{ $spot->name }}</h1>
                                
                                <form action="{{ route('bookmarks.toggle', $spot->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @if($spot->isBookmarkedBy(\App\Models\User::first()))
                                        <button type="submit" class="bookmark-btn active">
                                            <i class="fa-solid fa-star"></i> お気に入り中
                                        </button>
                                    @else
                                        <button type="submit" class="bookmark-btn">
                                            <i class="fa-regular fa-star"></i> お気に入りに追加
                                        </button>
                                    @endif
                                </form>
                            </div>

                            <div class="spot-meta">
                                <span>📍 エリア：{{ $spot->area }}</span>
                                <span>🕒 営業時間：{{ $spot->hours ?? '未設定' }}</span>
                            </div>
                            <div style="display: flex; gap: 15px; margin-bottom: 20px; font-weight: bold; color: #333; font-size: 14px;">
                                @if($spot->has_wifi)<span style="color: #1e8b9b;"><i class="fa-solid fa-wifi"></i> WiFi完備</span>@endif
                                @if($spot->has_power)<span style="color: #1e8b9b;"><i class="fa-solid fa-plug-circle-bolt"></i> 電源あり</span>@endif
                            </div>
                        </div>
                        <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.add('is-show')" style="background-color: #f0932b; color: white; border: none; padding: 10px 24px; border-radius: 25px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1); flex-shrink: 0;">
                            ✍️ レビューを書く
                        </button>
                    </div>

                    @php
                        $reviewPhotos = $spot->reviews->whereNotNull('photo_path')->sortByDesc('created_at')->pluck('photo_path')->values();
                    @endphp

                    <div class="spot-photos-grid">
                        <div class="photo-item">
                            @if($spot->photo_path)
                                <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="外観">
                            @else
                                <img src="https://placehold.co/400x300/e6f0f9/4a82b3?text=Main+Photo" class="photo-dummy" alt="写真なし">
                            @endif
                            <span class="photo-label">メイン外観</span>
                        </div>
                        
                        <div class="photo-item">
                            @if(isset($reviewPhotos[0]))
                                <img src="{{ asset('storage/' . $reviewPhotos[0]) }}" alt="みんなの写真1">
                            @else
                                <img src="https://placehold.co/400x300/f4f8fb/c9d8e4?text=User+Photo" class="photo-dummy">
                            @endif
                            <span class="photo-label">みんなの写真①</span>
                        </div>

                        <div class="photo-item">
                            @if(isset($reviewPhotos[1]))
                                <img src="{{ asset('storage/' . $reviewPhotos[1]) }}" alt="みんなの写真2">
                            @else
                                <img src="https://placehold.co/400x300/f4f8fb/c9d8e4?text=User+Photo" class="photo-dummy">
                            @endif
                            <span class="photo-label">みんなの写真②</span>
                        </div>

                        <div class="photo-item">
                            @if(isset($reviewPhotos[2]))
                                <img src="{{ asset('storage/' . $reviewPhotos[2]) }}" alt="みんなの写真3">
                            @else
                                <img src="https://placehold.co/400x300/f4f8fb/c9d8e4?text=User+Photo" class="photo-dummy">
                            @endif
                            <span class="photo-label">みんなの写真③</span>
                        </div>
                    </div>

                   <div class="avg-panel">
                        <div><div class="avg-item-title">👥 客層</div><div class="avg-item-score">{{ $spot->reviews->avg('customer_vibe') ? number_format($spot->reviews->avg('customer_vibe'), 1) : '-' }}</div></div>
                        <div><div class="avg-item-title">👁️ 照明</div><div class="avg-item-score">{{ $spot->reviews->avg('eye_fatigue_level') ? number_format($spot->reviews->avg('eye_fatigue_level'), 1) : '-' }}</div></div>
                        <div><div class="avg-item-title">🪑 イス</div><div class="avg-item-score">{{ $spot->reviews->avg('chair_comfort') ? number_format($spot->reviews->avg('chair_comfort'), 1) : '-' }}</div></div>
                        <div><div class="avg-item-title">🏢 机</div><div class="avg-item-score">{{ $spot->reviews->avg('desk_stability') ? number_format($spot->reviews->avg('desk_stability'), 1) : '-' }}</div></div>
                    </div>

                    <h3 style="font-size: 18px; color: #333; border-bottom: 2px solid #1e8b9b; padding-bottom: 10px; margin-bottom: 15px;">🗺️ アクセスマップ</h3>
                    <div style="width: 100%; height: 350px; border-radius: 8px; overflow: hidden; border: 1px solid #eee; margin-bottom: 30px;">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            loading="lazy" 
                            allowfullscreen 
                            src="https://maps.google.com/maps?q={{ urlencode($spot->name . ' ' . $spot->area . ' Cebu') }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                        </iframe>
                    </div>
                    <h3 style="font-size: 18px; color: #333; border-bottom: 2px solid #1e8b9b; padding-bottom: 10px; margin-bottom: 20px;">💬 みんなのリアルな感想・クチコミ（{{ $spot->reviews->count() }}件）</h3>
                    
                    @if($spot->reviews->isEmpty())
                        <p style="color: #999; text-align: center; padding: 20px 0;">まだ感想が投稿されていません。最初の発見者になりましょう！</p>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            @foreach($spot->reviews()->latest()->get() as $review)
                                <div style="background-color: #fafafa; border: 1px solid #eee; border-radius: 8px; padding: 20px;">
                                    <div style="font-size: 12px; color: #999; text-align: right; margin-bottom: 10px;">📅 {{ $review->created_at->format('Y年m月d日 H:i') }}</div>
                                    
                                    @if($review->photo_path)
                                        <div style="margin-bottom: 15px; text-align: center;">
                                            <img src="{{ asset('storage/' . $review->photo_path) }}" alt="レビュー写真" style="max-width: 100%; max-height: 300px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                                        </div>
                                    @endif

                                    @if($review->comment)<div style="color: #333; line-height: 1.6; margin-bottom: 15px; font-size: 15px; white-space: pre-wrap;">{{ $review->comment }}</div>@endif
                                    @if($review->good_point || $review->bad_point)
                                        <div style="display: flex; gap: 15px; font-size: 13px; background: white; padding: 12px; border-radius: 6px; border: 1px dashed #ccc;">
                                            @if($review->good_point)<div style="flex: 1; color: #e53e3e; font-weight: bold;">👍 Good: <span style="font-weight: normal; color: #555;">{{ $review->good_point }}</span></div>@endif
                                            @if($review->bad_point)<div style="flex: 1; color: #3182ce; font-weight: bold;">👎 Bad: <span style="font-weight: normal; color: #555;">{{ $review->bad_point }}</span></div>@endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="custom-modal" id="reviewModal-{{ $spot->id }}">
        <div class="modal-content" style="padding: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">レビュー・最新情報を投稿</h2>
                <button onclick="document.getElementById('reviewModal-{{ $spot->id }}').classList.remove('is-show')" class="close-btn" style="position: static;">×</button>
            </div>
            
            <form action="{{ route('reviews.store', $spot->id) }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸 席の様子やメニューの写真（任意）</label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-btn">
                            <i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>
                            写真を選択（またはドラッグ＆ドロップ）
                        </div>
                        <input type="file" name="photo" class="file-upload-input" accept="image/*">
                    </div>
                </div>

                <div style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
                    <p style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">🔍 ニッチな評価をシェア</p>
                    <div style="margin-bottom: 15px;"><label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥 客層</label><div class="rating-group">@for($i=1;$i<=5;$i++)<input type="radio" name="customer_vibe" id="vibe_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="vibe_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div></div>
                    <div style="margin-bottom: 15px;"><label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️ 照明</label><div class="rating-group">@for($i=1;$i<=5;$i++)<input type="radio" name="eye_fatigue_level" id="eye_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="eye_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div></div>
                    <div style="margin-bottom: 15px;"><label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑 イス</label><div class="rating-group">@for($i=1;$i<=5;$i++)<input type="radio" name="chair_comfort" id="chair_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="chair_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div></div>
                    <div style="margin-bottom: 0;"><label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢 机</label><div class="rating-group">@for($i=1;$i<=5;$i++)<input type="radio" name="desk_stability" id="desk_{{ $spot->id }}_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="desk_{{ $spot->id }}_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div></div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;"><label style="display: block; font-size: 12px; font-weight: bold; color: #e53e3e; margin-bottom: 5px;">👍 Goodポイント</label><input type="text" name="good_point" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;"></div>
                    <div style="flex: 1;"><label style="display: block; font-size: 12px; font-weight: bold; color: #3182ce; margin-bottom: 5px;">👎 Badポイント</label><input type="text" name="bad_point" style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #ddd; border-radius: 6px;"></div>
                </div>
                <div style="margin-bottom: 25px;"><label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📝 リアルな感想・最新状況</label><textarea name="comment" rows="3" style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; resize: none;"></textarea></div>
                <div style="text-align: center;"><button type="submit" style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">シェアする</button></div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('click', function (e) {
                if (e.target.classList.contains('custom-modal')) { e.target.classList.remove('is-show'); }
            });
            
            const fileInput = document.querySelector('.file-upload-input');
            const fileLabel = document.querySelector('.file-upload-btn');
            if(fileInput && fileLabel) {
                fileInput.addEventListener('change', function(e) {
                    if(e.target.files.length > 0) {
                        fileLabel.innerHTML = '<i class="fa-solid fa-check" style="font-size: 24px; margin-bottom: 5px; display: block; color: #297a6a;"></i>画像を選択しました！';
                        fileLabel.style.borderColor = '#297a6a';
                        fileLabel.style.color = '#297a6a';
                    }
                });
            }
        });
    </script>
@endsection