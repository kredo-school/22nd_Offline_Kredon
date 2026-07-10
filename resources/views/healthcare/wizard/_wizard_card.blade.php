<div class="card shadow-sm border-0 rounded-4 hs-wizard-card">
    <div class="card-body p-4 p-5">

        <div class="hs-wizard-progress mb-4">
            <div class="small text-muted mb-2">
                {{ __('healthcare.wizard.progress_label', ['step' => $step, 'total' => $totalSteps]) }}
            </div>

            <div @class([
                'progress hs-wizard-progress__bar rounded-pill',
                'hs-wizard-progress__bar--step-' . $step,
            ])
                 role="progressbar"
                 aria-valuenow="{{ $step }}"
                 aria-valuemin="1"
                 aria-valuemax="{{ $totalSteps }}"
                 aria-label="{{ __('healthcare.wizard.progress_label', ['step' => $step, 'total' => $totalSteps]) }}">
                <div class="progress-bar bg-success"></div>
            </div>
        </div>

        <h2 class="fw-bold mb-3">
            {{ $question }}
        </h2>

        <p class="text-muted mb-4">
            @if(!empty($subtitle))
                {{ $subtitle }}
            @else
                {{ __('healthcare.wizard.intro') }}
            @endif
        </p>

        <form action="{{ route('wizard.step.store', $step) }}" method="POST">
            @csrf
            <div @class([
                'hs-wizard__options',
                'hs-wizard__options--step1' => $step === 1,
                'd-grid gap-3' => $step !== 1,
            ])>
                @foreach($options as $key => $option)
                    @php
                        $optionLabel = is_array($option) ? $option['label'] : $option;
                        $optionSubtitle = is_array($option) ? ($option['subtitle'] ?? null) : null;
                    @endphp
                    <button type="submit"
                            name="answer"
                            value="{{ $key }}"
                            class="btn text-start rounded-4 p-4 hs-wizard__option {{ ($selectedAnswer ?? null) === $key ? 'hs-wizard__option--selected' : '' }}">
                        <div class="fw-semibold">
                            {{ $optionLabel }}
                        </div>
                        @if($optionSubtitle)
                            <small @class([
                                'text-muted d-block mt-1 hs-wizard__option-sub',
                                'hs-wizard__option-sub--bullets' => $step === 1,
                            ])>
                                @if($step === 1)
                                    {!! nl2br(e($optionSubtitle)) !!}
                                @else
                                    {{ $optionSubtitle }}
                                @endif
                            </small>
                        @endif
                    </button>
                @endforeach
            </div>
        </form>

        @if(!empty($infoOptions ?? []))
            <div class="d-grid gap-3 mt-3">
                @foreach($infoOptions as $info)
                    @php
                        $infoTargetId = 'wizard-info-' . $step . '-' . $info['key'];
                    @endphp

                    <button type="button"
                            class="btn text-start rounded-4 p-4 hs-wizard__option hs-wizard__option--info"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $infoTargetId }}"
                            aria-expanded="false"
                            aria-controls="{{ $infoTargetId }}">
                        <div class="fw-semibold">
                            <i class="fa-solid fa-circle-question me-2 text-muted" aria-hidden="true"></i>
                            {{ $info['label'] }}
                        </div>
                        <small class="text-muted">
                            {{ $info['hint'] ?? __('healthcare.wizard.info_hint') }}
                        </small>
                    </button>

                    <div class="collapse" id="{{ $infoTargetId }}">
                        <div class="hs-wizard__info-panel">
                            <p class="hs-wizard__info-question fw-semibold mb-2">
                                {{ $info['question'] }}
                            </p>
                            <div class="hs-faq-answer rounded-3">
                                {!! nl2br(e($info['answer'])) !!}
                            </div>
                            @if($step === 3 && $info['key'] === 'unknown')
                                <p class="small text-muted mt-2 mb-0">
                                    {{ __('healthcare.wizard.step3.jhd_note') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($step > 1)
            <div class="hs-wizard-nav mt-4 pt-2">
                <a href="{{ route('healthcare.index', ['wizard_back' => $step - 1]) }}#search-section"
                   class="btn btn-link text-muted text-decoration-none px-0 hs-wizard-nav__back">
                    <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>
                    {{ __('healthcare.wizard.back') }}
                </a>
            </div>
        @endif

    </div>
</div>
