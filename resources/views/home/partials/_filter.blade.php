<div class="kk-filter-control-area">
    <div class="kk-sort-wrapper">

        {{-- 検索バー --}}
        <form action="#" method="GET" class="kk-search-form">

            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <div class="kk-search-inner">
                <i class="fa-solid fa-magnifying-glass kk-search-icon"></i>
                <input type="text"
                       name="keyword"
                       placeholder="商品や場所を検索..."
                       class="kk-search-input"
                       value="{{ request('keyword') }}"
                       autocomplete="off">
                @if(request('keyword'))
                    <button type="submit" name="keyword" value="" class="kk-search-clear" aria-label="クリア">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                @endif
            </div>

            <button type="submit" class="kk-search-submit" aria-label="検索">
                検索
            </button>
        </form>

        {{-- ソートピル --}}
        <div class="kk-sort-pills" role="group" aria-label="並び替え">
            @foreach([
                'ranking' => 'おすすめ順',
                'newest'  => '新着順',
                'rating'  => '評価が高い順',
                'reviews' => '口コミ順',
            ] as $value => $label)
                <a href="{{ request()->fullUrlWithQuery(['sort' => $value]) }}"
                   class="kk-sort-pill {{ request('sort', 'ranking') === $value ? 'is-active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

    </div>
</div>