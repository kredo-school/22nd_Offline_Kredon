@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KREDON - スポット検索</title>
    <style>
        /* --- 基本レイアウト --- */
        .spot-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .spot-card {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        .spot-card-header {
            margin-bottom: 10px;
        }

        .spot-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        .spot-hours {
            font-size: 12px;
            color: #666;
        }

        .spot-photo-section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .spot-photos-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 15px;
        }

        .photo-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-dummy {
            width: 100%;
            height: 70px;
            background-color: #d8c3b4;
            /* 元ネタっぽい色 */
            border-radius: 6px;
            margin-bottom: 4px;
            object-fit: cover;
        }

        .photo-label {
            font-size: 11px;
            color: #555;
            font-weight: bold;
        }

        .spot-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
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
            color: #555;
            font-size: 14px;
        }

        .spot-map-link {
            font-size: 12px;
            color: #297a6a;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .spot-map-link:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .content-section {
            width: 100%;
            padding: 20px;
            overflow-y: scroll;
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

        /* --- ポップアップ（モーダル）の見た目 --- */
        .map-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            /* 背景を少し暗めに調整 */
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        /* このクラスがついた時だけ表示させる */
        .map-modal.is-show {
            display: flex;
        }

        /* ポップアップの中身の白い箱 */
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            position: relative;
        }

        /* マップに見立てたグレーの箱 */
        .dummy-map {
            width: 100%;
            height: 350px;
            background-color: #eee;
            margin-top: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* 閉じるボタンのスタイル */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="content-section">

            <div class="title-area" style="margin-bottom: 25px;">
                <h2 class="app-title">セブ島の学習スポットを探す</h2>
            </div>

            <div class="filter-options">
                <div class="filter-title">設備で絞り込む（最優先）</div>
                <div class="switch-container">
                    <input type="checkbox" id="wifiToggle" class="toggle-input">
                    <label for="wifiToggle" class="toggle-label">
                        <i class="fa-solid fa-wifi" style="margin-right: 6px;"></i>WIFI
                    </label>

                    <input type="checkbox" id="powerToggle" class="toggle-input">
                    <label for="powerToggle" class="toggle-label">
                        <i class="fa-solid fa-plug-circle-bolt" style="margin-right: 6px;"></i>コンセント
                    </label>
                </div>
            </div>

            <div class="filter-options">
                <div class="filter-title">エリアで絞り込む</div>

                <div class="search-row">
                    <select name="area" class="area-select">
                        <option value="">-- エリアを選択 --</option>
                        <option value="it-east">ITパーク・東</option>
                        <option value="it-west">ITパーク・西</option>
                        <option value="it-south">ITパーク・南</option>
                        <option value="it-north">ITパーク・北</option>
                        <option value="ayala">アヤラ周辺</option>
                        <option value="lahug">ラホグ</option>
                        <option value="mabolo">マボロ</option>
                        <option value="others">その他</option>
                    </select>

                    <button type="submit" class="search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i> 検索する
                    </button>
                </div>
            </div>

            <div class="filter-options">

            </div>


            <div class="spot-card">
                @foreach($spots as $spot)
                    <div class="spot-card-header">
                        <span class="spot-name">店名：{{ $spot->name }}</span>
                        <div class="spot-hours">営業時間：{{ $spot->hours }}</div>
                    </div>

                    <div class="spot-photo-section-title">写真</div>
                    <div class="spot-photos-grid">
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="外観">
                            <span class="photo-label">外観</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="内観">
                            <span class="photo-label">内観</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="メニュー表">
                            <span class="photo-label">メニュー表</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy" alt="食べたもの">
                            <span class="photo-label">食べたもの</span>
                        </div>
                    </div>

                    <div class="spot-area" style="padding: 10px; color: #666;">
                        エリア：{{ $spot->area }}
                    </div>

                    <div class="spot-card-footer"
                        style="margin-bottom: 30px; border-bottom: 1px dashed #ccc; padding-bottom: 20px;">
                        <div class="spot-facilities" style="padding: 10px; font-size: 14px;">
                            設備：
                            @if($spot->has_wifi)
                                <span class="amenity-item" style="margin-right: 10px;">
                                    <i class="fa-solid fa-wifi"></i> WiFiあり
                                </span>
                            @endif

                            @if($spot->has_power)
                                <span class="amenity-item">
                                    <i class="fa-solid fa-plug-circle-bolt"></i> コンセントあり
                                </span>
                            @endif
                        </div>
                        <a href="#" class="spot-map-link open-map-btn" data-url="{{ $spot->map_url }}">地図で見る</a>
                    </div>
                @endforeach
            </div>

            <div class="map-modal" id="mapModal style=display: none;">
                <div class="modal-content">
                    <button class="close-btn" id="closeMapBtn">×</button>
                    <h3>店舗の位置マップ</h3>

                    <div class="map-container">
                        <iframe id="modalMapIframe" src="" width="100%" height="350" style="border:0;"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const mapModal = document.getElementById('mapModal');
                    const closeMapBtn = document.getElementById('closeMapBtn');
                    const modalMapIframe = document.getElementById('modalMapIframe');
                    const openMapBtns = document.querySelectorAll('.open-map-btn');

                    // 安全装置：もしモーダルや必要な部品が画面内に存在しない場合は、処理をスキップする
                    if (!mapModal || !modalMapIframe) {
                        console.warn('警告: mapModal または modalMapIframe が見つかりません。HTMLのid属性を確認してください。');
                        return;
                    }

                    // 1. 各カードの「地図で見る」ボタンが押されたときの処理
                    openMapBtns.forEach(btn => {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault(); // 画面が一番上に跳ね上がるのを防ぐ

                            // ボタンに仕込んだそのお店のマップURLを取得
                            const mapUrl = this.getAttribute('data-url');

                            if (mapUrl) {
                                // モーダルの中のiframeにURLをセットして地図を表示
                                modalMapIframe.src = mapUrl;

                                // モーダルを画面に表示
                                mapModal.style.display = 'flex';
                            } else {
                                console.error('エラー: ボタンに data-url が設定されていません。');
                            }
                        });
                    });

                    // 2. 「×」ボタンが押されたらモーダルを閉じる処理
                    if (closeMapBtn) {
                        closeMapBtn.addEventListener('click', function () {
                            mapModal.style.display = 'none';
                            modalMapIframe.src = ''; // 閉じたときは地図の読み込みをクリアして軽くする
                        });
                    }

                    // 3. モーダルの外側をクリックしても閉じるようにする
                    window.addEventListener('click', function (e) {
                        if (e.target === mapModal) {
                            mapModal.style.display = 'none';
                            modalMapIframe.src = '';
                        }
                    });
                });
            </script>
            <div class="map-modal" id="mapModal"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
                <div class="modal-content"
                    style="background: white; padding: 20px; border-radius: 8px; width: 90%; max-width: 500px; position: relative;">
                    <button class="close-btn" id="closeMapBtn"
                        style="position: absolute; top: 10px; right: 15px; font-size: 24px; border: none; background: none; cursor: pointer;">×</button>
                    <h3 style="margin-top: 0;">店舗の位置マップ</h3>

                    <div class="map-container" style="width: 100%; height: 350px; background: #eee;">
                        <iframe id="modalMapIframe" src="" width="100%" height="100%" style="border:0;"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
</body>

</html>