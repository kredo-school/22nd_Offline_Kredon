@extends('layouts.app')

@section('content')
    <div style="background-color: #f8f9fa; min-height: 100vh; padding-bottom: 50px;">

        {{-- 🌟 エラーがあったら赤枠で教えてくれる！ --}}
        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 15px; margin: 20px auto; max-width: 1000px; border-radius: 8px; font-weight: bold; position: relative; z-index: 10;">
                ⚠️ 保存に失敗しました。以下の原因を確認してください：<br>
                <ul style="margin-top: 5px; margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 🌟 1. ヒーローエリア（画像全幅＆文字の重ね合わせ） --}}
        <div style="position: relative; width: 100%; height: 400px; background-color: #333;">
            @if($tourist_spot->photo_path)
                <img src="{{ asset('storage/' . $tourist_spot->photo_path) }}" alt="スポット写真"
                    style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85;">
            @else
                <div style="width: 100%; height: 100%; background-color: #666; display: flex; justify-content: center; align-items: center; color: white;">
                    No Photo</div>
            @endif

            {{-- 上部のボタン群（戻る ＆ 保存） --}}
            <div style="position: absolute; top: 20px; right: 20px; display: flex; gap: 10px;">
                <a href="{{ route('tourist_spots.index') }}"
                    style="background: white; color: #333; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">←
                    戻る</a>

                <form action="{{ route('tourist_bookmarks.toggle', $tourist_spot->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit"
                        style="background: white; color: {{ $tourist_spot->isBookmarkedBy(Auth::user()) ? '#dc2626' : '#333' }}; border: none; padding: 8px 16px; border-radius: 8px; font-weight: bold; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        {{ $tourist_spot->isBookmarkedBy(Auth::user()) ? '❤️ 保存済み' : '🤍 保存' }}
                    </button>
                </form>
            </div>

            {{-- 左下のタイトル＆エリア --}}
            <div style="position: absolute; bottom: 20px; left: 20px; background: rgba(0, 0, 0, 0.6); padding: 20px 25px; border-radius: 12px; color: white; max-width: 80%;">
                <h1 style="margin: 0 0 10px 0; font-size: 28px; font-weight: bold; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
                    {{ $tourist_spot->name }}
                </h1>
                
                {{-- 🌟 視認性を劇的に向上させた星平均点 ＆ クチコミ件数表示 --}}
                <div style="display: flex; align-items: center; gap: 8px; font-size: 15px; margin-bottom: 8px;">
                    @if($tourist_spot->reviews_avg_rating)
                        @php
                            $ratingRound = round($tourist_spot->reviews_avg_rating);
                        @endphp
                        <span style="color: #f0932b; font-weight: bold; font-size: 18px; letter-spacing: 2px;">
                            {{ str_repeat('⭐', $ratingRound) }}
                        </span>
                        <span style="font-weight: bold; font-size: 17px; margin-left: 4px;">
                            {{ number_format($tourist_spot->reviews_avg_rating, 1) }}
                        </span>
                        <span style="color: #ddd; font-size: 13px; margin-left: 4px;">
                            ({{ $tourist_spot->reviews_count }}件のクチコミ)
                        </span>
                    @else
                        <span style="font-size: 13px; color: #ccc;">⭐ まだクチコミはありません</span>
                    @endif
                </div>
                <div style="font-size: 14px; color: #eee; display: flex; align-items: center; gap: 4px;">📍 エリア：{{ $tourist_spot->area }}</div>
            </div>
        </div>

        {{-- 🌟 2. コンテンツエリア（左：体験 / 右：基本情報の2カラムレイアウト） --}}
        <div class="container" style="max-width: 1000px; margin: 30px auto; display: flex; flex-wrap: wrap; gap: 30px; padding: 0 20px;">

            {{-- ■ 左側（メイン情報） --}}
            <div style="flex: 2; min-width: 300px;">
                <h3 style="font-size: 20px; font-weight: bold; color: #007b8f; margin-bottom: 15px; border-bottom: 2px solid #e0e0e0; padding-bottom: 8px;">
                    ここで体験できること</h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 15px; margin-bottom: 30px; text-align: center;">
                    {{-- 遊ぶ --}}
                    <div style="padding: 20px 10px; border-radius: 12px; border: 1px solid {{ $tourist_spot->has_activity ? '#007b8f' : '#eee' }}; color: {{ $tourist_spot->has_activity ? '#007b8f' : '#ccc' }}; font-weight: bold; display: flex; flex-direction: column; gap: 10px;">
                        <i class="fa-solid fa-person-swimming" style="font-size: 28px;"></i><span>遊ぶ</span>
                    </div>
                    {{-- 見る --}}
                    <div style="padding: 20px 10px; border-radius: 12px; border: 1px solid {{ $tourist_spot->has_view ? '#007b8f' : '#eee' }}; color: {{ $tourist_spot->has_view ? '#007b8f' : '#ccc' }}; font-weight: bold; display: flex; flex-direction: column; gap: 10px;">
                        <i class="fa-solid fa-camera" style="font-size: 28px;"></i><span>見る</span>
                    </div>
                    {{-- 買う --}}
                    <div style="padding: 20px 10px; border-radius: 12px; border: 1px solid {{ $tourist_spot->has_shopping ? '#007b8f' : '#eee' }}; color: {{ $tourist_spot->has_shopping ? '#007b8f' : '#ccc' }}; font-weight: bold; display: flex; flex-direction: column; gap: 10px;">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 28px;"></i><span>買う</span>
                    </div>
                    {{-- 食べる --}}
                    <div style="padding: 20px 10px; border-radius: 12px; border: 1px solid {{ $tourist_spot->has_food ? '#007b8f' : '#eee' }}; color: {{ $tourist_spot->has_food ? '#007b8f' : '#ccc' }}; font-weight: bold; display: flex; flex-direction: column; gap: 10px;">
                        <i class="fa-solid fa-utensils" style="font-size: 28px;"></i><span>食べる</span>
                    </div>
                </div>

                <h3 style="font-size: 20px; font-weight: bold; color: #007b8f; margin-bottom: 15px; border-bottom: 2px solid #e0e0e0; padding-bottom: 8px;">
                    スポット概要</h3>
                <p style="line-height: 1.8; color: #444; font-size: 15px;">
                    ここにスポットの詳細な説明文が入ります。波も穏やかで、初心者や家族連れでも安心して楽しめます。
                </p>
            </div>

            {{-- ■ 右側（サイドバー：基本情報） --}}
            <div style="flex: 1; min-width: 250px;">
                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 18px; font-weight: bold; color: #007b8f; margin-bottom: 20px;">基本情報</h3>

                    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 25px;">
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fa-solid fa-wallet" style="color: #007b8f; font-size: 20px; margin-top: 3px;"></i>
                            <div>
                                <div style="font-size: 12px; color: #888;">予算目安</div>
                                <div style="font-weight: bold; color: #333;">{{ $tourist_spot->budget ?? '情報なし' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fa-regular fa-clock" style="color: #007b8f; font-size: 20px; margin-top: 3px;"></i>
                            <div>
                                <div style="font-size: 12px; color: #888;">営業時間</div>
                                <div style="font-weight: bold; color: #333;">{{ $tourist_spot->hours ?? '未定' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fa-solid fa-hourglass-half" style="color: #007b8f; font-size: 20px; margin-top: 3px;"></i>
                            <div>
                                <div style="font-size: 12px; color: #888;">所要時間</div>
                                <div style="font-weight: bold; color: #333;">約 2〜3 時間</div>
                            </div>
                        </div>
                    </div>

                    @if($tourist_spot->booking_url)
                        <a href="{{ $tourist_spot->booking_url }}" target="_blank"
                            style="display: block; text-align: center; background-color: #007b8f; color: white; text-decoration: none; padding: 14px; border-radius: 8px; font-weight: bold; font-size: 15px; transition: 0.3s;">
                            予約サイトを見る
                        </a>
                    @else
                        <button style="display: block; width: 100%; text-align: center; background-color: #ccc; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; font-size: 15px; cursor: not-allowed;" disabled>
                            予約リンクなし
                        </button>
                    @endif
                </div>

                {{-- 管理者（投稿者）用メニュー --}}
                @if(Auth::id() === $tourist_spot->user_id)
                    <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
                        <button onclick="document.getElementById('editTouristSpotModal').classList.add('is-show')"
                            style="background-color: #f0932b; color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: bold;">✏️
                            情報を編集する</button>
                        <form action="{{ route('tourist_spots.destroy', $tourist_spot->id) }}" method="POST"
                            onsubmit="return confirm('本当に削除しますか？');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width: 100%; background-color: #dc3545; color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: bold;">🗑️
                                削除する</button>
                        </form>
                    </div>
                @endif
            </div>
        </div> {{-- 2カラムコンテナの終わり --}}

        {{-- ==========================================================================
             💬 3. クチコミ（レビュー）エリア ＆ 一覧統合セクション
             ========================================================================== --}}
        <div class="container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
            <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="font-size: 20px; font-weight: bold; color: #007b8f; margin-bottom: 20px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">
                    クチコミ・レビュー ({{ $tourist_spot->reviews_count }}件)
                </h3>

                {{-- ✍️ クチコミ投稿フォーム --}}
                <form action="{{ route('tourist_reviews.store', $tourist_spot->id) }}" method="POST"
                    style="margin-bottom: 40px; background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #eee;">
                    @csrf
                    <h4 style="font-size: 15px; font-weight: bold; margin-bottom: 15px; color: #333;">✍️ クチコミを投稿する</h4>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 5px;">評価（星）</label>
                        <select name="rating" required style="width: 100%; max-width: 200px; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            <option value="5">⭐⭐⭐⭐⭐ 5 (最高)</option>
                            <option value="4">⭐⭐⭐⭐ 4 (良い)</option>
                            <option value="3">⭐⭐⭐ 3 (普通)</option>
                            <option value="2">⭐⭐ 2 (いまいち)</option>
                            <option value="1">⭐ 1 (不満)</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 5px;">コメント（任意）</label>
                        <textarea name="comment" rows="3" placeholder="このスポットの感想やおすすめポイントを教えてください！"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;"></textarea>
                    </div>
                    <button type="submit" style="background-color: #f0932b; color: white; border: none; padding: 10px 24px; border-radius: 20px; font-weight: bold; cursor: pointer; font-size: 13px;">投稿する</button>
                </form>

                {{-- 📋 クチコミ一覧表示（コントローラーから渡された $reviews を使ってリッチ化） --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @if($reviews->isEmpty())
                        <p style="color: #888; text-align: center; padding: 30px; border: 1px dashed #ccc; border-radius: 8px; background: #fafafa;">
                            まだクチコミはありません。最初のクチコミを投稿しましょう！
                        </p>
                    @else
                        @foreach($reviews as $review)
                            <div style="border-bottom: 1px solid #f0f0f0; padding-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <div style="font-weight: bold; color: #f0932b; font-size: 14px; letter-spacing: 1px;">
                                        {{ str_repeat('⭐', $review->rating) }}
                                    </div>
                                    <div style="font-size: 12px; color: #999;">
                                        📅 {{ $review->created_at->format('Y/m/d H:i') }}
                                    </div>
                                </div>
                                <div style="font-size: 14px; color: #444; margin-bottom: 12px; line-height: 1.6; white-space: pre-wrap;">{{ $review->comment }}</div>
                                <div style="font-size: 12px; color: #777; display: flex; justify-content: space-between; align-items: center;">
                                    <span>👤 投稿者: {{ $review->user->name }} さん</span>

                                    @if(Auth::id() === $review->user_id)
                                        <form action="{{ route('tourist_reviews.destroy', $review->id) }}" method="POST"
                                            onsubmit="return confirm('本当にこのクチコミを削除しますか？');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #dc3545; font-size: 12px; cursor: pointer; text-decoration: underline; font-weight: bold;">削除する</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div> {{-- クチコミエリアの終わり --}}

    </div> {{-- ページ全体の背景コンテナの終わり --}}


    {{-- ==========================================================================
         ⚙️ 4. 編集用モーダルエリア（壊れていたHTML構造を完全修復）
         ========================================================================== --}}
    @if(Auth::id() === $tourist_spot->user_id)
        <style>
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
        </style>

        <div class="custom-modal" id="editTouristSpotModal">
            <div class="modal-content" style="padding: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                    <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">観光スポットを編集</h2>
                    <button type="button" onclick="document.getElementById('editTouristSpotModal').classList.remove('is-show')"
                        class="close-btn" style="position: static;">×</button>
                </div>

                <form action="{{ route('tourist_spots.update', $tourist_spot->id) }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🌴 観光スポット名</label>
                        <input type="text" name="name" value="{{ old('name', $tourist_spot->name) }}" required
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>

                    <div style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px; background-color: #fff4e6; padding: 15px; border-radius: 8px; border: 1px solid #fbdcb6; justify-content: center;">
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_activity" value="1" {{ old('has_activity', $tourist_spot->has_activity) ? 'checked' : '' }}> 🏊 遊ぶ
                        </label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_view" value="1" {{ old('has_view', $tourist_spot->has_view) ? 'checked' : '' }}> 📷 見る
                        </label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_shopping" value="1" {{ old('has_shopping', $tourist_spot->has_shopping) ? 'checked' : '' }}> 🛍️ 買う
                        </label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_food" value="1" {{ old('has_food', $tourist_spot->has_food) ? 'checked' : '' }}> 🍽️ 食べる
                        </label>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">📍 エリア</label>
                        <select name="area" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="マクタン島" {{ old('area', $tourist_spot->area) == 'マクタン島' ? 'selected' : '' }}>マクタン島</option>
                            <option value="セブ市街" {{ old('area', $tourist_spot->area) == 'セブ市街' ? 'selected' : '' }}>セブ市街</option>
                            <option value="オスロブ・モアルボアル" {{ old('area', $tourist_spot->area) == 'オスロブ・モアルボアル' ? 'selected' : '' }}>オスロブ・モアルボアル</option>
                            <option value="その他（遠方）" {{ old('area', $tourist_spot->area) == 'その他（遠方）' ? 'selected' : '' }}>その他（遠方）</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🕒 営業時間（直接文字で修正）</label>
                        <input type="text" name="hours" value="{{ old('hours', $tourist_spot->hours) }}"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" placeholder="例: 10:00 - 18:00">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">💰 予算目安</label>
                        <input type="text" name="budget" value="{{ old('budget', $tourist_spot->budget) }}"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>

                    {{-- 💡 写真アップロードとプレビューエリア（復元完了） --}}
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">📸 写真を変更（任意）</label>
                        <input type="file" name="photo" onchange="previewImage(this)" style="width: 100%; font-size: 13px;">
                        <div id="imagePreviewContainer" style="display: none; margin-top: 10px;">
                            <img id="photoPreview" src="" alt="プレビュー" style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 6px;">
                        </div>
                    </div>

                    <button type="submit" style="width: 100%; background-color: #f0932b; color: white; border: none; padding: 14px; border-radius: 25px; font-weight: bold; cursor: pointer; font-size: 14px;">
                        変更を保存する
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- ==========================================================================
         ⚙️ 5. JavaScript制御エリア
         ========================================================================== --}}
    <script>
        function previewImage(input) {
            const container = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('photoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('click', function (e) {
                if (e.target.classList.contains('custom-modal')) {
                    e.target.classList.remove('is-show');
                }
            });
        });
    </script>
@endsection