<div class="d-flex flex-wrap gap-2 mb-3">
    @if($hospital->is_jhd_supported)
        <span class="badge bg-success-subtle text-success">{{ __('healthcare.badge.jhd') }}</span>
    @endif
    @if($hospital->is_clinic)
        <span class="badge bg-info-subtle text-info">{{ __('healthcare.badge.clinic') }}</span>
    @else
        <span class="badge bg-primary-subtle text-primary">{{ __('healthcare.badge.hospital') }}</span>
    @endif
    @foreach($hospital->specialties as $specialty)
        <span class="badge {{ $specialty->badge_class }}">{{ $specialty->displayName() }}</span>
    @endforeach
</div>
