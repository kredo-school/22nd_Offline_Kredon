<style>
    /* モーダル全体のCSS */
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
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        position: relative;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    /* 評価ボタンのCSS */
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
        cursor: pointer;
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

<div class="custom-modal" id="newSpotModal">
    <div class="modal-content" style="padding: 0; max-height: 85vh; overflow-y: auto;">
        <div
            style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee; position: sticky; top: 0; background: white; z-index: 10;">
            <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">新規スポットを登録する</h2>
            <button onclick="document.getElementById('newSpotModal').classList.remove('is-show')" class="close-btn"
                style="position: static; font-size: 24px; background: none; border: none; cursor: pointer;">×</button>
        </div>

        <form action="{{ route('spots.store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
            @csrf

            <div style="margin-bottom: 15px;">
                <input type="text" name="name" required placeholder="スポット名（例：Cebu CoWork Hub）"
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 15px;">
            </div>

            <div
                style="margin-bottom: 15px; display: flex; gap: 20px; background-color: #f4f8fb; padding: 15px; border-radius: 8px; border: 1px solid #c9d8e4; justify-content: center;">
                <label
                    style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 15px;">
                    <input type="checkbox" name="has_power" value="1" style="transform: scale(1.3);"> 🔌 コンセントあり
                </label>
                <label
                    style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 15px;">
                    <input type="checkbox" name="has_wifi" value="1" style="transform: scale(1.3);"> 📶 Wi-Fiあり
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <select name="area" required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 15px; background-color: white;">
                    <option value="" hidden>-- エリアを選択 --</option>
                    <option value="ITパーク">ITパーク</option>
                    <option value="アヤラ">アヤラ</option>
                    <option value="その他（タクシー圏内）">その他（タクシー圏内）</option>
                </select>
            </div>

            <div
                style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px; background-color: #fafafa; padding: 10px; border-radius: 6px; border: 1px solid #eee;">
                <span style="color: #666; font-size: 13px; font-weight: bold;">🕒 営業時間</span>
                <input type="time" name="open_time" step="1800"
                    style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <span style="color: #999;">〜</span>
                <input type="time" name="close_time" step="1800"
                    style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸
                    スポットの外観・内観写真（1枚）</label>
                <div
                    style="position: relative; width: 100%; border: 2px dashed #4a82b3; border-radius: 8px; background-color: #f4f8fb; text-align: center; cursor: pointer; overflow: hidden;">
                    <img id="imagePreview" src="" alt="プレビュー"
                        style="width: 100%; height: 200px; object-fit: cover; display: none;">
                    <div id="uploadPrompt" style="padding: 30px 20px;">
                        <i class="fa-solid fa-camera" style="font-size: 32px; color: #4a82b3; margin-bottom: 10px;"></i>
                        <div style="font-weight: bold; color: #4a82b3; font-size: 14px;">タップして写真を選択</div>
                    </div>
                    <input type="file" name="photo" id="photoInput" accept="image/*"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                </div>
            </div>

            <div style="text-align: center;">
                <button type="submit"
                    style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">
                    スポットを登録する
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // 🌟 既存の魔法：モーダルの外側をクリックしたら閉じる
        const newSpotModal = document.getElementById('newSpotModal');
        if (newSpotModal) {
            window.addEventListener('click', function (e) {
                if (e.target === newSpotModal) {
                    newSpotModal.classList.remove('is-show');
                }
            });
        }

        // 🌟 今回追加した魔法：画像プレビュー機能
        const photoInput = document.getElementById('photoInput');
        if (photoInput) {
            photoInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById('imagePreview');
                        preview.src = e.target.result;
                        preview.style.display = 'block';

                        document.getElementById('uploadPrompt').style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

    });
</script>