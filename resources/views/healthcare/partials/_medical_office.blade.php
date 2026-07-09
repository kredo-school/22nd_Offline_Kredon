@php
    $officeBadge = $medicalOfficeStatus['office'];
    $doctorStatus = $medicalOfficeStatus['doctor'];
    $isClosed = $clinic->is_closed;

    if (in_array($doctorStatus['type'], ['success', 'info'], true) && ! $isClosed) {
        $doctorCurrentStatus = __('healthcare.medical_office.doctor_status_in_session');
        $doctorCurrentStatusClass = 'success';
    } else {
        $doctorCurrentStatus = __('healthcare.medical_office.doctor_status_absent');
        $doctorCurrentStatusClass = 'secondary';
    }

    $nextDoctorVisit = $medicalOfficeStatus['next_doctor_visit'];
@endphp

<div class="hs-medical-office-section mt-4">

    <p class="hs-section-band">
        {{ __('healthcare.medical_office.section_band') }}
    </p>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden hs-medical-office-card">

        <div class="card-body p-4 hs-medical-office">

            <h4 class="fw-bold mb-3">
                <i class="fa-solid fa-user-nurse text-success me-2" aria-hidden="true"></i>
                {{ __('healthcare.medical_office.title') }}
            </h4>

            <div class="hs-medical-office__availability rounded-4 p-3 mb-3">
                <p class="fs-5 fw-bold mb-1 {{ $isClosed ? 'text-danger' : 'text-success' }}">
                    {{ $isClosed
                        ? __('healthcare.medical_office.availability_title_closed')
                        : __('healthcare.medical_office.availability_title_open') }}
                </p>
                <p class="small text-muted mb-0">
                    {{ $isClosed
                        ? __('healthcare.medical_office.availability_subtitle_closed')
                        : __('healthcare.medical_office.availability_subtitle_open') }}
                </p>
            </div>

            <div class="alert hs-medical-office__alert py-2 px-3 mb-4 small">
                <i class="fa-solid fa-circle-exclamation me-1" aria-hidden="true"></i>
                {{ __('healthcare.medical_office.alert_body') }}
            </div>

            <div class="mb-4">
                <span class="badge hs-medical-office__status-badge {{ $officeBadge['badge_class'] }}">
                    {{ $officeBadge['label'] }}
                </span>
            </div>

            <div class="row g-3 align-items-stretch hs-medical-office__box-row">

                <div class="col-md-6 d-flex">
                    <div class="hs-medical-office__box rounded-4 w-100">
                        <h6 class="hs-medical-office__heading">
                            <i class="fa-solid fa-clock me-2" aria-hidden="true"></i>
                            {{ __('healthcare.medical_office.hours_title') }}
                        </h6>
                        <p class="hs-medical-office__hours-value mb-4">
                            {{ __('healthcare.medical_office.hours_value') }}
                        </p>

                        <h6 class="hs-medical-office__heading hs-medical-office__heading--spaced">
                            <i class="fa-solid fa-clipboard-check me-2" aria-hidden="true"></i>
                            {{ __('healthcare.medical_office.services_title') }}
                        </h6>
                        <ul class="list-unstyled mb-0 hs-medical-office__services">
                            <li>
                                <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                                {{ __('healthcare.medical_office.service_consultation') }}
                            </li>
                            <li>
                                <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                                {{ __('healthcare.medical_office.service_first_aid') }}
                            </li>
                            <li>
                                <i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i>
                                {{ __('healthcare.medical_office.service_referral') }}
                            </li>
                            <li>
                                <i class="fa-solid fa-circle-xmark text-danger me-2" aria-hidden="true"></i>
                                {{ __('healthcare.medical_office.service_diagnosis') }}
                            </li>
                            <li>
                                <i class="fa-solid fa-circle-xmark text-danger me-2" aria-hidden="true"></i>
                                {{ __('healthcare.medical_office.service_prescription') }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6 d-flex">
                    <div class="hs-medical-office__box rounded-4 w-100">
                        <h6 class="hs-medical-office__heading">
                            <i class="fa-solid fa-user-doctor me-2" aria-hidden="true"></i>
                            {{ __('healthcare.medical_office.doctor_hours_title') }}
                        </h6>

                        <p class="small text-muted mb-1">{{ __('healthcare.medical_office.doctor_current_label') }}</p>
                        <p @class([
                            'hs-medical-office__status-message',
                            'hs-medical-office__status-message--' . $doctorCurrentStatusClass,
                            'mb-3',
                        ])>
                            {{ $doctorCurrentStatus }}
                        </p>

                        <p class="small text-muted mb-1">{{ __('healthcare.medical_office.doctor_next_visit_label') }}</p>
                        <p class="hs-medical-office__visit-time mb-3">{{ $nextDoctorVisit }}</p>

                        <div class="hs-medical-office__schedule-divider">
                            <p class="hs-medical-office__schedule-heading">
                                <i class="fa-solid fa-calendar-days me-2" aria-hidden="true"></i>
                                {{ __('healthcare.medical_office.schedule_heading') }}
                            </p>
                        </div>

                        <dl class="hs-medical-office__visit-schedule mb-0">
                            <dt class="hs-medical-office__visit-label">{{ __('healthcare.medical_office.schedule_mwf') }}</dt>
                            <dd class="hs-medical-office__visit-line">{{ __('healthcare.medical_office.doctor_visit_time_mwf') }}</dd>
                            <dt class="hs-medical-office__visit-label">{{ __('healthcare.medical_office.schedule_tt') }}</dt>
                            <dd class="hs-medical-office__visit-line">{{ __('healthcare.medical_office.doctor_visit_time_tt') }}</dd>
                            <dt class="hs-medical-office__visit-label">{{ __('healthcare.medical_office.schedule_weekend') }}</dt>
                            <dd class="hs-medical-office__visit-line">{{ __('healthcare.medical_office.schedule_none') }}</dd>
                        </dl>
                    </div>
                </div>

            </div>

            @if($isClosed)
                <div class="hs-medical-office__cta mt-4">
                    <a href="#search-section" class="btn btn-success w-100 fw-semibold">
                        {{ __('healthcare.medical_office.cta_find_hospital') }}
                        <i class="fa-solid fa-arrow-right ms-1" aria-hidden="true"></i>
                    </a>
                </div>
            @endif

        </div>

    </div>

</div>
