<div class="card border-0 shadow-sm">

    <div id="homeHeroCarousel"
         class="carousel slide carousel-dark"
         data-bs-ride="false">

        {{-- スライド本体 --}}
        <div class="carousel-inner">

            {{-- Slide 1 --}}
            <div class="carousel-item active">

                <div class="hero-slide bg-light d-flex align-items-center justify-content-start"
                     style="height: 280px;">

                    <div class="text-start px-4">

                        <h2 class="fw-bold mb-3">
                            Welcome to Kredon!
                        </h2>

                        <p class="text-muted mb-0">
                            Your Student Life Portal in Cebu
                        </p>

                    </div>

                </div>

            </div>

            {{-- Slide 2 --}}
            <div class="carousel-item">

                <div class="hero-slide bg-light d-flex align-items-center justify-content-center"
                     style="height: 280px;">

                    <div class="text-center px-4">

                        <h2 class="fw-bold mb-3">
                            Stay Connected
                        </h2>

                        <p class="text-muted mb-4">
                            Reviews, events, marketplace and community updates.
                        </p>

                        <a href="#"
                           class="btn btn-success px-4">
                            Learn More
                        </a>

                    </div>

                </div>

            </div>

            {{-- Slide 3 --}}
            <div class="carousel-item">

                <div class="hero-slide bg-light d-flex align-items-center justify-content-center"
                     style="height: 280px;">

                    <div class="text-center px-4">

                        <h2 class="fw-bold mb-3">
                            Find Useful Spots
                        </h2>

                        <p class="text-muted mb-4">
                            Discover tourist spots, study spaces and more.
                        </p>

                        <a href="#"
                           class="btn btn-info text-white px-4">
                            詳細を見る
                        </a>

                    </div>

                </div>

            </div>

        </div>

        {{-- 左矢印 --}}
        {{-- <button class="carousel-control-prev"
                type="button"
                data-bs-target="#homeHeroCarousel"
                data-bs-slide="prev">

            <span class="carousel-control-prev-icon"></span>

        </button> --}}

        {{-- 右矢印 --}}
        {{-- <button class="carousel-control-next"
                type="button"
                data-bs-target="#homeHeroCarousel"
                data-bs-slide="next">

            <span class="carousel-control-next-icon"></span>

        </button> --}}

        {{-- インジケーター --}}
        <div class="carousel-indicators">

            <button type="button"
                    data-bs-target="#homeHeroCarousel"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true">
            </button>

            <button type="button"
                    data-bs-target="#homeHeroCarousel"
                    data-bs-slide-to="1">
            </button>

            <button type="button"
                    data-bs-target="#homeHeroCarousel"
                    data-bs-slide-to="2">
            </button>

        </div>

    </div>

</div>
