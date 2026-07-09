<div class="card border-0 shadow-sm rounded-4 overflow-hidden hs-card-bg hs-card hs-wizard-result__compare-card">
    <div class="hs-image-container hs-image-container--gallery">
        @include('healthcare.partials._hospital_gallery', ['hospital' => $hospital])

        <button type="button"
                class="hs-btn-bookmark {{ $hospital->isBookmarkedBy(auth()->user()) ? 'is-active' : '' }}"
                aria-label="{{ __('healthcare.action.bookmark') }}"
                data-id="{{ $hospital->id }}"
                data-type="App\Models\Hospital">
            <i class="fa-solid fa-bookmark"></i>
        </button>
    </div>

    <div class="card-body p-4">
        @include('healthcare.partials._hospital_badges', ['hospital' => $hospital])

        <h5 class="fw-bold mb-3">{{ $hospital->short_name ?? $hospital->name }}</h5>

        @if(!empty($pros))
            <div class="hs-wizard-result__pros mb-3">
                <p class="hs-wizard-result__section-heading mb-2">{{ __('healthcare.wizard.pros_heading') }}</p>
                <ul class="list-unstyled mb-0 hs-wizard-result__point-list">
                    @foreach($pros as $pro)
                        <li>{{ $pro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!empty($notes))
            <div class="hs-wizard-result__notes mb-3">
                <p class="hs-wizard-result__section-heading mb-2">{{ __('healthcare.wizard.notes_heading') }}</p>
                <ul class="list-unstyled mb-0 hs-wizard-result__point-list">
                    @foreach($notes as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
