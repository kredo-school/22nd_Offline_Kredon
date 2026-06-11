<style>
    /* モーダル基本スタイル */
    .custom-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); display: none; justify-content: center; align-items: center; z-index: 9999; }
    .custom-modal.is-show { display: flex; }
    .modal-content { background-color: white; padding: 20px; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); }
    .close-btn { position: absolute; top: 15px; right: 15px; font-size: 20px; cursor: pointer; background: none; border: none; color: #888; }

    /* 📱 スマホ対応（レスポンシブ） */
    @media (max-width: 768px) {
        .modal-content {
            width: 95%; /* スマホでは画面幅ギリギリまで広げる */
            padding: 15px;
        }
        /* 営業時間の入力欄をスマホでは縦並びにする */
        .time-input-group {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 5px !important;
        }
        .time-input-group input {
            width: 100%;
            box-sizing: border-box;
        }
        .time-input-group > span.time-separator {
            display: none; /* スマホでは「〜」の文字を隠してスッキリさせる */
        }
        /* チェックボックスの文字サイズをスマホ向けに最適化 */
        .checkbox-label {
            font-size: 13px !important;
        }
    }
</style>

<div class="custom-modal" id="newTouristSpotModal">
    <div class="modal-content" style="padding: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
            <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">新規観光スポットを登録</h2>
            <button type="button" onclick="document.getElementById('newTouristSpotModal').classList.remove('is-show')"
                class="close-btn" style="position: static;">×</button>
        </div>

        <form action="{{ route('tourist_spots.store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🌴 観光スポット名</label>
                <input type="text" name="name" required
                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>

            <div style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px; background-color: #fff4e6; padding: 15px; border-radius: 8px; border: 1px solid #fbdcb6; justify-content: center;">
                <label class="checkbox-label" style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_activity" value="1" style="transform: scale(1.2);"> 🏊 遊ぶ
                </label>
                <label class="checkbox-label" style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_view" value="1" style="transform: scale(1.2);"> 📷 見る
                </label>
                <label class="checkbox-label" style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_shopping" value="1" style="transform: scale(1.2);"> 🛍️ 買う
                </label>
                <label class="checkbox-label" style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #333; font-size: 14px;">
                    <input type="checkbox" name="has_food" value="1" style="transform: scale(1.2);"> 🍽️ 食べる
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">📍 エリア</label>
                <select name="area" required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; background-color: white;">
                    <option value="マクタン島">マクタン島</option>
                    <option value="セブ市街">セブ市街</option>
                    <option value="オスロブ・モアルボアル">オスロブ・モアルボアル</option>
                    <option value="その他（遠方）">その他（遠方）</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">💰 予算目安（例：無料、約500ペソ など）</label>
                <input type="text" name="budget"
                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 5px;">🔗 予約サイトURL（https://... から入力）</label>
                <input type="url" name="booking_url" placeholder="https://example.com"
                    style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>
            
            <div style="margin-bottom: 15px; background-color: #fafafa; padding: 10px; border-radius: 6px; border: 1px solid #eee;">
                <span style="color: #666; font-size: 13px; font-weight: bold; display: block; margin-bottom: 8px;">🕒 営業時間</span>
                {{-- 🌟 修正ポイント：クラス「time-input-group」を追加してスマホで縦並びにする --}}
                <div class="time-input-group" style="display: flex; align-items: center; gap: 10px;">
                    <input type="time" name="open_time" step="1800"
                        style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <span class="time-separator" style="color: #999;">〜</span>
                    <input type="time" name="close_time" step="1800"
                        style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 8px;">📸 写真を追加</label>
                <input type="file" name="photo" accept="image/*" style="width: 100%; font-size: 14px;">
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