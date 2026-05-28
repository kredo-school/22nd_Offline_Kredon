@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <!-- ユーザー情報の表示エリア -->
    <h1 class="text-2xl font-bold mb-4">👑 {{ $user->name }} のマイページ</h1>
    <p class="text-gray-600 mb-6 font-bold">現在のレベル：クレどん Lv.12</p>

    <!-- 投稿したレビューの表示エリア -->
    <h2 class="text-xl font-bold mb-3 border-b pb-2">📝 あなたが投稿したレビュー</h2>
    
    @if($reviews->isNotEmpty())
        <div class="grid grid-cols-1 gap-4 mt-4">
            @foreach($reviews as $review)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    <h3 class="font-bold text-lg text-blue-600">{{ $review->spot->name }}</h3>
                    <p class="text-xs text-gray-500 mb-2">エリア: {{ $review->spot->area }}</p>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm mt-2">
                        <div>🥷 空間快適度: <span class="text-amber-500 font-bold">{{ str_repeat('★', $review->dead_spot_rating) }}</span></div>
                        <div>❄️ 冷房対策度: <span class="text-blue-500 font-bold">{{ str_repeat('★', $review->aircon_level) }}</span></div>
                    </div>
                    
                    @if($review->comment)
                        <p class="mt-3 text-sm text-gray-700 bg-gray-50 p-2 rounded border border-dashed">
                            「{{ $review->comment }}」
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 mt-4">まだレビューを投稿していません。</p>
    @endif
</div>
@endsection