<style>
    .custom-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); display: none; justify-content: center; align-items: center; z-index: 9999; }
    .custom-modal.is-show { display: flex; }
    .modal-content { background-color: white; padding: 20px; border-radius: 12px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); }
    .close-btn { position: absolute; top: 15px; right: 15px; font-size: 20px; cursor: pointer; background: none; border: none; color: #888; }
    
    .rating-group { display: flex; justify-content: space-between; gap: 6px; margin-top: 8px; }
    .rating-radio { display: none; }
    .rating-label { flex: 1; text-align: center; background-color: #f4f8fb; border: 1px solid #c9d8e4; border-radius: 8px; padding: 10px 0; cursor: pointer; font-size: 16px; font-weight: bold; color: #555; transition: all 0.2s ease; }
    .rating-radio:checked+.rating-label { background-color: #1e8b9b; color: white; border-color: #1e8b9b; }

    .file-upload-wrapper { position: relative; overflow: hidden; display: inline-block; width: 100%; }
    .file-upload-btn { background-color: #f4f8fb; border: 2px dashed #4a82b3; color: #4a82b3; padding: 20px; border-radius: 8px; font-weight: bold; text-align: center; display: block; cursor: pointer; transition: 0.2s; }
    .file-upload-input { font-size: 100px; position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; height: 100%; }

    @media (max-width: 768px) {
        .modal-content { width: 95%; padding: 15px; }
        .rating-label { padding: 8px 0; font-size: 14px; }
        .time-input-group { flex-direction: column; align-items: flex-start !important; gap: 5px !important; }
        .time-input-group input { width: 100%; box-sizing: border-box; }
        .time-input-group span { display: none; }
    }
</style>

<div class="custom-modal" id="newSpotModal">
    <div class="modal-content" style="padding: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee;">
            <h2 style="margin: 0; font-size: 18px; color: #333; font-weight: bold;">新規スポットを登録する</h2>
            <button type="button" onclick="document.getElementById('newSpotModal').classList.remove('is-show')" class="close-btn" style="position: static;">×</button>
        </div>

        @if ($errors->any())
            <div style="background-color: #fef0f0; border: 1px solid #f5c2c7; color: #842029; padding: 10px 20px; border-radius: 6px; margin: 20px 20px 0;">
                <p style="font-weight: bold; margin-top: 0; margin-bottom: 5px;">⚠️ 登録エラーがあります：</p>
                <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('newSpotModal').classList.add('is-show');
                });
            </script>
        @endif

        <form action="{{ route('spots.store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
            @csrf

            <div style="margin-bottom: 15px;">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="スポット名（例：Cebu CoWork Hub）" required style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
            </div>

            <div style="margin-bottom: 15px; display: flex; gap: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 6px; justify-content: center; background-color: #fafafa;">
                <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #555; font-size: 14px;">
                    <input type="checkbox" name="has_power" value="1" {{ old('has_power') ? 'checked' : '' }} style="transform: scale(1.3);"> 🔌 コンセントあり
                </label>
                <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: bold; color: #555; font-size: 14px;">
                    <input type="checkbox" name="has_wifi" value="1" {{ old('has_wifi') ? 'checked' : '' }} style="transform: scale(1.3);"> 📶 Wi-Fiあり
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <select name="area" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background-color: white; color: #555;">
                    <option value="">-- エリアを選択 --</option>
                    <option value="ITパーク" {{ old('area') == 'ITパーク' ? 'selected' : '' }}>ITパーク</option>
                    <option value="アヤラ" {{ old('area') == 'アヤラ' ? 'selected' : '' }}>アヤラ</option>
                    <option value="その他（タクシー圏内）" {{ old('area') == 'その他（タクシー圏内）' ? 'selected' : '' }}>その他（タクシー圏内）</option>
                </select>
            </div>

            <div class="time-input-group" style="margin-bottom: 20px; border: 1px solid #ddd; padding: 12px; border-radius: 6px; display: flex; flex-direction: column; background-color: #fafafa;">
                <span style="font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px; display: block;">🕒 営業時間</span>
                
                <div style="display: flex; gap: 15px; margin-bottom: 10px; font-size: 13px;">
                    <label style="cursor: pointer;"><input type="radio" name="hours_type" value="specified" {{ old('hours_type', 'specified') == 'specified' ? 'checked' : '' }} onchange="toggleTimeInput()"> 時間指定</label>
                    <label style="cursor: pointer;"><input type="radio" name="hours_type" value="24h" {{ old('hours_type') == '24h' ? 'checked' : '' }} onchange="toggleTimeInput()"> 24時間営業</label>
                    <label style="cursor: pointer;"><input type="radio" name="hours_type" value="unknown" {{ old('hours_type') == 'unknown' ? 'checked' : '' }} onchange="toggleTimeInput()"> 不明</label>
                </div>

                <div id="timeInputArea" style="display: flex; width: 100%; gap: 10px; align-items: center; transition: opacity 0.2s;">
                    <input type="time" name="open_time" id="openTime" value="{{ old('open_time') }}" step="600" style="flex: 1; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    <span style="color: #999;" class="time-separator">〜</span>
                    <input type="time" name="close_time" id="closeTime" value="{{ old('close_time') }}" step="600" style="flex: 1; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px;">📸 スポットの外観・内観写真（最大4枚まで選択可）</label>
                <div class="file-upload-wrapper">
                    <div class="file-upload-btn" id="newSpotFileBtn">
                        <i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>
                        タップして写真を選択
                    </div>
                    <input type="file" name="photos[]" multiple accept="image/*" class="file-upload-input" id="newSpotFileInput" onchange="previewSpotPhotos(event)">
                </div>
                <div id="photoPreviewContainer" style="display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap;"></div>
            </div>

            <div style="background-color: #f4f8fb; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c9d8e4;">
                <p style="font-size: 12px; font-weight: bold; color: #1e8b9b; margin-top: 0; margin-bottom: 15px;">🔍 ニッチな評価をシェア（1〜5で選択・<span style="color: #e53e3e;">※必須</span>）</p>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👥 客層 <span style="color: #e53e3e;">*</span></label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="customer_vibe" id="new_spot_vibe_{{ $i }}" value="{{ $i }}" class="rating-radio" required {{ old('customer_vibe') == $i ? 'checked' : '' }}><label for="new_spot_vibe_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← ワイワイ</span><span>もくもく作業 →</span></div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">👁️ 照明 <span style="color: #e53e3e;">*</span></label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="eye_fatigue_level" id="new_spot_eye_{{ $i }}" value="{{ $i }}" class="rating-radio" required {{ old('eye_fatigue_level') == $i ? 'checked' : '' }}><label for="new_spot_eye_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 暗め</span><span>明るい →</span></div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🪑 イス <span style="color: #e53e3e;">*</span></label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="chair_comfort" id="new_spot_chair_{{ $i }}" value="{{ $i }}" class="rating-radio" required {{ old('chair_comfort') == $i ? 'checked' : '' }}><label for="new_spot_chair_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 硬い</span><span>ふかふか →</span></div>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="display: block; font-size: 12px; font-weight: bold; color: #555;">🏢 机 <span style="color: #e53e3e;">*</span></label>
                    <div class="rating-group">@for($i = 1; $i <= 5; $i++)<input type="radio" name="desk_stability" id="new_spot_desk_{{ $i }}" value="{{ $i }}" class="rating-radio" required {{ old('desk_stability') == $i ? 'checked' : '' }}><label for="new_spot_desk_{{ $i }}" class="rating-label">{{ $i }}</label>@endfor</div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; color: #888; margin-top: 4px;"><span>← 狭い</span><span>広い →</span></div>
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 12px; font-weight: bold; color: #555; margin-bottom: 8px;">📝 最初のクチコミ（任意）</label>
                <textarea name="comment" rows="3" placeholder="お店の雰囲気やおすすめポイントなど..." style="width: 100%; box-sizing: border-box; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: none; background-color: #fafafa;">{{ old('comment') }}</textarea>
            </div>

            <div style="text-align: center;">
                <button type="submit" style="background-color: #1e8b9b; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-weight: bold; font-size: 15px; cursor: pointer; width: 100%;">
                    スポットを登録する
                </button>
            </div>
        </form>
    </div>
</div>

<div class="custom-modal" id="rewardModal">
    <div class="modal-content" style="text-align: center; padding: 30px 20px;">
        <button onclick="document.getElementById('rewardModal').classList.remove('is-show')" class="close-btn" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 20px; cursor: pointer; color: #888;">×</button>
        <div style="font-size: 40px; margin-bottom: 15px;">🎉</div>
        <h2 style="font-size: 18px; color: #1e8b9b; font-weight: bold; margin-bottom: 10px;">情報シェアありがとうございます！</h2>
        <p style="font-size: 13px; color: #666; margin-bottom: 20px;">貴重な情報のお礼に、セブ生活と開発に役立つ限定Tipsをお届けします！</p>
        
        <div id="rewardTipContent" style="background: #f4f8fb; border: 1px solid #c9d8e4; padding: 20px; border-radius: 12px; text-align: left;">
            </div>
        
        <button onclick="document.getElementById('rewardModal').classList.remove('is-show')" class="primary-btn" style="background-color: #1e8b9b; color: white; border: none; padding: 12px 25px; border-radius: 25px; font-weight: bold; cursor: pointer; margin-top: 20px;">
            閉じてアプリに戻る
        </button>
    </div>
</div>

 
   <script>
    function toggleTimeInput() {
        const type = document.querySelector('input[name="hours_type"]:checked').value;
        const timeInputArea = document.getElementById('timeInputArea');
        const openInput = document.getElementById('openTime');
        const closeInput = document.getElementById('closeTime');

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

    // 初期状態のセット
    document.addEventListener('DOMContentLoaded', toggleTimeInput);

    function previewSpotPhotos(event) {
        const container = document.getElementById('photoPreviewContainer');
        const newSpotLabel = document.getElementById('newSpotFileBtn');
        container.innerHTML = ''; 
        const files = event.target.files;

        if (files.length > 4) {
            alert('アップロードできる写真は最大4枚までです。厳選した4枚をお願いします！');
            event.target.value = '';
            newSpotLabel.innerHTML = '<i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>タップして写真を選択';
            newSpotLabel.style.borderColor = '#4a82b3';
            newSpotLabel.style.color = '#4a82b3';
            newSpotLabel.style.backgroundColor = '#f4f8fb';
            return;
        }

        if (files.length > 0) {
            newSpotLabel.innerHTML = '<i class="fa-solid fa-check" style="font-size: 24px; margin-bottom: 5px; display: block; color: #297a6a;"></i>' + files.length + '枚の画像を選択中';
            newSpotLabel.style.borderColor = '#297a6a';
            newSpotLabel.style.color = '#297a6a';
            newSpotLabel.style.backgroundColor = '#f0faf8';
        } else {
            newSpotLabel.innerHTML = '<i class="fa-solid fa-camera" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>タップして写真を選択';
            newSpotLabel.style.borderColor = '#4a82b3';
            newSpotLabel.style.color = '#4a82b3';
            newSpotLabel.style.backgroundColor = '#f4f8fb';
        }

        Array.from(files).forEach(file => {
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
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // 🌟 Controllerから「ガチャ結果」が送られてきた時だけ発動！
        @if(session('success') && session('reward_tip_title'))
            const tipContent = document.getElementById('rewardTipContent');
            
            // 🌟 データベースから来たタイトルと本文をハメ込む！
            tipContent.innerHTML = `
                <div style="font-weight: bold; color: #1e8b9b; margin-bottom: 8px;">{{ session('reward_tip_title') }}</div>
                <div style="color: #333; line-height: 1.6; font-size: 13px;">{{ session('reward_tip_text') }}</div>
            `;
            
            const flashMsg = document.getElementById('flash-message');
            if(flashMsg) flashMsg.style.display = 'none';
            
            setTimeout(() => { document.getElementById('rewardModal').classList.add('is-show'); }, 100);
        @endif
    });
</script>
