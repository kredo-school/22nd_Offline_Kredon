@push('modals')
    @foreach($hospitals->filter(fn ($h) => $h->isPartnerHospital()) as $hospital)
        <div class="modal fade"
             id="hospitalDetailModal-{{ $hospital->id }}"
             tabindex="-1"
             aria-labelledby="hospitalDetailModalTitle-{{ $hospital->id }}"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="hospitalDetailModalTitle-{{ $hospital->id }}">
                            {{ $hospital->short_name ?? $hospital->name }}
                        </h5>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="{{ __('healthcare.emergency.close') }}">
                        </button>
                    </div>
                    <div class="modal-body pt-2">
                        @include('healthcare.partials._hospital_detail', [
                            'hospital' => $hospital,
                            'inModal' => true,
                        ])
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush
