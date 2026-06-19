<div id="hospital-list" class="row g-4 mt-4">
    @foreach($hospitals as $hospital)
    <div class="col-12 col-lg-6">
        {{-- hs-card クラスを適用 --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-light-gray hs-card">
            
            {{-- hospital-image-container を指定 --}}
            <div class="hospital-image-container">
                @php
                    $image = $hospital->images->first();
                @endphp

                {{-- hospital-image クラスを指定 --}}
                <img src="{{ $image ? asset('storage/' . $image->image_path) : asset('images/default-hospital.jpg') }}"
                     class="hospital-image"
                     alt="{{ $hospital->name }}">
                
                <button type="button" class="btn-bookmark" aria-label="ブックマーク">
                    <i class="fa-solid fa-bookmark"></i>
                </button>
            </div>

            <div class="card-body p-4">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @if($hospital->is_jhd_supported)
                        <span class="badge bg-success-subtle text-success">JHD対応</span>
                    @endif
                    @if($hospital->is_clinic)
                        <span class="badge bg-info-subtle text-info">Clinic</span>
                    @else
                        <span class="badge bg-primary-subtle text-primary">Hospital</span>
                    @endif
                </div>

                <h5 class="fw-bold mb-3">{{ $hospital->short_name ?? $hospital->name }}</h5>

                <div class="small text-muted">
                    @if($hospital->duration_grab)
                        <div class="mb-2"><i class="fa-solid fa-car me-2"></i>Grab 約{{ $hospital->duration_grab }}分</div>
                    @endif
                    @if($hospital->duration_walk)
                        <div class="mb-2"><i class="fa-solid fa-person-walking me-2"></i>徒歩 約{{ $hospital->duration_walk }}分</div>
                    @endif
                    <div class="mb-2"><i class="fa-solid fa-clock me-2"></i>{{ $hospital->business_hours }}</div>
                    <div class="mb-3"><i class="fa-solid fa-calendar-xmark me-2"></i>{{ $hospital->closed_days ?? '無休' }}</div>
                </div>

                @if($hospital->guide_tips_ja)
                    <div class="alert alert-light border small mb-3">
                        {{ $hospital->guide_tips_ja }}
                    </div>
                @endif

                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-secondary">詳細を見る</a>
                    @if(!$hospital->is_clinic)
                        <a href="{{ $hospital->grab_link ?? '#' }}" class="btn btn-success fw-bold">
                            <i class="fa-solid fa-location-arrow me-1"></i>Grabで向かう
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>