@php
    $officeBadge = $medicalOfficeStatus['office'];
    $doctorStatus = $medicalOfficeStatus['doctor'];
    $doctorIsVisiting = in_array($doctorStatus['type'], ['success', 'info'], true);
    $officeIsOpen = $officeBadge['badge_class'] === 'bg-success';
    $showFindHospitalHint = !$officeIsOpen || !$doctorIsVisiting;
@endphp

<div class="hs-medical-office-section mt-4">

    <p class="hs-section-band">
        {{ __('healthcare.medical_office.section_band') }}
    </p>

    <div class="card border-0 shadow-sm rounded-4 hs-medical-office-card">

    <div class="card-body p-4 hs-medical-office">

        <h4 class="fw-bold mb-3">
            <i class="fa-solid fa-user-nurse text-success me-2"></i>
            {{ __('healthcare.medical_office.title') }}
        </h4>

        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">

            <span class="badge hs-medical-office__nurse-badge">
                <i class="fa-solid fa-user-md me-1"></i>
                {{ __('healthcare.medical_office.nurse_badge') }}
            </span>

            <span class="badge hs-medical-office__status-badge {{ $officeBadge['badge_class'] }}">
                {{ $officeBadge['label'] }}
            </span>

        </div>

        <p class="text-muted mb-4">
            {{ __('healthcare.medical_office.intro') }}
        </p>

        <div class="alert hs-medical-office__alert py-2 px-3 mb-4 small">

            <i class="fa-solid fa-circle-exclamation me-1"></i>

            <strong>{{ __('healthcare.medical_office.alert_label') }}</strong>

            {{ __('healthcare.medical_office.alert_body') }}

        </div>

        @if($showFindHospitalHint)
            <div class="alert alert-light border small mb-4">
                <i class="fa-solid fa-circle-info me-1 text-muted" aria-hidden="true"></i>
                {{ __('healthcare.medical_office.find_hospital_hint_before') }}
                <a href="#search-section" class="fw-semibold">{{ __('healthcare.action.find_hospital') }}</a>{{ __('healthcare.medical_office.find_hospital_hint_after') }}
            </div>
        @endif

        <div class="row g-3">

            <div class="col-md-6">

                <div class="hs-medical-office__box">

                    <h6 class="hs-medical-office__heading">
                        {{ __('healthcare.medical_office.hours_title') }}
                    </h6>

                    {{ __('healthcare.medical_office.hours_value') }}

                </div>

            </div>

            <div class="col-md-6">

                <div class="hs-medical-office__box {{ $doctorIsVisiting ? 'hs-medical-office__box--active' : '' }}">

                    <h6 class="hs-medical-office__heading">
                        {{ __('healthcare.medical_office.doctor_hours_title') }}
                    </h6>

                    {{ $doctorStatus['message'] }}

                </div>

            </div>

        </div>

    </div>

    </div>

</div>
