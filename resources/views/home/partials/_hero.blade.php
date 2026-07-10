<div class="hp-hero-wrapper">
    <div class="swiper hp-hero-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="hp-banner-box" style="background-image: url('{{ asset('images/home_banner/ocean.jpeg') }}');">
                    <div class="hp-banner-content">
                        <h1 class="hp-hero-title">Welcome to Kredon</h1>
                        <p class="hp-hero-subtitle">Cebu Island: Places, Markets and Communities</p>
                    </div>
                </div>
            </div>

            @foreach($banners ?? [] as $banner)
                <div class="swiper-slide">
                    <div class="hp-banner-box" style="background-image: url('{{ asset($banner['path']) }}');">
                        <div class="hp-banner-content">
                            <h2 class="hp-banner-title">{{ $banner['title'] }}</h2>
                            <a href="{{ $banner['url'] }}" class="hp-cta-button">more</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="hp-hero-controls">
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>