<div class="small text-muted">
    @if($hospital->is_jhd_supported)
        <div class="mb-2">
            <i class="fa-solid fa-hospital me-2"></i>
            <span class="fw-semibold">{{ __('healthcare.hours.hospital') }}:</span>
            @if($hospital->is_24_hours)
                {{ __('healthcare.hours.open_24h') }}
            @else
                {{ $hospital->business_hours }}
            @endif
        </div>
        @if($hospital->jhd_hours)
            <div class="mb-3">
                <i class="fa-solid fa-headset me-2"></i>
                <span class="fw-semibold">{{ __('healthcare.hours.jhd') }}:</span>
                {{ $hospital->jhd_hours }}
                @if($hospital->jhd_closed_days)
                    <span class="text-muted">({{ __('healthcare.hours.closed') }}: {{ $hospital->jhd_closed_days }})</span>
                @endif
            </div>
        @endif
    @else
        <div class="mb-2">
            <i class="fa-solid fa-clock me-2"></i>
            <span class="fw-semibold">{{ __('healthcare.hours.clinic') }}:</span>
            {{ $hospital->business_hours }}
        </div>
        @if($hospital->closed_days)
            <div class="mb-3">
                <i class="fa-solid fa-calendar-xmark me-2"></i>
                <span class="fw-semibold">{{ __('healthcare.hours.closed') }}:</span>
                {{ $hospital->closed_days }}
            </div>
        @endif
    @endif
</div>
