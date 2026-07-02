<div class="hp-filter-bar">

    @php
        $category = request('category', 'market');
        $sort     = request('sort', 'newest');
        $isMarket = $category === 'market';
    @endphp

    {{-- カテゴリー --}}
    <div class="hp-filter-section">

        <div class="hp-filter-label">
            Category
        </div>

        <div class="hp-filter-category">

            <a href="{{ route('home', ['category' => 'market', 'sort' => $isMarket ? 'newest' : $sort]) }}"
               class="hp-sort-pill {{ $category === 'market' ? 'is-active' : '' }}">
                Market
            </a>

            <a href="{{ route('home', ['category' => 'working', 'sort' => $sort]) }}"
               class="hp-sort-pill {{ $category === 'working' ? 'is-active' : '' }}">
                Working Spot
            </a>

            <a href="{{ route('home', ['category' => 'tourist', 'sort' => $sort]) }}"
               class="hp-sort-pill {{ $category === 'tourist' ? 'is-active' : '' }}">
                Tourist Spot
            </a>

        </div>

    </div>

    {{-- 並び替え --}}
    <div class="hp-filter-bottom">

        <div>

            <div class="hp-filter-label mb-2">
                Sort
            </div>

            <div class="hp-sort-pills">

                @foreach([
                    'newest'  => '新着',
                    'ranking' => '人気',
                    'reviews' => '口コミ',
                ] as $value => $label)

                    @if ($isMarket && $value !== 'newest')
                        <span class="hp-sort-pill is-disabled" title="Marketは新着のみ">
                            {{ $label }}
                        </span>
                    @else
                        <a href="{{ route('home', [
                            'category' => $category,
                            'sort' => $value,
                        ]) }}"
                           class="hp-sort-pill {{ $sort === $value ? 'is-active' : '' }}">
                            {{ $label }}
                        </a>
                    @endif

                @endforeach

            </div>

        </div>

        <div class="hp-view-toggle" role="group" aria-label="表示形式">

            <button type="button" class="hp-toggle-btn active" data-hp-view="grid" aria-label="グリッド表示" aria-pressed="true">
                <i class="fa-solid fa-grip"></i>
            </button>

            <button type="button" class="hp-toggle-btn" data-hp-view="list" aria-label="リスト表示" aria-pressed="false">
                <i class="fa-solid fa-list"></i>
            </button>

        </div>

    </div>

</div>
