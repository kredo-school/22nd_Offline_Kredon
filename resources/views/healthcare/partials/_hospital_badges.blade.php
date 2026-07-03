<div class="hs-hospital-badges mb-3">
    <div class="d-flex flex-wrap gap-2">
        @if($hospital->is_jhd_supported)
            <span class="badge bg-success-subtle text-success">{{ __('healthcare.badge.jhd') }}</span>
        @endif
        @if($hospital->is_clinic)
            <span class="badge bg-info-subtle text-info">{{ __('healthcare.badge.clinic') }}</span>
        @else
            <span class="badge bg-primary-subtle text-primary">{{ __('healthcare.badge.hospital') }}</span>
        @endif

        @if($hospital->is_clinic)
            @foreach($hospital->specialties as $specialty)
                <span class="badge {{ $specialty->badge_class }}">{{ $specialty->displayName() }}</span>
            @endforeach
        @endif
    </div>

    @if($hospital->is_jhd_supported && $hospital->specialties->isNotEmpty())
        <div class="hs-hospital-badges__jhd-specialties mt-2">
            <p class="hs-hospital-badges__jhd-label mb-1" id="jhd-specialties-{{ $hospital->id }}">
                {{ __('healthcare.specialty.jhd_supported') }}
            </p>
            <div class="d-flex flex-wrap gap-2" role="group" aria-labelledby="jhd-specialties-{{ $hospital->id }}">
                @foreach($hospital->specialties as $specialty)
                    <span class="badge {{ $specialty->badge_class }}">{{ $specialty->displayName() }}</span>
                @endforeach
            </div>
        </div>
    @endif
</div>
