<div class="container" style="max-width: 800px;">
    <div class="row row-cols-2 row-cols-md-4 g-4 mt-2 justify-content-center">
        {{-- 1. 緊急 (モーダル) --}}
        <div class="col">
            <button type="button" 
                    class="card h-100 w-100 border rounded-4 shadow-sm p-0 border-0" 
                    data-bs-toggle="modal" 
                    data-bs-target="#emergencyModal">
                <div class="text-center py-4" style="background-color:#F1F4F2;">
                    <i class="fa-solid fa-truck-medical fa-3x" style="color:#0ea58a;"></i>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold text-center text-dark mb-0">緊急</h5>
                </div>
            </button>
        </div>

        {{-- 2. 医療機関を探す --}}
        <div class="col">
            <a href="#search-section" class="text-decoration-none">
                <div class="card h-100 w-100 border rounded-4 shadow-sm border-0">
                    <div class="text-center py-4" style="background-color:#F1F4F2;">

                        <i class="fa-solid fa-magnifying-glass-location fa-3x" style="color:#0ea58a;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold text-center text-dark mb-0">病院を探す
                        </h5>
                    </div>
                </div>
            </a>
        </div>

        {{-- 3. リピーター --}}
        <div class="col">
            <a href="{{ route('healthcare.index') }}#hospital-list" class="text-decoration-none">
                <div class="card h-100 w-100 border rounded-4 shadow-sm border-0">
                    <div class="text-center py-4" style="background-color:#F1F4F2;">
                        <i class="fa-solid fa-hospital fa-3x"  style="color:#0ea58a;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold text-center text-dark mb-0">病院一覧
                        </h5>
                    </div>
                </div>
            </a>
        </div>

        {{-- 4. その他 --}}
        <div class="col">
            <a href="#hsSituationAccordion" class="text-decoration-none">
                <div class="card h-100 w-100 border rounded-4 shadow-sm border-0">
                    <div class="text-center py-4" style="background-color:#F1F4F2;">
                        <i class="fa-solid fa-plus fa-3x" style="color:#0ea58a;"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold text-start text-dark mb-0">よくある状況</h5>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>