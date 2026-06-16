@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- 戻る --}}
    <a href="{{ route('marketplace.index') }}"
       class="btn btn-outline-secondary mb-4">

        ← マーケットに戻る

    </a>

    <div class="row g-4">

        {{-- 左：画像 --}}
        <div class="col-lg-7">

            @if($item->images->count())

                <div id="itemCarousel"
                     class="carousel slide bg-white rounded shadow-sm"
                     data-bs-ride="false">

                    <div class="carousel-inner">

                        @foreach($item->images as $key => $image)

                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                                <div class="text-center p-4">

                                    <img src="{{ asset('storage/'.$image->path) }}"
                                         class="img-fluid"
                                         style="
                                            max-height:500px;
                                            object-fit:contain;
                                         ">

                                </div>

                            </div>

                        @endforeach

                    </div>

                    @if($item->images->count() > 1)

                        <button class="carousel-control-prev"
                                type="button"
                                data-bs-target="#itemCarousel"
                                data-bs-slide="prev">

                            <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>

                        </button>

                        <button class="carousel-control-next"
                                type="button"
                                data-bs-target="#itemCarousel"
                                data-bs-slide="next">

                            <span class="carousel-control-next-icon bg-dark rounded-circle"></span>

                        </button>

                    @endif

                </div>

            @endif

        </div>

        {{-- 右：情報 --}}
        <div class="col-lg-5">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="text-center mb-3">

                        <span class="badge bg-primary px-3 py-2 fs-6">
                            KREDON FREE MARKET
                        </span>

                    </div>

                    <h2 class="fw-bold text-center mb-4">

                        {{ $item->title }}

                    </h2>

                    <hr>

                    <h5 class="fw-bold">
                        商品説明
                    </h5>

                    <p>

                        {{ $item->description }}

                    </p>
                   @if(
                        Auth::check() &&
                        !empty($item->user_id) &&
                        Auth::id() != $item->user_id
                    )

                    <form action="{{ route('chat.store') }}"
                        method="POST">

                        @csrf

                        <input type="hidden"
                            name="receiver_id"
                            value="{{ $item->user_id }}">

                        <button class="btn btn-success">
                            Message Seller
                        </button>

                    </form>

                    @endif
                        <button class="btn btn-secondary" disabled>出品者情報がありません</button>
                    @endif
                     <hr>

                    <h5 class="fw-bold">
                        受け渡し場所
                    </h5>

                    <p>

                        {{ $item->location_name }}

                    </p>

                    <hr>

                  

                </div>

            </div>

        </div>

    </div>

</div>

@endsection