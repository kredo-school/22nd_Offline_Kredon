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
                <button id="openMapBtn"
                    style="padding: 10px 20px; font-size: 14px; cursor: pointer; border-radius: 5px; border: 1px solid #ccc; background: white; margin-top: 10px;">
                    🗺️ エリアを選択して地図を見る
                </button>
            </div>

            <div class="spot-list">

                <div class="spot-card">
                    <div class="spot-card-header">
                        <span class="spot-name">店名　ITパークカフェ</span>
                        <div class="spot-hours">営業時間　9:00 - 18:00</div>
                    </div>

                    <div class="spot-photo-section-title">写真</div>
                    <div class="spot-photos-grid">
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="外観">
                            <span class="photo-label">外観</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="内観">
                            <span class="photo-label">内観</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="メニュー表">
                            <span class="photo-label">メニュー表</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="食べたもの">
                            <span class="photo-label">食べたもの</span>
                        </div>
                    </div>

                    <div class="spot-card-footer">
                        <div class="spot-facilities">
                            設備
                            <i class="fa-solid fa-wifi"></i>
                            <i class="fa-solid fa-plug-circle-bolt"></i>
                        </div>
                        <a href="#" class="spot-map-link">地図で見る</a>
                    </div>
                </div>
                <div class="spot-card">
                    <div class="spot-card-header">
                        <span class="spot-name">店名　アヤラ・コワーキング</span>
                        <div class="spot-hours">営業時間　9:00 - 18:00</div>
                    </div>

                    <div class="spot-photo-section-title">写真</div>
                    <div class="spot-photos-grid">
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="外観">
                            <span class="photo-label">外観</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="内観">
                            <span class="photo-label">内観</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="メニュー表">
                            <span class="photo-label">メニュー表</span>
                        </div>
                        <div class="photo-item">
                            <img src="https://placehold.co/150x100/d8c3b4/white?text=Photo" class="photo-dummy"
                                alt="食べたもの">
                            <span class="photo-label">食べたもの</span>
                        </div>
                    </div>

                    <div class="spot-card-footer">
                        <div class="spot-facilities">
                            設備
                            <i class="fa-solid fa-wifi"></i>
                            <i class="fa-solid fa-plug-circle-bolt"></i>
                        </div>
                        <a href="#" class="spot-map-link">地図で見る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="map-modal" id="mapModal">
        <div class="modal-content">
            <button class="close-btn" id="closeMapBtn">×</button>
            <h3>選択されたエリアのマップ</h3>
            <div class="dummy-map">ここにGoogleマップがポップアップします</div>
        </div>
    </div>

    <script>
        const openBtn = document.getElementById('openMapBtn');
        const closeBtn = document.getElementById('closeMapBtn');
        const modal = document.getElementById('mapModal');

        // ボタンを押したら「is-show」クラスをつけて表示する
        openBtn.addEventListener('click', () => {
            modal.classList.add('is-show');
        });

        // ×ボタンを押したら「is-show」クラスを消して非表示にする
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('is-show');
        });

        // 背景の黒い部分をクリックしても閉じるようにする場合（お好みで追加してください）
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('is-show');
            }
        });
    </script>

</body>

</html>