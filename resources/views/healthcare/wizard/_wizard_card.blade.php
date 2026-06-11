<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-5">
        <h3 class="mb-4 text-secondary fw-bold">{{ $question}}</h3>

        <form action="{{ route('wizard.step', $step) }}" method="POST">
            @csrf
            <div class="d-grid gap-3">
                @foreach($options as $key => $label)
                <button type="submit" 
                        name="answer"
                        value="{{ $key }}"
                        class="btn btn-outline-success btn-lg py-3  rounded-3"
                        style="border-width: 2px; font-weight:600px;">
                    {{ $label }}
                </button>
                @endforeach
            </div>
        </form>

        <div class="mt-4 text-center text-muted small">
            ステップ{{ $step }} / 3
        </div>
    </div>
</div>