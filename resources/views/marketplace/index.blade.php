<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KREDON - セブ島生同士で助け合おう</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap');
        body { font-family: 'Noto Sans JP', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">

    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="text-2xl">🌴</div>
                <div>
                    <h1 class="text-xl font-bold text-emerald-600">KREDON</h1>
                    <p class="text-[10px] text-gray-500">使わないものを必要な人に受け継がれる意志</p>
                </div>
            </div>
            <a href="#" class="bg-emerald-600 text-white font-bold text-xs px-6 py-2 rounded-full">投稿する</a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-8 rounded-2xl overflow-hidden shadow-md">
            <img src="{{ asset('kredon-banner.png.jpeg') }}" alt="Banner" class="w-full h-48 object-cover bg-emerald-100">
        </div>

        <div class="flex items-center justify-center gap-4 md:gap-6 mb-8 overflow-x-auto pb-2">
            @php
                $categories = [
                    'すべて' => 'fa-border-all', '服・ファッション' => 'fa-shirt', 'タオル' => 'fa-scroll',
                    '薬・サプリ' => 'fa-pills', 'スキンケア' => 'fa-pump-soap', '日用品' => 'fa-mug-hot',
                    '文房具' => 'fa-pen-nib', 'その他' => 'fa-ellipsis'
                ];
            @endphp
            @foreach($categories as $name => $icon)
                <button class="flex flex-col items-center gap-1 min-w-[64px] text-gray-500 hover:text-emerald-600 transition">
                    <div class="w-12 h-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-lg {{ $name === 'すべて' ? 'text-emerald-600 border-emerald-200' : '' }}">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    <span class="text-[10px] font-bold">{{ $name }}</span>
                </button>
            @endforeach
        </div>

        <h3 class="text-lg font-bold mb-4">注目のアイテム</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @foreach($items as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 hover:shadow-md transition">
                    <div class="bg-gray-100 aspect-square rounded-lg mb-2 flex items-center justify-center text-gray-400 text-2xl">📦</div>
                    <p class="text-xs font-bold text-gray-800 mb-1">{{ $item->title }}</p>
                    <p class="text-[10px] text-gray-400 mb-2">ITパーク近く</p>
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded">無料譲渡</span>
                        <i class="fa-regular fa-heart text-gray-400 text-xs"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</body>
</html>