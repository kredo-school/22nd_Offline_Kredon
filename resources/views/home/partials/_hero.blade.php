<div class="swiper kk-hero-swiper">
    <div class="swiper-wrapper">
        {{-- 固定のウェルカム画像 --}}
        <div class="swiper-slide">
            <div class="kk-banner-box" style="background-image: url('{{ asset('images/welcome-bg.jpg') }}');">
                <div class="kk-banner-content">
                    <h1 class="kk-hero-title">Welcome to Kredon</h1>
                    <p class="kk-hero-subtitle">Have fun</p>
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
                <div class="kk-banner-box" style="background-image: url('{{ asset($banner['path']) }}');">
                   <div class="kk-banner-content">
                       <h2 class="kk-banner-title">{{ $banner['title'] }}</h2>
                       <a href="{{ $banner['url'] }}" class="kk-cta-button">more</a>
                   </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="kk-slider-pagination"></div>
</div>