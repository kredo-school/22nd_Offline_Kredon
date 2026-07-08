@php
    $inModal = $inModal ?? false;
    $isPartner = $hospital->isPartnerHospital();
    $showDocuments = $isPartner && $hospital->is_jhd_supported;
@endphp

@if(!$inModal)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden hs-hospital-detail">
        <div class="hs-image-container hs-image-container--gallery">
            @include('healthcare.partials._hospital_gallery', ['hospital' => $hospital])
        </div>
        <div class="card-body p-4 p-md-5">
@endif

@if($isPartner)
    @include('healthcare.partials._hospital_badges', ['hospital' => $hospital])

    <h4 class="fw-bold mb-1">{{ $hospital->name }}</h4>

    @if($hospital->short_name && $hospital->short_name !== $hospital->name)
        <p class="text-muted small mb-3">{{ $hospital->short_name }}</p>
    @endif

    @if(!empty($recommendationReason))
        <p class="small text-success fw-semibold mb-3">
            <i class="fa-solid fa-circle-check me-1" aria-hidden="true"></i>{{ $recommendationReason }}
        </p>
    @endif

    <section class="hs-hospital-detail__section">
        <h6 class="fw-bold mb-3">{{ __('healthcare.hospital.overview_title') }}</h6>
        @if($hospital->address_en)
            <div class="small text-muted mb-2">
                <i class="fa-solid fa-location-dot me-2" aria-hidden="true"></i>{{ $hospital->address_en }}
            </div>
        @endif
        @if($hospital->duration_grab)
            <div class="small text-muted">
                <i class="fa-solid fa-car me-2" aria-hidden="true"></i>{{ __('healthcare.travel.grab', ['minutes' => $hospital->duration_grab]) }}
            </div>
        @endif
    </section>

    <section class="hs-hospital-detail__section">
        <h6 class="fw-bold mb-3">{{ __('healthcare.hospital.hours_title') }}</h6>
        @include('healthcare.partials._hospital_hours', ['hospital' => $hospital])
    </section>

    @if($hospital->is_jhd_supported && $hospital->specialties->isNotEmpty())
        <section class="hs-hospital-detail__section">
            <h6 class="fw-bold mb-3">{{ __('healthcare.hospital.specialties_title') }}</h6>
            <div class="d-flex flex-wrap gap-2">
                @foreach($hospital->specialties as $specialty)
                    <span class="badge {{ $specialty->badge_class }}">{{ $specialty->displayName() }}</span>
                @endforeach
            </div>
        </section>
    @endif

    @if($hospital->is_jhd_supported)
        <section class="hs-hospital-detail__section">
            <h6 class="fw-bold mb-3">{{ __('healthcare.hospital.jhd_usage_title') }}</h6>
            <ol class="small text-muted mb-3 ps-3 hs-hospital-detail__steps">
                <li>{{ __('healthcare.hospital.jhd_usage_step1') }}</li>
                <li>{{ __('healthcare.hospital.jhd_usage_step2') }}</li>
                <li>{{ __('healthcare.hospital.jhd_usage_step3') }}</li>
            </ol>
            @if($hospital->phone_number)
                <div class="small">
                    <span class="fw-semibold">{{ __('healthcare.jhd.contact_label') }}:</span>
                    <a href="tel:{{ preg_replace('/\s+/', '', $hospital->phone_number) }}"
                       class="text-decoration-none ms-1">
                        <i class="fa-solid fa-phone me-1" aria-hidden="true"></i>{{ $hospital->phone_number }}
                    </a>
                </div>
            @endif
            @if($hospital->guideTips())
                <p class="small text-muted mb-0 mt-2">{{ $hospital->guideTips() }}</p>
            @endif
        </section>

        <section class="hs-hospital-detail__section">
            <h6 class="fw-bold mb-3">{{ __('healthcare.hospital.cashless_flow_title') }}</h6>
            <ol class="small text-muted mb-0 ps-3 hs-hospital-detail__steps">
                <li>{{ __('healthcare.hospital.cashless_flow_step1') }}</li>
                <li>{{ __('healthcare.hospital.cashless_flow_step2') }}</li>
                <li>{{ __('healthcare.hospital.cashless_flow_step3') }}</li>
            </ol>
        </section>
    @endif

    @if($showDocuments)
        <section class="hs-hospital-detail__section">
            <div class="hs-hospital-detail__documents">
                <h6 class="fw-bold mb-3">{{ __('healthcare.wizard.documents_title') }}</h6>
                <ul class="list-unstyled mb-0 hs-hospital-detail__document-list">
                    <li class="hs-hospital-detail__document-item">
                        <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                        {{ __('healthcare.wizard.document_insurance') }}
                    </li>
                    <li class="hs-hospital-detail__document-item">
                        <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                        {{ __('healthcare.wizard.document_passport') }}
                    </li>
                    <li class="hs-hospital-detail__document-item">
                        <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                        {{ __('healthcare.wizard.document_departure') }}
                    </li>
                </ul>
                <p class="small text-muted mb-0 mt-3">
                    <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                    {{ __('healthcare.wizard.document_credit_notice') }}
                </p>
            </div>
        </section>
    @endif

    <section class="hs-hospital-detail__section">
        <h6 class="fw-bold mb-3">{{ __('healthcare.hospital.visit_flow_title') }}</h6>
        <ol class="small text-muted mb-0 ps-3 hs-hospital-detail__steps">
            <li>{{ __('healthcare.hospital.visit_flow_step1') }}</li>
            <li>{{ __('healthcare.hospital.visit_flow_step2') }}</li>
            <li>{{ __('healthcare.hospital.visit_flow_step3') }}</li>
            <li>{{ __('healthcare.hospital.visit_flow_step4') }}</li>
        </ol>
    </section>

    <div class="d-grid gap-2 mt-4">
        {{-- TODO: Grabルート実装後に差し替え --}}
        <a href="#" class="btn btn-outline-success fw-semibold">
            {{ __('healthcare.action.grab_go') }}
        </a>
        {{-- TODO: Google Mapルート実装後に差し替え --}}
        <a href="#" class="btn btn-outline-secondary">
            <i class="fa-solid fa-map-location-dot me-1" aria-hidden="true"></i>{{ __('healthcare.action.view_map') }}
        </a>
        @if(!empty($backUrl))
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>{{ __('healthcare.wizard.back_to_previous') }}
            </a>
        @endif
    </div>
@else
    @include('healthcare.partials._hospital_badges', ['hospital' => $hospital])

    <h4 class="fw-bold mb-1">{{ $hospital->name }}</h4>

    @if($hospital->short_name && $hospital->short_name !== $hospital->name)
        <p class="text-muted small mb-3">{{ $hospital->short_name }}</p>
    @endif

    @if(!empty($recommendationReason))
        <p class="small text-success fw-semibold mb-3">
            <i class="fa-solid fa-circle-check me-1" aria-hidden="true"></i>{{ $recommendationReason }}
        </p>
    @endif

    @if($hospital->address_en)
        <div class="small text-muted mb-2">
            <i class="fa-solid fa-location-dot me-2" aria-hidden="true"></i>{{ $hospital->address_en }}
        </div>
    @endif

    @if($hospital->phone_number && !$hospital->is_jhd_supported)
        <div class="small text-muted mb-3">
            <i class="fa-solid fa-phone me-2" aria-hidden="true"></i>
            <a href="tel:{{ preg_replace('/\s+/', '', $hospital->phone_number) }}" class="text-muted text-decoration-none">
                {{ $hospital->phone_number }}
            </a>
        </div>
    @endif

    <div class="small text-muted mb-3">
        @if($hospital->duration_grab)
            <div class="mb-2">
                <i class="fa-solid fa-car me-2" aria-hidden="true"></i>{{ __('healthcare.travel.grab', ['minutes' => $hospital->duration_grab]) }}
            </div>
        @endif
        @if($hospital->duration_walk)
            <div class="mb-2">
                <i class="fa-solid fa-person-walking me-2" aria-hidden="true"></i>{{ __('healthcare.travel.walk', ['minutes' => $hospital->duration_walk]) }}
            </div>
        @endif
    </div>

    @include('healthcare.partials._hospital_hours', ['hospital' => $hospital])

    @if($showJhdDocuments ?? false)
        <div class="hs-hospital-detail__documents mt-4">
            <h6 class="fw-bold mb-3">{{ __('healthcare.wizard.documents_title') }}</h6>
            <ul class="list-unstyled mb-0 hs-hospital-detail__document-list">
                <li class="hs-hospital-detail__document-item">
                    <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                    {{ __('healthcare.wizard.document_insurance') }}
                </li>
                <li class="hs-hospital-detail__document-item">
                    <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                    {{ __('healthcare.wizard.document_passport') }}
                </li>
                <li class="hs-hospital-detail__document-item">
                    <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                    {{ __('healthcare.wizard.document_departure') }}
                </li>
            </ul>
            <p class="small text-muted mb-0 mt-3">
                <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                {{ __('healthcare.wizard.document_credit_notice') }}
            </p>
        </div>
    @endif

    @include('healthcare.partials._hospital_guide_tips', [
        'hospital' => $hospital,
        'boxClass' => 'mb-0 mt-4',
    ])

    @if($hospital->googleMapsUrl() || !empty($backUrl))
        <div class="d-grid gap-2 mt-4">
            @if($hospital->googleMapsUrl())
                <a href="{{ $hospital->googleMapsUrl() }}"
                   class="btn btn-outline-success fw-semibold hs-map-link"
                   data-loader-text="{{ __('healthcare.map.loading') }}"
                   target="_blank"
                   rel="noopener noreferrer">
                    <i class="fa-solid fa-map-location-dot me-1" aria-hidden="true"></i>{{ __('healthcare.action.view_map') }}
                </a>
            @endif

            @if(!empty($backUrl))
                <a href="{{ $backUrl }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>{{ __('healthcare.wizard.back_to_previous') }}
                </a>
            @endif
        </div>
    @endif
@endif

@if(!$inModal)
        </div>
    </div>
@endif
