<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-5">
        {{-- progress --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between small text-muted mb-2">
                <span>STEP {{ $step }}</span>
                <span>3 STEP</span>
            </div>

            <div class="progress rounded-pill" style="height: 8px;">
                <div class="progress-bar bg-success"
                     role="progressbar"
                     style="width: {{ ($step / 3) * 100 }}%;"
                     aria-valuenow="{{ $step }}"
                     aria-valuemin="0"
                     aria-valuemax="3">
                </div>
            </div>
        </div>

        <h2 class="fw-bold mb-3">
            {{ $question }}
        </h2>

        <p class="text-muted mb-4">
            あなたの状況に合わせて
            適切なサポートをご案内します。
        </p>

        <form action="{{ route('wizard.step.store', $step) }}" method="POST">
            @csrf
            <div class="d-grid gap-3">
                @foreach($options as $key => $label)
                    <button type="submit"
                            name="answer"
                            value="{{ $key }}"
                            class="btn text-start rounded-4 p-4"
                            style="border: 1px solid #d8e6df; background: #fff;">
                        <div class="fw-semibold">
                            {{ $label }}
                        </div>
                        <small class="text-muted">
                            選択してください
                        </small>
                    </button>
                @endforeach
            </div>
        </form>
    </div>
</div>
