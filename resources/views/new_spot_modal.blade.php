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
    .custom-modal.is-show { display: flex; }
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
    .rating-radio { display: none; }
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
    .rating-radio:checked + .rating-label {
        background-color: #1e8b9b;
        color: white;
        border-color: #1e8b9b;
        box-shadow: 0 2px 6px rgba(30, 139, 155, 0.3);
    }
</style>

<!-- モーダルのHTML -->
<div class="custom-modal" id="newSpotModal">
    <div class="modal-content" style="padding: 0; max-height: 85vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee; position: sticky; top: 0; background: white; z-index: 10;">
            <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">新規スポットを登録する</h2>
            <button onclick="document.getElementById('newSpotModal').classList.remove('is-show')" class="close-btn" style="position: static; font-size: 24px; background: none; border: none; cursor: pointer;">×</button>
        </div>

        <form action="{{ route('spots.store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px 20px 40px 20px;" onsubmit="return confirm('この内容で新しいスポットと最初のレビューを登録しますか？');">
            @csrf
            
            <!-- 基本情報セクション -->
            <div style="border: 1px solid #c9d8e4; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                <div style="background-color: #4a82b3; color: white; font-size: 12px; font-weight: bold; padding: 6px 12px;">Spot Information (基本情報)</div>
                <div style="background-color: #f4f8fb; padding: 12px; display: flex; flex-direction: column; gap: 10px;">
                    <input type="text" name="name" placeholder="スポット名（例：Cebu CoWork Hub）" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" required>
                    <select name="area" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" required>
                        <option value="">-- エリアを選択 --</option>
                        <option value="it-park">ITパーク周辺</option>
                        <option value="ayala">アヤラ周辺</option>
                        <option value="lahug">ラホグ</option>
                        <option value="mabolo">マボロ</option>
                        <option value="others">その他</option>
                    </select>
                    <div style="display: flex; gap: 15px; margin-top: 5px;">
                        <label style="font-size: 14px; font-weight: bold; color: #555; cursor: pointer;"><input type="checkbox" name="has_wifi" value="1"> 📶 Wi-Fi</label>
                        <label style="font-size: 14px; font-weight: bold; color: #555; cursor: pointer;"><input type="checkbox" name="has_power" value="1"> 🔌 コンセント</label>
                    </div>
                </div>
            </div>

            <!-- 初回レビューセクション -->
            <div style="background-color: #fafafa; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #eee;">
                <p style="font-size: 12px; font-weight: bold; color: #4a82b3; margin-top: 0; margin-bottom: 15px;">✍️ 最初の発見者としてニッチ評価を入力（任意）</p>
                
                @php
                    $ratings = [
                        'customer_vibe' => '👥 客層 (1:ガヤガヤ 〜 5:集中ソロ)',
                        'eye_fatigue_level' => '👁️ 目の疲れ度 (1:眩しい/暗い 〜 5:快適)',
                        'chair_comfort' => '🪑 イスの座りやすさ (1:痛い 〜 5:極上)',
                        'desk_stability' => '🏢 机の安定度 (1:ガタガタ 〜 5:頑丈)'
                    ];
                @endphp

                @foreach($ratings as $name => $label)
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">{{ $label }}</label>
                        <div class="rating-group">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="{{ $name }}" id="new_{{ $name }}_{{ $i }}" value="{{ $i }}" class="rating-radio">
                                <label for="new_{{ $name }}_{{ $i }}" class="rating-label" style="padding: 6px 0; font-size: 14px;">{{ $i }}</label>
                            @endfor
                        </div>
                    </div>
                @endforeach

                <div style="margin-bottom: 0;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">📝 実際の感想（コメント）</label>
                    <textarea name="comment" rows="2" placeholder="席の埋まり具合や、実際の作業環境の感想など..." style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; resize: none; outline: none;"></textarea>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="document.getElementById('newSpotModal').classList.remove('is-show')" style="flex: 1; background-color: white; color: #1e8b9b; border: 1px solid #1e8b9b; padding: 12px; border-radius: 25px; font-weight: bold; font-size: 14px; cursor: pointer;">キャンセル</button>
                <button type="submit" style="flex: 1; background-color: #1e8b9b; color: white; border: none; padding: 12px; border-radius: 25px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">スポットを登録する</button>
            </div>
        </form>
    </div>
</div>

<!-- モーダル開閉用のJS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const newSpotModal = document.getElementById('newSpotModal');
        if(newSpotModal) {
            window.addEventListener('click', function (e) {
                if (e.target === newSpotModal) {
                    newSpotModal.classList.remove('is-show');
                }
            });
        }
    });
</script>