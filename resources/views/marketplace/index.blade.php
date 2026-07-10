@extends('layouts.app')

@section('content')

<div class="container">

<div class="mb-4 rounded shadow-sm bg-white">

    <img src="{{ asset('kredon-banner.png.jpeg') }}"
         alt="Banner"
         class="img-fluid rounded w-100"
         style="
            height:200px;
            object-fit:contain;
            background:white;
         ">

</div>

{{-- カテゴリ --}}
<div class="mb-4">

    <a href="{{ route('marketplace.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Post Item
    </a>

    <div class="row text-center py-3">

        <div class="col">
            <a href="{{ route('marketplace.index') }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">📦</div>
                <small>All</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'Clothes']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">👕</div>
                <small>Clothes</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'Towels']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">🧻</div>
                <small>Towels</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'Medicine']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">💊</div>
                <small>Medicine</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'Skincare']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">🧴</div>
                <small>Skincare</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'Household Items']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">🧼</div>
                <small>Household</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'Stationery']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">✏️</div>
                <small>Stationery</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'Other']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">⋯</div>
                <small>Other</small>

            </a>
        </div>

    </div>

</div>

<h3 class="h5 fw-bold my-4">
    Featured Items
</h3>

{{-- アイテム一覧 --}}
<div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">

    @forelse($items as $item)

    <div class="col">

        <a href="{{ route('marketplace.show', $item->id) }}"
           class="text-decoration-none text-dark">

            <div class="card h-100 shadow-sm border-0 {{ $item->market_status=='sold' ? 'opacity-75' : '' }}">

                <div class="position-relative">

                    {{-- 商品画像 --}}
                    @if($item->images->count())

                        <div class="bg-white d-flex align-items-center justify-content-center"
                             style="height:120px;">

                            <img src="{{ asset('storage/'.$item->images->first()->path) }}"
                                 alt="{{ $item->title }}"
                                 style="
                                    max-width:100%;
                                    max-height:100%;
                                    object-fit:contain;
                                 ">

                        </div>

                    @else

                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height:120px;font-size:40px;">

                            📦

                        </div>

                    @endif

                    {{-- SOLD OUT --}}
                    @if($item->market_status=="sold")

                        <div class="position-absolute top-0 start-0 w-100 h-100
                                    d-flex align-items-center justify-content-center"
                             style="background:rgba(255,255,255,.65);">

                            <img src="{{ asset('images/soldout.png') }}"
                                 style="width:90px;">

                        </div>

                    @endif

                </div>

                <div class="card-body p-2">

                    <h6 class="fw-bold text-center mb-2
                        {{ $item->market_status=='sold' ? 'text-muted' : '' }}">

                        {{ $item->title }}

                    </h6>

                    <p class="text-muted text-center mb-2"
                       style="font-size:12px;">

                        {{ $item->location_name ?? '受渡し場所未設定' }}

                    </p>

                    @if($item->market_status=="sold")

                        <span class="badge bg-dark w-100">
                            SOLD OUT
                        </span>

                    @endif

                </div>

            </div>

        </a>

    </div>

    @empty

        <div class="col-12">

            <div class="alert alert-light">
                No featured Items now
            </div>

        </div>

    @endforelse

</div>

</div>

@endsection