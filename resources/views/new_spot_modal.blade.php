<style>
    .custom-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); display: none; justify-content: center; align-items: center; z-index: 9999; }
    .custom-modal.is-show { display: flex; }
    .modal-content { background-color: white; padding: 20px; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); }
    .close-btn { position: absolute; top: 15px; right: 15px; font-size: 20px; cursor: pointer; background: none; border: none; color: #888; }
    
    /* 評価用ボタンスタイル */
    .rating-group { display: flex; justify-content: space-between; gap: 6px; margin-top: 8px; }
    .rating-radio { display: none; }
    .rating-label { flex: 1; text-align: center; background-color: #f4f8fb; border: 1px solid #c9d8e4; border-radius: 8px; padding: 10px 0; cursor: pointer; font-size: 16px; font-weight: bold; color: #555; transition: all 0.2s ease; }
    .rating-radio:checked+.rating-label { background-color: #1e8b9b; color: white; border-color: #1e8b9b; }

    /* 写真アップロードスタイル */
    .file-upload-wrapper { position: relative; overflow: hidden; display: inline-block; width: 100%; }
    .file-upload-btn { background-color: #f4f8fb; border: 2px dashed #4a82b3; color: #4a82b3; padding: 20px; border-radius: 8px; font-weight: bold; text-align: center; display: block; cursor: pointer; transition: 0.2s; }
    .file-upload-input { font-size: 100px; position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; height: 100%; }
</style>

<div class="custom-modal" id="newSpotModal">
    <div class="modal-content" style="padding: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
            <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">新規スポットを登録する</h2>
            <button type="button" onclick="document.getElementById('newSpotModal').classList.remove('is-show')" class="close-btn" style="position: static;">×</button>
        </div>

        <form action="{{ route('spots.store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
            @csrf

            <div style="margin-bottom: 15px;">
                <input type="text" name="name" placeholder="スポット名（例：Cebu CoWork Hub）" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>

            <div style="margin-bottom: 15px; display: flex; gap: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 6px; justify-content: center; background-color: #fafafa;">
                <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #555; font-size: 14px;">
                    <input type="checkbox" name="has_power" value="1" style="transform: scale(1.3);"> 🔌 コンセントあり
                </label>
                <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #555; font-size: 14px;">
                    <input type="checkbox" name="has_wifi" value="1" style="transform: scale(1.3);"> 📶 Wi-Fiあり
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <select name="area" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background-color: white; color: #555;">
                    <option value="">-- エリアを選択 --</option>
                    <option value="ITパーク">ITパーク</option>
                    <option value="アヤラ">アヤラ</option>
                    <option value="その他（タクシー圏内）">その他（タクシー圏内）</option>
                </select>
            </div>

            <div style="margin-bottom: 20px; border: 1px solid #ddd; padding: 12px; border-radius: 6px; display: flex; align-items: center; gap: 10px; background-color: #fafafa;">
                <span style="font-size: 12px; font-weight: bold; color: #555;">🕒 営業時間</span>
                <input type="time" name="open_time" step="1800" style="flex: 1; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                <span style="color: #999;">〜</span>
                <input type="time" name="close_time" step="1800" style="flex: 1; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px;">📸 スポットの外観・内観写真（複数選択可）</label>
                <div class="file-upload-wrapper">
                    <div class="file-upload-btn" id="newSpotFileBtn">
                        <i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>
                        タップして写真を選択
                    </div>
                    <input type="file" name="photos[]" multiple accept="image/*" class="file-upload-input" id="newSpotFileInput">
                </div>
            </div>

            <div style="background-color: #f4f8fb; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c9d8e4;">
                <p style="font-size: 12px; font-weight: bold; color: #1e8b9b; margin-top: 0; margin-bottom: 15px;">🔍 ニッチな評価をシェア（1〜5で選択・任意）</p>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥 客層</label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="customer_vibe" id="new_spot_vibe_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="new_spot_vibe_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← ワイワイ</span><span>もくもく作業 →</span></div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️ 照明</label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="eye_fatigue_level" id="new_spot_eye_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="new_spot_eye_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 暗め</span><span>明るい →</span></div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑 イス</label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="chair_comfort" id="new_spot_chair_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="new_spot_chair_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 硬い</span><span>ふかふか →</span></div>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢 机</label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="desk_stability" id="new_spot_desk_{{ $i }}" value="{{ $i }}" class="rating-radio"><label for="new_spot_desk_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 狭い</span><span>広い →</span></div>
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px;">📝 最初のクチコミ（任意）</label>
                <textarea name="comment" rows="3" placeholder="お店の雰囲気やおすすめポイントなど..." style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none; background-color: #fafafa;"></textarea>
            </div>

            <div style="text-align: center;">
                <button type="submit" style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">
                    スポットを登録する
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const newSpotInput = document.getElementById('newSpotFileInput');
        const newSpotLabel = document.getElementById('newSpotFileBtn');
        
        if (newSpotInput && newSpotLabel) {
            newSpotInput.addEventListener('change', function (e) {
                if (e.target.files.length > 0) {
                    newSpotLabel.innerHTML = '<i class="fa-solid fa-check" style="font-size: 24px; margin-bottom: 5px; display: block; color: #297a6a;"></i>' + e.target.files.length + '枚の画像を選択中';
                    newSpotLabel.style.borderColor = '#297a6a';
                    newSpotLabel.style.color = '#297a6a';
                    newSpotLabel.style.backgroundColor = '#f0faf8';
                } else {
                    newSpotLabel.innerHTML = '<i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>タップして写真を選択';
                    newSpotLabel.style.borderColor = '#4a82b3';
                    newSpotLabel.style.color = '#4a82b3';
                    newSpotLabel.style.backgroundColor = '#f4f8fb';
                }
            });
        }
    });
</script>