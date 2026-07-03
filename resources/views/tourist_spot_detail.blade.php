@extends('layouts.app')

@section('content')
    {{-- 📱 スマホ対応＆プロフェッショナルUIのCSS --}}
    <style>
        html {
            scroll-behavior: smooth;
        }

        /* ホバー時のフワッと浮き上がるアニメーション（プロっぽさの演出） */
        .hover-lift {
            transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* 追従するサイドバー（スクロールしても予約ボタンが常に見える） */
        .sticky-sidebar {
            position: sticky;
            top: 90px;
            /* ヘッダーの高さに合わせて調整 */
            align-self: flex-start;
        }

        /* サムネイル画像の選択エフェクト */
        .gallery-thumb {
            transition: all 0.2s ease;
            opacity: 0.6;
        }

        .gallery-thumb:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        /* ==========================================
                           🌟 追加：モーダルウィンドウの制御CSS
                        ========================================== */
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            z-index: 9999;
            /* 👇 ここがポイント！Flexboxの中央寄せをやめて、全体をスクロール可能に */
            overflow-y: auto;
            padding: 40px 15px;
            box-sizing: border-box;
        }

        .custom-modal.is-show {
            display: block !important;
            /* 画面いっぱいの時は flex ではなく block が最強です */
        }

        .modal-content {
            background-color: white;
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            /* これで左右中央に配置されます */
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            /* もし max-height: 90vh; みたいな記述があれば消してOKです */
        }

        /* 🌟 モーダルのフォーム部分（ここでスクロールさせる） */
        .modal-body {
            overflow-y: auto;
            padding: 20px;
        }

        /* 閉じる（×）ボタンのスタイル */
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #334155;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {

            /* ヒーローエリア（上部画像）をスマホサイズに縮小 */
            .hero-section {
                height: 320px !important;
            }

            .hero-title-box {
                bottom: 10px !important;
                left: 10px !important;
                padding: 15px !important;
                width: 95% !important;
                max-width: 100% !important;
                box-sizing: border-box;
            }

            .hero-title-box h1 {
                font-size: 22px !important;
                margin-bottom: 5px !important;
            }

            .hero-title-box .rating-text {
                font-size: 14px !important;
            }

            /* 2カラムレイアウトを縦積みに変更 */
            .content-container {
                flex-direction: column !important;
                gap: 20px !important;
                margin-top: 15px !important;
            }

            .main-info,
            .side-info {
                width: 100% !important;
                min-width: 100% !important;
            }

            .sticky-sidebar {
                position: static !important;
            }

            /* スマホでは追従を解除 */

            /* 体験タグ（遊ぶ、見るなど）をスマホでは2列×2行で綺麗に並べる */
            .experience-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
                margin-bottom: 20px !important;
            }

            .experience-grid div {
                padding: 15px 5px !important;
            }

            /* モーダル（編集画面）のスマホ最適化 */
            .modal-content {
                width: 95% !important;
                padding: 15px !important;
            }

            .checkbox-group {
                gap: 10px !important;
            }

            .checkbox-group label {
                font-size: 13px !important;
            }
        }
    </style>

    {{-- 🌟 魔法のCSS：クリックした時にスルスル～っと下へスクロールさせる --}}
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>

    <div style="background-color: #f8f9fa; min-height: 100vh; padding-bottom: 50px;">

        {{-- 🌟 エラーメッセージ表示 --}}
        @if ($errors->any())
            <div
                style="background-color: #fee2e2; color: #b91c1c; padding: 15px; margin: 20px auto; max-width: 1100px; border-radius: 8px; font-weight: bold; position: relative; z-index: 10;">
                ⚠️ 保存に失敗しました。以下の原因を確認してください：<br>
                <ul style="margin-top: 5px; margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 🌟 1. ヒーローエリア（プロ仕様・ダイナミックギャラリー） --}}
        <div style="max-width: 1100px; margin: 20px auto 0; padding: 0 20px;">
            <div class="hero-section"
                style="position: relative; width: 100%; height: 500px; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15); background-color: #111;">

                {{-- メイン画像 --}}
                @if($tourist_spot->photo_path)
                    <img id="mainTouristImage" src="{{ asset('storage/' . $tourist_spot->photo_path) }}"
                        alt="{{ $tourist_spot->name }}"
                        style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.3s ease;">
                @else
                    <div id="mainTouristImage"
                        style="width: 100%; height: 100%; background-color: #444; display: flex; justify-content: center; align-items: center; color: white;">
                        No Photo
                    </div>
                @endif
                {{-- 下から上へのグラデーション --}}
                <div
                    style="position: absolute; bottom: 0; left: 0; width: 100%; height: 60%; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%); pointer-events: none;">
                </div>

                {{-- 上部のボタン群（戻る ＆ 保存） --}}
                <div style="position: absolute; top: 20px; right: 20px; display: flex; gap: 10px; z-index: 2;">
                    <a href="{{ route('tourist_spots.index') }}" class="hover-lift"
                        style="background: rgba(255,255,255,0.9); color: #333; padding: 10px 18px; border-radius: 30px; text-decoration: none; font-weight: bold; backdrop-filter: blur(5px);">
                        <i class="fa-solid fa-chevron-left"></i> 戻る
                    </a>

                    <form action="{{ route('tourist_bookmarks.toggle', $tourist_spot->id) }}" method="POST"
                        style="margin: 0;">
                        @csrf
                        <button type="submit" class="hover-lift"
                            style="background: rgba(255,255,255,0.9); color: {{ $tourist_spot->isBookmarkedBy(Auth::user()) ? '#dc2626' : '#333' }}; border: none; padding: 10px 20px; border-radius: 30px; font-weight: bold; cursor: pointer; backdrop-filter: blur(5px);">
                            {!! $tourist_spot->isBookmarkedBy(Auth::user()) ? '<i class="fa-solid fa-heart"></i> 保存済み' : '<i class="fa-regular fa-heart"></i> 保存' !!}
                        </button>
                    </form>
                </div>

                {{-- 左下のタイトル＆エリア --}}
                <div class="hero-title-box"
                    style="position: absolute; bottom: 30px; left: 40px; color: white; max-width: 80%; z-index: 2;">
                    <h1
                        style="margin: 0 0 12px 0; font-size: 36px; font-weight: 900; text-shadow: 0 2px 10px rgba(0,0,0,0.5); letter-spacing: 1px;">
                        {{ $tourist_spot->name }}
                    </h1>

                    <div style="display: flex; align-items: center; gap: 12px; font-size: 15px; margin-bottom: 8px;">
                        @if($tourist_spot->reviews_avg_rating)
                            @php $ratingRound = round($tourist_spot->reviews_avg_rating); @endphp
                            <span
                                style="color: #f0932b; font-weight: bold; font-size: 20px; letter-spacing: 2px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                                {{ str_repeat('⭐', $ratingRound) }}
                            </span>
                            <span class="rating-text"
                                style="font-weight: bold; font-size: 18px; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                                {{ number_format($tourist_spot->reviews_avg_rating, 1) }}
                            </span>
                            {{-- 👇 修正ポイント：spanタグからaタグに変更し、href属性を追加しました！ --}}
                            <a href="#reviews-section" class="rating-text hover-lift"
                                style="color: #ddd; font-size: 14px; text-decoration: underline; cursor: pointer; transition: 0.2s;">
                                ({{ $tourist_spot->reviews_count }}件のクチコミ)
                            </a>
                        @else
                            <span
                                style="font-size: 14px; color: #ddd; background: rgba(0,0,0,0.4); padding: 4px 10px; border-radius: 20px;">⭐
                                まだクチコミはありません</span>
                        @endif
                    </div>
                    <div
                        style="font-size: 15px; color: #fff; display: flex; align-items: center; gap: 6px; font-weight: bold;">
                        <i class="fa-solid fa-location-dot" style="color: #f0932b;"></i> エリア：{{ $tourist_spot->area }}
                    </div>
                </div>
            </div>

            {{-- 📸 サムネイル・ギャラリー --}}
            @if($tourist_spot->photos && $tourist_spot->photos->count() > 0)
                <div style="display: flex; gap: 10px; margin-top: 15px; overflow-x: auto; padding-bottom: 10px;">
                    @if($tourist_spot->photo_path)
                        <img src="{{ asset('storage/' . $tourist_spot->photo_path) }}" class="gallery-thumb"
                            onclick="document.getElementById('mainTouristImage').src=this.src; document.querySelectorAll('.gallery-thumb').forEach(el=>el.style.opacity='0.6'); this.style.opacity='1';"
                            style="flex-shrink: 0; width: 90px; height: 70px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); opacity: 1;">
                    @endif
                    @foreach($tourist_spot->photos as $photo)
                        @if($photo->photo_path !== $tourist_spot->photo_path)
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" class="gallery-thumb"
                                onclick="document.getElementById('mainTouristImage').src=this.src; document.querySelectorAll('.gallery-thumb').forEach(el=>el.style.opacity='0.6'); this.style.opacity='1';"
                                style="flex-shrink: 0; width: 90px; height: 70px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 🌟 2. コンテンツエリア --}}
        <div class="container content-container"
            style="max-width: 1100px; margin: 30px auto; display: flex; flex-wrap: wrap; gap: 40px; padding: 0 20px;">

            {{-- ■ 左側（メイン情報） --}}
            <div class="main-info" style="flex: 2; min-width: 300px;">
                <h3 style="font-size: 22px; font-weight: 900; color: #2d3748; margin-bottom: 20px;">
                    ここで体験できること
                </h3>

                <div class="experience-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 15px; margin-bottom: 40px; text-align: center;">
                    <div class="hover-lift"
                        style="padding: 25px 10px; background: white; border-radius: 16px; border: 2px solid {{ $tourist_spot->has_activity ? '#007b8f' : '#f1f5f9' }}; color: {{ $tourist_spot->has_activity ? '#007b8f' : '#cbd5e1' }}; font-weight: bold; display: flex; flex-direction: column; gap: 12px;">
                        <i class="fa-solid fa-person-swimming" style="font-size: 32px;"></i><span
                            style="font-size: 15px;">遊ぶ</span>
                    </div>
                    <div class="hover-lift"
                        style="padding: 25px 10px; background: white; border-radius: 16px; border: 2px solid {{ $tourist_spot->has_view ? '#007b8f' : '#f1f5f9' }}; color: {{ $tourist_spot->has_view ? '#007b8f' : '#cbd5e1' }}; font-weight: bold; display: flex; flex-direction: column; gap: 12px;">
                        <i class="fa-solid fa-camera" style="font-size: 32px;"></i><span style="font-size: 15px;">見る</span>
                    </div>
                    <div class="hover-lift"
                        style="padding: 25px 10px; background: white; border-radius: 16px; border: 2px solid {{ $tourist_spot->has_shopping ? '#007b8f' : '#f1f5f9' }}; color: {{ $tourist_spot->has_shopping ? '#007b8f' : '#cbd5e1' }}; font-weight: bold; display: flex; flex-direction: column; gap: 12px;">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 32px;"></i><span
                            style="font-size: 15px;">買う</span>
                    </div>
                    <div class="hover-lift"
                        style="padding: 25px 10px; background: white; border-radius: 16px; border: 2px solid {{ $tourist_spot->has_food ? '#007b8f' : '#f1f5f9' }}; color: {{ $tourist_spot->has_food ? '#007b8f' : '#cbd5e1' }}; font-weight: bold; display: flex; flex-direction: column; gap: 12px;">
                        <i class="fa-solid fa-utensils" style="font-size: 32px;"></i><span
                            style="font-size: 15px;">食べる</span>
                    </div>
                </div>

                <h3 style="font-size: 22px; font-weight: 900; color: #2d3748; margin-bottom: 15px;">
                    スポット概要
                </h3>
                <div
                    style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #eee; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <p style="line-height: 1.9; color: #4a5568; font-size: 16px; margin: 0; white-space: pre-wrap;">
                        {{ $tourist_spot->description ?? '概要はまだ入力されていません。' }}</p>
                </div>

                {{-- 💬 3. クチコミ（レビュー）エリア --}}
                <div id="reviews-section" style="margin-top: 50px;">
                    <h3
                        style="font-size: 22px; font-weight: 900; color: #2d3748; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-regular fa-comments"></i> リアルな体験談 ({{ $tourist_spot->reviews_count }}件)
                    </h3>

                    {{-- クチコミ投稿フォーム --}}
                    <form action="{{ route('tourist_reviews.store', $tourist_spot->id) }}" method="POST"
                        style="margin-bottom: 40px; background: white; padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; font-size: 14px; font-weight: bold; color: #4a5568; margin-bottom: 8px;">このスポットの評価</label>
                            <select name="rating" required
                                style="width: 100%; max-width: 250px; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; background-color: #f8fafc;">
                                <option value="5">⭐⭐⭐⭐⭐ 5 (最高！)</option>
                                <option value="4">⭐⭐⭐⭐ 4 (良かった)</option>
                                <option value="3">⭐⭐⭐ 3 (普通)</option>
                                <option value="2">⭐⭐ 2 (いまいち)</option>
                                <option value="1">⭐ 1 (不満)</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; font-size: 14px; font-weight: bold; color: #4a5568; margin-bottom: 8px;">体験した感想</label>
                            <textarea name="comment" rows="3" placeholder="現地のリアルな雰囲気や、おすすめの楽しみ方をシェアしてください！"
                                style="width: 100%; box-sizing: border-box; padding: 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; resize: vertical; background-color: #f8fafc;"></textarea>
                        </div>
                        <button type="submit" class="hover-lift"
                            style="background-color: #007b8f; color: white; border: none; padding: 12px 30px; border-radius: 30px; font-weight: bold; cursor: pointer; font-size: 15px;">クチコミを投稿する</button>
                    </form>

                    {{-- クチコミ一覧表示 --}}
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @if($reviews->isEmpty())
                            <div
                                style="text-align: center; padding: 40px; border: 2px dashed #cbd5e1; border-radius: 16px; background: white;">
                                <i class="fa-regular fa-face-smile"
                                    style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                <p style="color: #64748b; font-weight: bold; font-size: 15px; margin: 0;">
                                    まだクチコミはありません。<br>あなたの体験が最初のガイドになります！</p>
                            </div>
                        @else
                            @foreach($reviews as $review)
                                <div
                                    style="background: white; border-radius: 16px; padding: 25px; border: 1px solid #f1f5f9; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                        <div style="font-weight: bold; color: #f0932b; font-size: 16px; letter-spacing: 1px;">
                                            {{ str_repeat('⭐', $review->rating) }}
                                        </div>
                                        <div style="font-size: 13px; color: #94a3b8; font-weight: 500;">
                                            {{ $review->created_at->format('Y年n月j日') }}
                                        </div>
                                    </div>
                                    <div
                                        style="font-size: 15px; color: #334155; margin-bottom: 20px; line-height: 1.8; white-space: pre-wrap;">
                                        {{ $review->comment }}
                                    </div>

                                    <div
                                        style="border-top: 1px solid #f1f5f9; padding-top: 15px; font-size: 13px; color: #64748b; display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-weight: bold;">
                                            <div
                                                style="width: 24px; height: 24px; background: #e2e8f0; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-right: 6px; color: #94a3b8;">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                            {{ $review->user->name }}
                                        </span>

                                        @if(Auth::id() === $review->user_id)
                                            <form action="{{ route('tourist_reviews.destroy', $review->id) }}" method="POST"
                                                onsubmit="return confirm('本当にこのクチコミを削除しますか？');" style="margin: 0;">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    style="background: none; border: none; color: #ef4444; font-size: 13px; cursor: pointer; font-weight: bold;"><i
                                                        class="fa-solid fa-trash-can"></i> 削除</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- ■ 右側（追従するサイドバー：基本情報） --}}
            <div class="side-info sticky-sidebar" style="flex: 1; min-width: 300px;">
                <div
                    style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #f1f5f9;">
                    <h3
                        style="font-size: 18px; font-weight: 900; color: #1e293b; margin-bottom: 25px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-info" style="color: #007b8f;"></i> 基本情報
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px;">
                        <div
                            style="display: flex; gap: 15px; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px dashed #e2e8f0;">
                            <i class="fa-solid fa-wallet" style="color: #64748b; font-size: 20px; margin-top: 2px;"></i>
                            <div>
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;">予算目安</div>
                                <div style="font-weight: 900; color: #334155; font-size: 16px;">
                                    {{ $tourist_spot->budget ?? '情報なし' }}
                                </div>
                            </div>
                        </div>
                        <div
                            style="display: flex; gap: 15px; align-items: flex-start; padding-bottom: 15px; border-bottom: 1px dashed #e2e8f0;">
                            <i class="fa-regular fa-clock" style="color: #64748b; font-size: 20px; margin-top: 2px;"></i>
                            <div>
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;">営業時間</div>
                                <div style="font-weight: 900; color: #334155; font-size: 16px;">
                                    {{ $tourist_spot->hours ?? '未定' }}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fa-solid fa-hourglass-half"
                                style="color: #64748b; font-size: 20px; margin-top: 2px;"></i>
                            <div>
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;">所要時間</div>
                                <div style="font-weight: 900; color: #334155; font-size: 16px;">約 2〜3 時間</div>
                            </div>
                        </div>
                    </div>

                    @if($tourist_spot->booking_url)
                        <a href="{{ $tourist_spot->booking_url }}" target="_blank" class="hover-lift"
                            style="display: block; text-align: center; background: linear-gradient(135deg, #007b8f 0%, #005f6e 100%); color: white; text-decoration: none; padding: 16px; border-radius: 12px; font-weight: bold; font-size: 16px;">
                            予約サイトへ進む <i class="fa-solid fa-arrow-up-right-from-square"
                                style="font-size: 13px; margin-left: 4px;"></i>
                        </a>
                    @else
                        <button
                            style="display: block; width: 100%; text-align: center; background-color: #f1f5f9; color: #94a3b8; border: none; padding: 16px; border-radius: 12px; font-weight: bold; font-size: 16px; cursor: not-allowed;"
                            disabled>
                            予約リンクなし
                        </button>
                    @endif
                </div>

                {{-- 管理者（投稿者）用メニュー --}}
                @if(Auth::id() === $tourist_spot->user_id)
                    <div
                        style="margin-top: 25px; padding: 20px; background: #fff4e6; border-radius: 16px; border: 1px dashed #fbdcb6;">
                        <p style="font-size: 13px; font-weight: bold; color: #f0932b; margin: 0 0 15px 0; text-align: center;">
                            <i class="fa-solid fa-gear"></i> 管理メニュー
                        </p>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <button onclick="document.getElementById('editTouristSpotModal').classList.add('is-show')" ...>

                                <button onclick="document.getElementById('editTouristSpotModal').classList.add('is-show')"
                                    class="hover-lift"
                                    style="background-color: white; color: #f0932b; border: 2px solid #f0932b; padding: 12px; border-radius: 10px; cursor: pointer; font-weight: bold;">✏️
                                    情報を編集する
                                </button>
                                <form action="{{ route('tourist_spots.destroy', $tourist_spot->id) }}" method="POST"
                                    onsubmit="return confirm('本当に削除しますか？');" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="hover-lift"
                                        style="width: 100%; background-color: white; color: #ef4444; border: 2px solid #ef4444; padding: 12px; border-radius: 10px; cursor: pointer; font-weight: bold;">🗑️
                                        削除する</button>
                                </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- ==========================================================================
    ⚙️ 4. 編集用モーダルエリア（CSSを適用し初期状態は非表示に）
    ========================================================================== --}}
    @if(Auth::id() === $tourist_spot->user_id)
        <div class="custom-modal" id="editTouristSpotModal">
            <div class="modal-content" style="padding: 0;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
                    <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">観光スポットを編集</h2>
                    <button type="button" onclick="document.getElementById('editTouristSpotModal').classList.remove('is-show')"
                        class="close-btn" style="position: static;">&times;</button>
                </div>

                <form action="{{ route('tourist_spots.update', $tourist_spot->id) }}" method="POST"
                    enctype="multipart/form-data" style="padding: 20px;">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🌴
                            観光スポット名</label>
                        <input type="text" name="name" value="{{ old('name', $tourist_spot->name) }}" required
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>

                    <div class="checkbox-group"
                        style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px; background-color: #fff4e6; padding: 15px; border-radius: 8px; border: 1px solid #fbdcb6; justify-content: center;">
                        <label
                            style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_activity" value="1" {{ old('has_activity', $tourist_spot->has_activity) ? 'checked' : '' }}> 🏊 遊ぶ
                        </label>
                        <label
                            style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_view" value="1" {{ old('has_view', $tourist_spot->has_view) ? 'checked' : '' }}> 📷 見る
                        </label>
                        <label
                            style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_shopping" value="1" {{ old('has_shopping', $tourist_spot->has_shopping) ? 'checked' : '' }}> 🛍️ 買う
                        </label>
                        <label
                            style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                            <input type="checkbox" name="has_food" value="1" {{ old('has_food', $tourist_spot->has_food) ? 'checked' : '' }}> 🍽️ 食べる
                        </label>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">📍
                            エリア</label>
                        <select name="area" required
                            style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="セブ島" {{ old('area', $tourist_spot->area) == 'セブ島' ? 'selected' : '' }}>セブ島</option>
                            <option value="離島" {{ old('area', $tourist_spot->area) == '離島' ? 'selected' : '' }}>離島</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🕒
                            営業時間（直接文字で修正）</label>
                        <input type="text" name="hours" value="{{ old('hours', $tourist_spot->hours) }}"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px;"
                            placeholder="例: 10:00 - 18:00">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">💰
                            予算目安</label>
                        <input type="text" name="budget" value="{{ old('budget', $tourist_spot->budget) }}"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🔗
                            予約リンク (URL)</label>
                        <input type="url" name="booking_url" value="{{ old('booking_url', $tourist_spot->booking_url) }}"
                            style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px;"
                            placeholder="例: https://...">
                    </div>
                    {{-- ✍️ スポットの感想・おすすめポイント（統一のための追加部分） --}}
                    <div style="margin-bottom: 20px;">
                        <label
                            style="font-size: 13px; font-weight: bold; color: #666; display: flex; align-items: center; gap: 5px;">
                            ✍️ スポットの感想・おすすめポイント（任意）
                        </label>
                        <textarea name="description" rows="4"
                            style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; margin-top: 8px; font-size: 14px; box-sizing: border-box; resize: vertical;"
                            placeholder="例：夕日が見える席が最高でした！静かで集中できます。">{{ old('description', $tourist_spot->description) }}</textarea>
                    </div>
                    {{-- 👑 トップ画像（メイン）の選択 ＆ 削除 --}}
                    <div style="margin-bottom: 20px;">
                        <label
                            style="font-size: 13px; font-weight: bold; color: #666; display: flex; align-items: center; gap: 5px;">
                            👑 トップ画像（メイン）の選択 & 削除
                        </label>
                        <div
                            style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-top: 8px;">
                            <div id="photo-container" style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px;">

                                {{-- ① 現在のメイン画像 --}}
                                @if($tourist_spot->photo_path)
                                    <div class="photo-item"
                                        style="border: 1px solid #ddd; padding: 10px; border-radius: 8px; background: white; text-align: center; min-width: 100px;">
                                        <img src="{{ asset('storage/' . $tourist_spot->photo_path) }}"
                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; margin-bottom: 8px;">
                                        <div>
                                            <label style="font-size: 12px; cursor: pointer;">
                                                <input type="radio" name="main_photo" value="current_main" checked> メイン
                                            </label>
                                        </div>
                                        <div>
                                            <label style="font-size: 12px; color: #dc2626; cursor: pointer;">
                                                <input type="checkbox" name="delete_main_photo" value="1"> 削除
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                {{-- ② ギャラリー画像（追加された複数写真） --}}
                                @foreach($tourist_spot->photos as $photo)
                                    <div class="photo-item"
                                        style="border: 1px solid #ddd; padding: 10px; border-radius: 8px; background: white; text-align: center; min-width: 100px;">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}"
                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; margin-bottom: 8px;">
                                        <div>
                                            <label style="font-size: 12px; cursor: pointer;">
                                                <input type="radio" name="main_photo" value="{{ $photo->id }}"> メイン
                                            </label>
                                        </div>
                                        <div>
                                            <label style="font-size: 12px; color: #dc2626; cursor: pointer;">
                                                <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}"> 削除
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    {{-- 📸 写真をさらに追加する --}}
                    <div style="margin-bottom: 20px;">
                        <label
                            style="font-size: 13px; font-weight: bold; color: #666; display: flex; align-items: center; gap: 5px;">
                            📸 写真をさらに追加する（複数選択可）
                        </label>
                        <input type="file" name="photos[]" multiple
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 8px; background: white;">
                        <p style="font-size: 11px; color: #888; margin-top: 5px;">※Ctrlキー（MacはCommandキー）を押しながらで複数枚選択できます</p>
                    </div>

                    <button type="submit"
                        style="width: 100%; background-color: #f0932b; color: white; border: none; padding: 14px; border-radius: 25px; font-weight: bold; cursor: pointer; font-size: 14px;">
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
    <script>
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement.tagName === 'TEXTAREA' || activeElement.tagName === 'BUTTON' || activeElement.type === 'submit') {
                    return;
                }
                e.preventDefault();
                const form = activeElement.closest('form');
                if (!form) return;
                const focusableElements = Array.from(
                    form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled]), button[type="submit"]')
                );
                const currentIndex = focusableElements.indexOf(activeElement);
                if (currentIndex > -1 && currentIndex < focusableElements.length - 1) {
                    focusableElements[currentIndex + 1].focus();
                }
            }
        });
    </script>
@endsection