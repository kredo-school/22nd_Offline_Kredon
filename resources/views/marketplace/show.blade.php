@extends('layouts.app')

@section('content')

<div class="container py-4">

    <a href="{{ route('marketplace.index') }}"
       class="btn btn-outline-secondary mb-4">
        ← Back to Marketplace
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
                                         style="max-height:500px;object-fit:contain;">

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

        {{-- 右 --}}
        <div class="col-lg-5">

            {{-- Seller --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-body text-center">

                    @if($item->user)

                        @if($item->user->avatar)

                            <img src="{{ asset('storage/'.$item->user->avatar) }}"
                                 class="rounded-circle mb-3"
                                 width="90"
                                 height="90"
                                 style="object-fit:cover;">

                        @else

                            <div class="rounded-circle bg-secondary text-white
                                        d-inline-flex align-items-center
                                        justify-content-center mb-3"
                                 style="width:90px;height:90px;font-size:32px;">

                                {{ strtoupper(substr($item->user->name,0,1)) }}

                            </div>

                        @endif

                        <h5 class="fw-bold">

                            {{ $item->user->name }}

                        </h5>

                        @if(Auth::check() && Auth::id() != $item->user_id)

                            <a href="{{ route('chat.private',$item->user) }}"
                               class="btn btn-primary">

                                Message

                            </a>

                        @endif

                    @else

                        <h5>

                            Unknown Seller

                        </h5>

                    @endif

                </div>

            </div>

            {{-- Item Info --}}
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

                        Description

                    </h5>

                    <p>

                        {{ $item->description }}

                    </p>

                    <hr>

                    <h5 class="fw-bold">

                        Pickup Location

                    </h5>

                    <p>

                        {{ $item->location_name }}

                    </p>

                    <hr>

                    <h5 class="fw-bold">

                        Category

                    </h5>

                    <p>

                        {{ $item->category }}

                    </p>

                    <hr>

                    <h5 class="fw-bold">

                        Status

                    </h5>

                    <p>

                        {{ $item->status }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection