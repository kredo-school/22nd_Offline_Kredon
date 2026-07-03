@php
    $progressPercent = $totalSteps > 0 ? round(($step / $totalSteps) * 100) : 0;
@endphp

<div class="card shadow-sm border-0 rounded-4 hs-wizard-card">
    <div class="card-body p-4 p-5">

        <div class="hs-wizard-progress mb-4">
            <div class="d-flex justify-content-between align-items-center small text-muted mb-2">
                <span>{{ __('healthcare.wizard.step_label', ['step' => $step]) }}</span>
                <span>{{ __('healthcare.wizard.total_steps_count', ['total' => $totalSteps]) }}</span>
            </div>

            <div class="progress hs-wizard-progress__bar rounded-pill"
                 role="progressbar"
                 aria-valuenow="{{ $step }}"
                 aria-valuemin="1"
                 aria-valuemax="{{ $totalSteps }}"
                 aria-label="{{ __('healthcare.wizard.progress_label', ['step' => $step, 'total' => $totalSteps]) }}">
                <div class="progress-bar bg-success"
                     style="width: {{ $progressPercent }}%;">
                </div>
            </div>

            <div class="hs-wizard-progress__dots" aria-hidden="true">
                @for($i = 1; $i <= $totalSteps; $i++)
                    <span class="hs-wizard-progress__dot {{ $i <= $step ? 'is-active' : '' }} {{ $i < $step ? 'is-complete' : '' }}"></span>
                @endfor
            </div>
        </div>

        <h2 class="fw-bold mb-3">
            {{ $question }}
        </h2>

        <p class="text-muted mb-4">
            {{ __('healthcare.wizard.intro') }}
        </p>

        <form action="{{ route('wizard.step.store', $step) }}" method="POST">
            @csrf
            <div class="d-grid gap-3">
                @foreach($options as $key => $label)
                    <button type="submit"
                            name="answer"
                            value="{{ $key }}"
                            class="btn text-start rounded-4 p-4 hs-wizard__option {{ ($selectedAnswer ?? null) === $key ? 'hs-wizard__option--selected' : '' }}">
                        <div class="fw-semibold">
                            {{ $label }}
                        </div>
                        <small class="text-muted">
                            {{ __('healthcare.wizard.select_hint') }}
                        </small>
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
                            {{ __('healthcare.wizard.info_hint') }}
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
                            <p class="small text-muted mt-3 mb-0">
                                {{ __('healthcare.wizard.info_continue') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="hs-wizard-nav mt-4 pt-2">
            @if($step > 1)
                @if($embedded ?? false)
                    <a href="{{ route('healthcare.index', ['wizard_back' => $step - 1]) }}#search-section"
                       class="btn btn-link text-muted text-decoration-none px-0 hs-wizard-nav__back">
                        <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>
                        {{ __('healthcare.wizard.back') }}
                    </a>
                @else
                    <a href="{{ route('wizard.step', ['step' => $step - 1]) }}"
                       class="btn btn-link text-muted text-decoration-none px-0 hs-wizard-nav__back">
                        <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>
                        {{ __('healthcare.wizard.back') }}
                    </a>
                @endif
            @elseif($embedded ?? false)
                <a href="#hero"
                   class="btn btn-link text-muted text-decoration-none px-0 hs-wizard-nav__back">
                    <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>
                    {{ __('healthcare.wizard.back_to_top') }}
                </a>
            @else
                <a href="{{ route('healthcare.index') }}"
                   class="btn btn-link text-muted text-decoration-none px-0 hs-wizard-nav__back">
                    <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>
                    {{ __('healthcare.wizard.back_to_healthcare') }}
                </a>
            @endif
        </div>

    </div>
</div>
