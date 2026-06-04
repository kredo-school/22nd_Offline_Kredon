@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .container { display: flex; width: 100%; height: calc(100vh - 70px); margin-top: 70px; }
        .content-section { width: 100%; padding: 20px 20px 80px 20px; overflow-y: auto; }
        .page-wrapper { max-width: 900px; margin: 0 auto; width: 100%; }
    </style>

    <div class="container">
        <div class="content-section">
            <div class="page-wrapper mx-auto p-4">
                
                <h1 class="text-2xl font-bold mb-4">👑 {{ $user->name }} のマイページ</h1>
                <p class="text-gray-600 mb-8 font-bold">現在のレベル：クレどん Lv.12</p>

                <h2 class="text-xl font-bold mb-3 border-b pb-2 text-orange-500">
                    <i class="fa-solid fa-bookmark"></i> お気に入りスポット
                </h2>
                
                @if($bookmarkedSpots->isNotEmpty())
                    <div class="grid grid-cols-1 gap-4 mt-4 mb-10">
                        @foreach($bookmarkedSpots as $spot)
                            @include('components.spot_card', ['spot' => $spot])
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 mt-4 mb-10 bg-gray-50 p-6 text-center rounded-lg border border-dashed">
                        まだお気に入り登録したスポットはありません。<br>気になるスポットを見つけて保存しましょう！
                    </p>
                @endif

                <h2 class="text-xl font-bold mb-3 border-b pb-2">📝 あなたが投稿したレビュー</h2>
                
                @if($reviews->isNotEmpty())
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        @foreach($reviews as $review)
                            <div class="bg-white p-4 rounded-lg shadow border border-gray-200 relative">
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="absolute top-4 right-4" onsubmit="return confirm('本当にこのレビューを削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer; padding: 5px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" title="レビューを削除">
                                        <i class="fa-solid fa-trash-can" style="font-size: 1.2rem;"></i>
                                    </button>
                                </form>

                                <h3 class="font-bold text-lg text-blue-600 pr-8">{{ $review->spot->name }}</h3>
                                <p class="text-xs text-gray-500 mb-2">エリア: {{ $review->spot->area }}</p>
                                
                                <div class="grid grid-cols-2 gap-2 text-sm mt-2">
                                    <div>🥷 空間快適度: <span class="text-amber-500 font-bold">{{ str_repeat('★', $review->dead_spot_rating ?? 0) }}</span></div>
                                    <div>❄️ 冷房対策度: <span class="text-blue-500 font-bold">{{ str_repeat('★', $review->aircon_level ?? 0) }}</span></div>
                                </div>
                                
                                @if($review->comment)
                                    <p class="mt-3 text-sm text-gray-700 bg-gray-50 p-3 rounded border border-dashed">
                                        「{{ $review->comment }}」
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 mt-4 bg-gray-50 p-6 text-center rounded-lg border border-dashed">
                        まだレビューを投稿していません。
                    </p>
                @endif

            </div>
        </div>
    </div>
@endsection