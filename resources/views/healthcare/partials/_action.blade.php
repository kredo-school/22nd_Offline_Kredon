<div class="hs-action-grid">
    <div class="row row-cols-2 row-cols-md-4 g-4 mt-2 justify-content-center">

        <div class="col">
            <button type="button"
                    class="hs-action-card hs-action-card--emergency"
                    data-bs-toggle="modal"
                    data-bs-target="#emergencyModal">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-truck-medical"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">{{ __('healthcare.action.emergency') }}</p>
                </div>
            </button>
        </div>

        <div class="col">
            <a href="#search-section" class="hs-action-card">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-magnifying-glass-location"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">{{ __('healthcare.action.find_hospital') }}</p>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('healthcare.index') }}#hospital-list" class="hs-action-card">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-hospital"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">{{ __('healthcare.action.hospital_list') }}</p>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="#hsSituationAccordion" class="hs-action-card">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">{{ __('healthcare.action.common_situations') }}</p>
                </div>
            </a>
        </div>

    </div>
</div>
