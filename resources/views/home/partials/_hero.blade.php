<div class="swiper hp-hero-swiper">
    <div class="swiper-wrapper">
        {{-- 固定のウェルカム画像 --}}
        <div class="swiper-slide">
            <div class="hp-banner-box" style="background-image: url('{{ asset('images/welcome-bg.jpg') }}');">
                <div class="hp-banner-content">
                    <h1 class="hp-hero-title">Welcome to Kredon</h1>
                    <p class="hp-hero-subtitle">Have fun</p>
                </div>
            </div>
        </div>

        {{-- DBの代わりにダミーデータで表示を確認する --}}
        @php
            $dummyBanners = [
                ['title' => 'Sample 1', 'path' => 'images/welcome-bg.jpg', 'url' => '#'],
                ['title' => 'Sample 2', 'path' => 'images/welcome-bg.jpg', 'url' => '#'],
            ];
        @endphp

        @foreach($dummyBanners as $banner)
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
    <div class="hp-slider-pagination"></div>
</div>