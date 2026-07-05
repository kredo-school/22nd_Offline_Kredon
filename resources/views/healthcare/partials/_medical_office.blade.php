@php
    use Carbon\Carbon;

    $officeBadge = $medicalOfficeStatus['office'];
    $today = Carbon::now('Asia/Manila')->dayOfWeek;
    $hasVisitToday = in_array($today, [1, 2, 3, 4, 5], true);
@endphp

<div class="hs-medical-office-section mt-4">

    <p class="hs-section-band">
        {{ __('healthcare.medical_office.section_band') }}
    </p>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden hs-medical-office-card">

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

        <div class="row g-3 align-items-stretch hs-medical-office__box-row">

            <div class="col-md-6 d-flex">

                <div class="hs-medical-office__box rounded-4 w-100">

                    <h6 class="hs-medical-office__heading">
                        {{ __('healthcare.medical_office.hours_title') }}
                    </h6>

                    <p class="hs-medical-office__hours-value mb-0">
                        {{ __('healthcare.medical_office.hours_value') }}
                    </p>

                </div>

            </div>

            <div class="col-md-6 d-flex">

                <div class="hs-medical-office__box rounded-4 w-100 {{ $hasVisitToday ? 'hs-medical-office__box--active' : '' }}">

                    <h6 class="hs-medical-office__heading">
                        {{ __('healthcare.medical_office.doctor_hours_title') }}
                    </h6>

                    @if(in_array($today, [1, 3, 5], true))
                        <div class="hs-medical-office__today-status mb-3">
                            <span class="hs-medical-office__visit-badge">✅ 本日訪問あり</span>
                            <span class="hs-medical-office__visit-time">13:00〜17:00</span>
                        </div>
                    @elseif(in_array($today, [2, 4], true))
                        <div class="hs-medical-office__today-status mb-3">
                            <span class="hs-medical-office__visit-badge">✅ 本日訪問あり</span>
                            <span class="hs-medical-office__visit-time">10:00〜12:00</span>
                        </div>
                    @else
                        <p class="hs-medical-office__no-visit mb-3">本日訪問なし</p>
                    @endif

                    <div class="hs-medical-office__schedule-divider">
                        <p class="hs-medical-office__schedule-heading">📅 医師訪問スケジュール</p>
                    </div>

                    <dl class="hs-medical-office__visit-schedule mb-0">
                        <dt class="hs-medical-office__visit-label">月・水・金</dt>
                        <dd class="hs-medical-office__visit-line">13:00 〜 17:00</dd>
                        <dt class="hs-medical-office__visit-label">火・木</dt>
                        <dd class="hs-medical-office__visit-line">10:00 〜 12:00</dd>
                        <dt class="hs-medical-office__visit-label">土・日</dt>
                        <dd class="hs-medical-office__visit-line">訪問なし</dd>
                    </dl>

                    @if($clinic->is_closed)
                        <p class="hs-medical-office__next-step-hint">
                            {{ __('healthcare.medical_office.closed_next_step_hint') }}
                        </p>
                    @endif

                </div>

            </div>

        </div>

    </div>

    </div>

</div>
