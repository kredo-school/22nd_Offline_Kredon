<div class="hp-hero-wrapper">
    <div class="swiper hp-hero-swiper">
        <div class="swiper-wrapper">
            {{-- 1枚目：ウェルカム --}}
            <div class="swiper-slide">
                <div class="hp-banner-box" style="background-image: url('{{ asset('images/welcome-bg.jpg') }}');">
                    <div class="hp-banner-content">
                        <h1 class="hp-hero-title">Welcome to Kredon</h1>
                        <p class="hp-hero-subtitle"></p>
                    </div>
                </div>
            </div>

            {{-- 残り5枚：ダミーデータで6枚構成 --}}
            @php
                $banners = [
                    ['title' => 'Spot Info', 'path' => 'images/welcome-bg.jpg', 'url' => '#'],
                    ['title' => 'Market Place', 'path' => 'images/welcome-bg.jpg', 'url' => '#'],
                    ['title' => 'Game Event', 'path' => 'images/welcome-bg.jpg', 'url' => '#'],
                    ['title' => 'More Activities', 'path' => 'images/welcome-bg.jpg', 'url' => '#'],
                    ['title' => 'Community News', 'path' => 'images/welcome-bg.jpg', 'url' => '#'],
                ];
            @endphp

            @foreach($banners as $banner)
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

    {{-- コントロールエリア（画像の下に配置） --}}
    <div class="hp-hero-controls">
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>