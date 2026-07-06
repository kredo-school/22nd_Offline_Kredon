<style>
    /* 共通モーダルスタイル（CSSの重複がある場合は片方だけでOKです） */
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

    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            padding: 15px;
        }

        .time-input-group {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 5px !important;
        }

        .time-input-group input {
            width: 100%;
            box-sizing: border-box;
        }

        .time-input-group>span.time-separator {
            display: none;
        }

        .checkbox-label {
            font-size: 13px !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.3/dist/heic2any.min.js"></script>

<div class="custom-modal" id="newTouristSpotModal">
    <div class="modal-content" style="padding: 0;">
        <div
            style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
            <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">新規観光スポットを登録</h2>
            <button type="button" onclick="document.getElementById('newTouristSpotModal').classList.remove('is-show')"
                class="close-btn" style="position: static;">×</button>
        </div>

        <form action="{{ route('tourist_spots.store') }}" method="POST" enctype="multipart/form-data"
            style="padding: 20px;">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🌴
                    観光スポット名</label>
                <input type="text" name="name" required
                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>

            <div
                style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px; background-color: #fff4e6; padding: 15px; border-radius: 8px; border: 1px solid #fbdcb6; justify-content: center;">
                <label class="checkbox-label"
                    style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_activity" value="1" style="transform: scale(1.2);"> 🏊 遊ぶ
                </label>
                <label class="checkbox-label"
                    style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_view" value="1" style="transform: scale(1.2);"> 📷 見る
                </label>
                <label class="checkbox-label"
                    style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_shopping" value="1" style="transform: scale(1.2);"> 🛍️ 買う
                </label>
                <label class="checkbox-label"
                    style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_food" value="1" style="transform: scale(1.2);"> 🍽️ 食べる
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">📍
                    エリア</label>
                <select name="area" required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; background-color: white;">
                    <option value="セブ島">セブ島</option>
                    <option value="離島">離島</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">💰
                    予算目安（例：無料、約500ペソ など）</label>
                <input type="text" name="budget"
                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🔗
                    予約サイトURL（https://... から入力）</label>
                <input type="url" name="booking_url" placeholder="https://example.com"
                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>

            <div class="time-input-group"
                style="margin-bottom: 20px; border: 1px solid #ddd; padding: 12px; border-radius: 6px; display: flex; flex-direction: column; background-color: #fafafa;">
                <span style="font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px; display: block;">🕒
                    営業時間</span>

                <div style="display: flex; gap: 15px; margin-bottom: 10px; font-size: 13px;">
                    <label style="cursor: pointer;"><input type="radio" name="hours_type" value="specified" checked
                            onchange="toggleTouristTimeInput()"> 時間指定</label>
                    <label style="cursor: pointer;"><input type="radio" name="hours_type" value="24h"
                            onchange="toggleTouristTimeInput()"> 24時間営業</label>
                    <label style="cursor: pointer;"><input type="radio" name="hours_type" value="unknown"
                            onchange="toggleTouristTimeInput()"> 不明</label>
                </div>

                <div id="touristTimeInputArea"
                    style="display: flex; width: 100%; gap: 10px; align-items: center; transition: opacity 0.2s;">
                    <input type="time" name="open_time" id="touristOpenTime" step="1800"
                        style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <span class="time-separator" style="color: #999;">〜</span>
                    <input type="time" name="close_time" id="touristCloseTime" step="1800"
                        style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸
                    スポットの写真（最大10枚・ドラッグ可）</label>
                <div class="file-upload-wrapper">
                    <div class="file-upload-btn" id="newTouristSpotFileBtn"
                        style="border-color: #f0932b; color: #f0932b; background-color: #fff4e6;">
                        <i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>
                        タップまたは写真をここにドロップ
                    </div>
                    <input type="file" name="photos[]" multiple accept="image/*" class="file-upload-input"
                        id="newTouristSpotFileInput" onchange="previewTouristSpotPhotos(event)">
                </div>
                <div id="touristPhotoPreviewContainer"
                    style="display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap;"></div>
            </div>
            <div class="mb-3">
                <label class="form-label">✍️ スポットの感想・おすすめポイント（任意）</label>
                <textarea name="review_text" class="form-control" rows="3"
                    placeholder="例：夕日が見える席が最高でした！静かで集中できます。"></textarea>
            </div>
            <div style="text-align: center;">
                <button type="submit"
                    style="background-color: #f0932b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">
                    スポットを登録する
                </button>
            </div>
        </form>
    </div>
</div>

<div class="custom-modal" id="touristRewardModal">
    <div class="modal-content" style="text-align: center; padding: 30px 20px;">
        <button onclick="document.getElementById('touristRewardModal').classList.remove('is-show')" class="close-btn"
            style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 20px; cursor: pointer; color: #888;">×</button>
        <div style="font-size: 40px; margin-bottom: 15px;">🎉</div>
        <h2 style="font-size: 18px; color: #f0932b; font-weight: bold; margin-bottom: 10px;">観光スポットのシェア、ありがとうございます！</h2>
        <p style="font-size: 13px; color: #666; margin-bottom: 20px;">お礼に、セブ生活と開発に役立つ限定Tipsをお届けします！</p>

        <div id="rewardTipContent"
            style="background: #fff4e6; border: 1px solid #fbdcb6; padding: 20px; border-radius: 12px; text-align: left;">
        </div>

        <button onclick="document.getElementById('touristRewardModal').classList.remove('is-show')" class="primary-btn"
            style="background-color: #f0932b; color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: bold; cursor: pointer; margin-top: 20px;">
            閉じてアプリに戻る
        </button>
    </div>
</div>

<script>
    function toggleTouristTimeInput() {
        const typeElement = document.querySelector('input[name="hours_type"]:checked');
        if (!typeElement) return;

        const type = typeElement.value;
        const timeInputArea = document.getElementById('touristTimeInputArea');
        const openInput = document.getElementById('touristOpenTime');
        const closeInput = document.getElementById('touristCloseTime');

        if (type === 'specified') {
            timeInputArea.style.opacity = '1';
            openInput.disabled = false;
            closeInput.disabled = false;
        } else {
            timeInputArea.style.opacity = '0.4';
            openInput.disabled = true;
            closeInput.disabled = true;
            openInput.value = '';
            closeInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', toggleTouristTimeInput);

    // 🌟 観光スポット用の HEIC対応・非同期版のプレビュー関数
    async function previewTouristSpotPhotos(event) {
        const container = document.getElementById('touristPhotoPreviewContainer');
        const fileBtn = document.getElementById('newTouristSpotFileBtn');
        container.innerHTML = '<span style="font-size: 12px; color: #666;">処理中...少しお待ちください⏳</span>';

        const input = event.target;
        const files = Array.from(input.files);

        if (files.length > 10) {
            alert('アップロードできる写真は最大10枚までです。厳選した10枚をお願いします！');
            input.value = '';
            container.innerHTML = '';
            resetTouristFileLabel(fileBtn);
            return;
        }

        const dt = new DataTransfer();
        container.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            let file = files[i];

            // 💡 HEICの場合はJPGに変換
            if (file.name.toLowerCase().endsWith('.heic') || file.name.toLowerCase().endsWith('.heif')) {
                try {
                    const convertedBlob = await heic2any({ blob: file, toType: "image/jpeg" });
                    file = new File([convertedBlob], file.name.replace(/\.heic$/i, '.jpg'), { type: "image/jpeg" });
                } catch (error) {
                    console.error("HEIC変換エラー:", error);
                    continue;
                }
            }

            dt.items.add(file);

            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '65px';
                img.style.height = '65px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                img.style.border = '1px solid #ddd';
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        }

        input.files = dt.files;

        if (dt.files.length > 0) {
            fileBtn.innerHTML = '<i class="fa-solid fa-check" style="font-size: 24px; margin-bottom: 5px; display: block; color: #d35400;"></i>' + dt.files.length + '枚の画像を選択中（変換完了✨）';
            fileBtn.style.borderColor = '#d35400';
            fileBtn.style.color = '#d35400';
            fileBtn.style.backgroundColor = '#fae5d3';
        } else {
            resetTouristFileLabel(fileBtn);
        }
    }

    function resetTouristFileLabel(label) {
        label.innerHTML = '<i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>タップまたは写真をここにドロップ';
        label.style.borderColor = '#f0932b';
        label.style.color = '#f0932b';
        label.style.backgroundColor = '#fff4e6';
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success') && session('reward_tip_title'))
            const tipContent = document.getElementById('rewardTipContent');

            tipContent.innerHTML = `
                    <div style="font-weight: bold; color: #f0932b; margin-bottom: 8px;">{{ session('reward_tip_title') }}</div>
                    <div style="color: #333; line-height: 1.6; font-size: 13px;">{{ session('reward_tip_text') }}</div>
                `;

            const flashMsg = document.getElementById('flash-message');
            if (flashMsg) flashMsg.style.display = 'none';

            setTimeout(() => { document.getElementById('touristRewardModal').classList.add('is-show'); }, 100);
        @endif
    });
</script>