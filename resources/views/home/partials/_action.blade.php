<div class="row row-cols-lg-5 g-2 mb-4">
    {{-- スポットを探す --}}
    <div class="dropdown h-100">
        <div class="col">
            <button class="card border-0 shadow-sm h-100 w-100 text-dark p-0" type="button" 
                 data-bs-toggle="dropdown" 
                 aria-expanded="false" 
                 style="background-color: #f7f5f0;">
                    <div class="card-body text-center py-3">
                        <i class="fa-solid fa-location-dot text-success fs-4 mb-2"></i>
                        <div class="small fw-bold">Spot</div>
                    </div>
            </button>
            <ul class="dropdown-menu shadow-sm dropdown-menu-end">
                <li><h6 class="dropdown-header">Find a Place</h6></li>
                {{-- パラメータ 'type' を渡して1つのコントローラーへ集約 --}}
                <li><a href="#" class="dropdown-item fw-bold text-success"><i class="fa-solid fa-laptop me-2"></i>Working</a></li>

                <li><a href="#" class="dropdown-item"><i class="fa-solid fa-camera me-2"></i>Tourist</a></li>

                <li><hr class="dropdown-divider"></li>
                <li><a href="#" class="dropdown-item text-muted"><i class="fa-solid fa-hospital me-2"></i>Hospital</a></li>
            </ul>
        </div>
    </div>

    {{-- イベントを見る --}}
    <div class="col">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <i class="fa-solid fa-calendar-days text-danger fs-4 mb-2"></i>
                    <div class="small fw-bold">Event</div>
                </div>
            </div>
        </a>
    </div>

    {{-- マーケット --}}
    <div class="col">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <i class="fa-solid fa-cart-shopping text-warning fs-4 mb-2"></i>
                    <div class="small fw-bold">Market</div>
                </div>
            </div>
        </a>
    </div>

    {{-- ゲーム --}}
    <div class="col">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-3">
                    <i class="fa-solid fa-gamepad fs-4 mb-2" 
                       style="color: #6f42c1;"></i>
                    <div class="small fw-bold">GAME</div>
                </div>
            </div>
        </a>
    </div>

    {{-- その他 --}}
    <div class="col">
        <div class="dropdown h-100">
            <button class="card border-0 shadow-sm h-100 w-100 bg-light  text-dark text-decoration-none p-0" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                <div class="card-body text-center py-3">
                    <i class="fa-solid fa-ellipsis text-muted fs-4 mb-2"></i>
                    <div class="fw-bold small">More</div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">Action</h6></li>
                <li><a href="#" class="dropdown-item"><i class="fa-solid fa-box-archive me-2"></i>Item Post</a></li>
                <li><a href="#" class="dropdown-item"><i class="fa-solid fa-bookmark me-2"></i>Bookmark</a></li>
                <li><a href="#" class="dropdown-item"><i class="fa-solid fa-star me-2"></i>Review</a></li>
            </ul>
        </div>
    </div>
</div>
