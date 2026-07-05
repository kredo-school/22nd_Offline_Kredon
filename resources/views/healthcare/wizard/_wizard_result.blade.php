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

        <header class="hs-wizard-result__header mb-3">
            <h3 class="fw-bold mb-2">{{ __('healthcare.wizard.recommend_title') }}</h3>
            <p class="text-muted mb-1">{{ __('healthcare.wizard.recommend_lead') }}</p>
            <p class="small text-muted mb-0">{{ __('healthcare.wizard.disclaimer') }}</p>
        </header>

        @if(!empty($reasons))
            <div class="hs-wizard-result__reasons mb-4">
                <p class="fw-semibold small mb-2">{{ __('healthcare.wizard.reasons_heading') }}</p>
                <ul class="list-unstyled mb-0 hs-wizard-result__reason-list">
                    @foreach($reasons as $reason)
                        <li>{{ $reason }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($hospital)
            <div class="hs-wizard-result__highlight position-relative">
                <span class="badge hs-wizard-result__badge">{{ __('healthcare.wizard.recommended_badge') }}</span>
                @include('healthcare.wizard._wizard_result_card', ['hospital' => $hospital])
            </div>
        @else
            <p class="text-muted mb-0">{{ __('healthcare.wizard.no_result') }}</p>
        @endif

    </div>

</section>
