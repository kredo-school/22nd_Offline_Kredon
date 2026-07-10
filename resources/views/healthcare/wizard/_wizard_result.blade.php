<section id="wizard-result"
         class="hs-wizard-result mb-4 hs-section"
         data-animate="true"
         data-loading-messages="{{ json_encode([
             __('healthcare.wizard.loading_checking'),
             __('healthcare.wizard.loading_searching'),
             __('healthcare.wizard.loading_selecting'),
         ], JSON_UNESCAPED_UNICODE) }}">

    <div class="hs-wizard-result__loading text-center py-5" aria-live="polite">
        <div class="spinner-border text-success mb-3" role="status">
            <span class="visually-hidden">{{ __('healthcare.wizard.loading_checking') }}</span>
        </div>

        <div class="progress hs-wizard-result__progress rounded-pill mx-auto mb-3">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success hs-wizard-result__progress-bar"
                 role="progressbar"
                 style="width: 0%"
                 aria-valuenow="0"
                 aria-valuemin="0"
                 aria-valuemax="100"></div>
        </div>

        <p class="hs-wizard-result__loading-text text-muted mb-0 fw-semibold">
            {{ __('healthcare.wizard.loading_checking') }}
        </p>
    </div>

    <div class="hs-wizard-result__content" hidden>

        <header class="hs-wizard-result__header mb-4">
            <h3 class="fw-bold mb-2">{{ __('healthcare.wizard.recommend_title') }}</h3>
            <p class="text-muted mb-1">{{ __('healthcare.wizard.recommend_lead') }}</p>
            <p class="small text-muted mb-0">{{ __('healthcare.wizard.disclaimer') }}</p>
        </header>

        @if(!empty($resultItems))
            <div class="hs-wizard-result__compare-list">
                @foreach($resultItems as $item)
                    @include('healthcare.wizard._wizard_result_compare_card', [
                        'hospital' => $item['hospital'],
                        'pros' => $item['pros'] ?? [],
                        'notes' => $item['notes'] ?? [],
                    ])
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">{{ __('healthcare.wizard.no_result') }}</p>
        @endif

        <div class="hs-wizard-nav mt-4 pt-2">
            <a href="{{ route('wizard.start') }}"
               class="btn btn-link text-muted text-decoration-none px-0 hs-wizard-nav__back">
                <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>
                {{ __('healthcare.wizard.back_to_step1') }}
            </a>
        </div>

    </div>

</section>
