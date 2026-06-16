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
                <small>すべて</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'服']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">👕</div>
                <small>服・ファッション</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'タオル']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">🧻</div>
                <small>タオル</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'薬']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">💊</div>
                <small>薬・サプリ</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'スキンケア']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">🧴</div>
                <small>スキンケア</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'日用品']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">🧼</div>
                <small>日用品</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'文房具']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">✏️</div>
                <small>文房具</small>

            </a>
        </div>

        <div class="col">
            <a href="{{ route('marketplace.index',['category'=>'その他']) }}"
               class="text-decoration-none text-dark">

                <div class="fs-3">⋯</div>
                <small>その他</small>

            </a>
        </div>

    </div>

</div>

<h3 class="h5 fw-bold my-4">
    注目のアイテム
</h3>

{{-- アイテム一覧 --}}
<div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">

    @forelse($items as $item)

    <div class="col">

        <a href="{{ route('marketplace.show', $item->id) }}"
           class="text-decoration-none text-dark">

            <div class="card h-100 shadow-sm border-0">

                {{-- 画像 --}}
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
                         style="height:120px; font-size:40px;">
                        📦
                    </div>

                @endif

                <div class="card-body p-2">

                    <h6 class="fw-bold text-center mb-2">
                        {{ $item->title }}
                    </h6>

                    <p class="text-muted text-center mb-2"
                       style="font-size:12px;">
                        {{ $item->location_name ?? '受渡し場所未設定' }}
                    </p>

                </div>

            </div>

        </a>

    </div>

    @empty

        <div class="col-12">

            <div class="alert alert-light">
                現在、注目のアイテムはありません。
            </div>

        </div>

    @endforelse

</div>

</div>

@endsection
