<div class="hp-filter-control-area">
    
    <div class="hp-filter-inner">

        <div class="hp-sort-pills" role="group" aria-label="並び替え">
            @foreach([
                'newest'  => '新着',
                'ranking' => '人気',
                'rating'  => '評価',
                'reviews' => '口コミ',
                ] as $value => $label)

            <a href="{{ request()->fullUrlWithQuery(['sort' => $value]) }}"
               class="hp-sort-pill {{ request('sort', 'ranking') === $value ? 'is-active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

        <div class="hp-view-controls">
            <select class="hp-sort-select" onchange="location.href=this.value;">
                <option value="?order=newest">新着順</option>
                <option value="?order=ranking">人気</option>
                <option value="?order=rating">評価</option>
                <option value="?order=reviews">口コミ</option>
            </select>

            <div class="hp-view-toggle">
                <button class="hp-toggle-btn active">▦</button>
                <button class="hp-toggle-btn">≣</button>
            </div>
        </div>
    </div>
</div>