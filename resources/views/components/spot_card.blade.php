<a href="{{ route('spots.show', $spot->id) }}" class="spot-card-horizontal">
    <div class="spot-card-img-area">
        @if($spot->photo_path)
            <img src="{{ asset('storage/' . $spot->photo_path) }}" alt="スポット写真">
        @else
            <img src="https://placehold.co/400x300/e6f0f9/4a82b3?text=No+Photo" alt="写真なし">
        @endif
    </div>
    <div class="spot-card-info">
        <div>
            <div class="spot-title">{{ $spot->name }}</div>
            <div class="spot-desc">
                📍 エリア：{{ $spot->area }}<br>
                営業時間：{{ $spot->hours ?? '情報なし' }}
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="spot-tags">
                @if($spot->has_wifi)<span class="tag-item"><i class="fa-solid fa-wifi"></i> WiFi完備</span>@endif
                @if($spot->has_power)<span class="tag-item"><i class="fa-solid fa-plug-circle-bolt"></i> 電源あり</span>@endif
            </div>
            <div style="color: #ccc; font-size: 14px;"><i class="fa-solid fa-chevron-right"></i></div>
        </div>
    </div>
</a>