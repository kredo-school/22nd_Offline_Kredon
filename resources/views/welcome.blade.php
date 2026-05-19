<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KREDON - スポット検索</title>
    <style>
        /* --- もともと書いていた基本レイアウト --- */
        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .content-section {
            width: 100%;
            /* マップを消したので最初は横幅いっぱいに */
            padding: 20px;
            overflow-y: scroll;
        }

        /* --- 【追加したCSS】ポップアップ（モーダル）の見た目 --- */
        .map-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.1);
            /* 背景を少し暗く */
            display: none;
            /* ★最初は非表示 */
            justify-content: center;
            align-items: center;
            z-index: 999;
            /* 一番手前に浮かせる */
        }

        /* このクラスがついた時だけフワッと表示させる */
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

        .app-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .filter-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

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
        .search-row{
            
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
                <div class="filter-title" style="margin-top: 20px;">
                    <div class="filter-title">エリアで絞り込む </div>

                    <div class="search-row">
                        <select name="area" class="area-select">
                            <option value="">-- エリアを選択 --</option>
                            <option value="it-north">ITパーク・東</option>
                            <option value="it-north">ITパーク・西</option>
                            <option value="it-north">ITパーク・南</option>
                            <option value="it-north">ITパーク・北</option>
                            <option value="it-north">アヤラ周辺</option>
                            <option value="it-north">ラホグ</option>
                            <option value="it-north">マボロ</option>
                            <option value="it-north">その他</option>
                        </select>

                        <button type="submit" class="search-btn">
                            <i class="fa-solid fa-magnifying-glass"></i> 検索する
                        </button>
                    </div>
                </div>
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
                <button id="openMapBtn"
                    style="padding: 10px 20px; font-size: 14px; cursor: pointer; border-radius: 5px; border: 1px solid #ccc; background: white; margin-top: 10px;">
                    🗺️ エリアを選択して地図を見る
                </button>
            </div>
            <div class="spot-list">

                <div class="spot-card">
                </div>
                <div class="spot-card">
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
    </script>

</body>

</html>