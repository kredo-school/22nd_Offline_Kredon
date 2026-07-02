@php
    $carouselId = 'hs-gallery-' . $hospital->id;
    $images = $hospital->images;
@endphp

@if($images->isNotEmpty())
    <div id="{{ $carouselId }}"
         class="carousel slide hs-gallery"
         data-bs-ride="false">
        @if($images->count() > 1)
            <div class="carousel-indicators hs-gallery__indicators">
                @foreach($images as $index => $image)
                    <button type="button"
                            data-bs-target="#{{ $carouselId }}"
                            data-bs-slide-to="{{ $index }}"
                            class="{{ $index === 0 ? 'active' : '' }}"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-label="{{ $image->caption ?? 'Slide ' . ($index + 1) }}">
                    </button>
                @endforeach
            </div>
        @endif

        <div class="carousel-inner hs-gallery__inner">
            @foreach($images as $index => $image)
                <div class="carousel-item hs-gallery__item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ $image->display_url }}"
                         class="d-block w-100 hs-gallery__image"
                         alt="{{ $image->caption ?? $hospital->name }}">
                    @if($image->caption)
                        <div class="hs-gallery__caption">
                            <span class="badge bg-dark bg-opacity-75">{{ $image->caption }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($images->count() > 1)
            <button class="carousel-control-prev hs-gallery__control"
                    type="button"
                    data-bs-target="#{{ $carouselId }}"
                    data-bs-slide="prev">
                <span class="hs-gallery__control-icon" aria-hidden="true">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next hs-gallery__control"
                    type="button"
                    data-bs-target="#{{ $carouselId }}"
                    data-bs-slide="next">
                <span class="hs-gallery__control-icon" aria-hidden="true">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
                <span class="visually-hidden">Next</span>
            </button>

            <div class="hs-gallery__counter">
                <span class="hs-gallery__counter-current">1</span>
                / {{ $images->count() }}
            </div>
        @endif
    </div>
@else
    <div class="hs-gallery hs-gallery--empty">
        <img src="{{ asset('images/default-hospital.jpg') }}"
             class="hs-gallery__image"
             alt="{{ $hospital->name }}"
             onerror="this.src='https://picsum.photos/seed/default-hospital/800/500'">
    </div>
@endif
