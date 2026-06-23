<div class="hs-action-grid">
    <div class="row row-cols-2 row-cols-md-4 g-4 mt-2 justify-content-center">

        {{-- 1. 緊急（モーダル） --}}
        <div class="col">
            <button type="button"
                    class="hs-action-card"
                    data-bs-toggle="modal"
                    data-bs-target="#emergencyModal">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-truck-medical"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">緊急</p>
                </div>
            </button>
        </div>

        {{-- 2. 病院を探す --}}
        <div class="col">
            <a href="#search-section" class="hs-action-card">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-magnifying-glass-location"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">病院を探す</p>
                </div>
            </a>
        </div>

        {{-- 3. 病院一覧 --}}
        <div class="col">
            <a href="{{ route('healthcare.index') }}#hospital-list" class="hs-action-card">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-hospital"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">病院一覧</p>
                </div>
            </a>
        </div>

        {{-- 4. よくある状況 --}}
        <div class="col">
            <a href="#hsSituationAccordion" class="hs-action-card">
                <div class="hs-action-card__icon">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="hs-action-card__body">
                    <p class="hs-action-card__label">よくある状況</p>
                </div>
            </a>
        </div>

    </div>
</div>