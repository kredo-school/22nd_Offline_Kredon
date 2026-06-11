<div class="row g-3"> 
    @foreach($hospitals as $hospital)
    <div class="col-6">
        <div class="card h-100 shadow-sm border-0 position-relative">

            {{-- ブックマークアイコン --}}
            <button class="btn btn-link position-absolute top-0 end-0 p-2  text-decoration-none" onclick="toggleBookmark({{ hospital->id }})"> {{-- このidは本番では、location --}}
                <i class="fa-regular fa-bookmark fs-5 text-secondary"></i>
            </button>

            <img src="{{ $hospital->image_path }}" 
                 class="card-img-top"
                 style="height: 100px; objectfit: cover;">

            <div class="card-body p-2">
                <h6 class="fw-bold mb-1">{{ $hospital->name }}</h6>
                <p class="small text-muted mb-2">
                    <i class="fa-solid fa-clock">{{ $hospital->duration }}分</i>
                </p>
                <a href="{{ $hospital->grab_link }}" class="btn btn-primary btn-sm w-100">Grabで向かう</a>
            </div>
        </div>
    </div>
    @endforeach
</div>