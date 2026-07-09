<div class="d-grid gap-2">
    @if($hospital->isPartnerHospital())
        {{-- TODO: Grabルート実装後に差し替え --}}
        <a href="#" class="btn btn-outline-success fw-semibold">
            {{ __('healthcare.action.grab_go') }}
        </a>
        <button type="button"
                class="btn btn-outline-secondary">
            {{ __('healthcare.action.hospital_info') }}
        </button>
    @else
        @if($hospital->googleMapsDirectionsUrl())
            <a href="{{ $hospital->googleMapsDirectionsUrl() }}"
               class="btn btn-outline-success fw-semibold hs-map-link"
               data-loader-text="{{ __('healthcare.map.loading') }}"
               target="_blank"
               rel="noopener noreferrer">
                {{ __('healthcare.action.grab_go') }}
            </a>
        @elseif($hospital->googleMapsUrl())
            <a href="{{ $hospital->googleMapsUrl() }}"
               class="btn btn-outline-success fw-semibold hs-map-link"
               data-loader-text="{{ __('healthcare.map.loading') }}"
               target="_blank"
               rel="noopener noreferrer">
                <i class="fa-solid fa-map-location-dot me-1" aria-hidden="true"></i>{{ __('healthcare.action.view_map') }}
            </a>
        @endif
        <button type="button"
                class="btn btn-outline-secondary">
            {{ __('healthcare.action.hospital_info') }}
        </button>
    @endif
</div>
