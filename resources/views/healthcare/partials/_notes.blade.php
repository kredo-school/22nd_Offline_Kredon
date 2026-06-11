<div class="card border-0 shadow-sm mt-4 bg-light" style="background-color: #F1F4F2 !important;">

    <div class="card-body p-4">
        {{-- 見出し --}}
        <h6 class="fw-bold text-dark mb-3">注意事項</h6>
        
        <ul class="list-unstyled text-muted small mb-0" style="line-height: 1.6;">
            <li class="mb-2">※診断は行いません。</li>
            <li>
                {{-- Carbonを使って自動で年月を表示 --}}
                ※あくまで {{ \Carbon\Carbon::now()->format('Y年n月') }} 時点の情報であり、掲載されている情報と異なっている場合がありますので、あらかじめご了承ください。
            </li>
        </ul>
    </div>
</div>