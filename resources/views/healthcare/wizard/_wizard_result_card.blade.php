<div class="card border-0 shadow-sm rounded-4 overflow-hidden hs-card-bg hs-card">
    <div class="hs-image-container hs-image-container--gallery">
        @include('healthcare.partials._hospital_gallery', ['hospital' => $hospital])

        <button type="button"
                class="hs-btn-bookmark {{ $hospital->isBookmarkedBy(auth()->user()) ? 'is-active' : '' }}"
                aria-label="{{ __('healthcare.action.bookmark') }}"
                data-id="{{ $hospital->id }}"
                data-type="App\Models\Hospital">
            <i class="fa-solid fa-bookmark"></i>
        </button>

        <span class="badge hs-wizard-result__badge">{{ __('healthcare.wizard.recommended_badge') }}</span>
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

        @include('healthcare.partials._hospital_guide_tips', ['hospital' => $hospital])

        @include('healthcare.partials._hospital_card_actions', ['hospital' => $hospital])
    </div>
</div>
