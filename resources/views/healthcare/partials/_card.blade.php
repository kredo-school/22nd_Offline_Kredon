<div id="hospital-list" class="row g-4 mt-4">
    @foreach($hospitals as $hospital)
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden hs-card-bg hs-card">
            <div class="hs-image-container hs-image-container--gallery">
                @include('healthcare.partials._hospital_gallery', ['hospital' => $hospital])

                <button type="button"
                        class="hs-btn-bookmark {{ $hospital->isBookmarkedBy(auth()->user()) ? 'is-active' : '' }}"
                        aria-label="ブックマーク"
                        data-id="{{ $hospital->id }}"
                        data-type="App\Models\Hospital">
                    <i class="fa-solid fa-bookmark"></i>
                </button>
            </div>

            <div class="card-body p-4">
                @include('healthcare.partials._hospital_badges', ['hospital' => $hospital])

                <h5 class="fw-bold mb-3">{{ $hospital->short_name ?? $hospital->name }}</h5>

                <div class="small text-muted mb-2">
                    @if($hospital->duration_grab)
                        <div class="mb-2"><i class="fa-solid fa-car me-2"></i>{{ __('healthcare.travel.grab', ['minutes' => $hospital->duration_grab]) }}</div>
                    @endif
                    @if($hospital->duration_walk)
                        <div class="mb-2"><i class="fa-solid fa-person-walking me-2"></i>{{ __('healthcare.travel.walk', ['minutes' => $hospital->duration_walk]) }}</div>
                    @endif
                </div>

                @include('healthcare.partials._hospital_hours', ['hospital' => $hospital])

                @if($hospital->guideTips())
                    <div class="alert alert-light border small mb-3 mt-3">
                        {{ $hospital->guideTips() }}
                    </div>
                @endif

                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-secondary">{{ __('healthcare.action.details') }}</a>
                    @if(!$hospital->is_clinic && $hospital->grab_link)
                        <a href="{{ $hospital->grab_link }}"
                           class="btn btn-success fw-bold hs-grab-link"
                           data-loader-text="{{ __('healthcare.grab.loading') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <i class="fa-solid fa-location-arrow me-1"></i>{{ __('healthcare.action.grab') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.hs-gallery.carousel').forEach((carouselEl) => {
            carouselEl.addEventListener('slid.bs.carousel', (event) => {
                const counter = carouselEl.querySelector('.hs-gallery__counter-current');
                if (counter) {
                    counter.textContent = event.to + 1;
                }
            });
        });
    });
</script>
@endpush
