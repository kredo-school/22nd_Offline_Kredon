<div class="hp-filter-bar">

    {{-- カテゴリー --}}
    <div class="hp-filter-section">

        <div class="hp-filter-label">
            Category
        </div>

        <div class="hp-filter-category">

            <a href="{{ route('home', ['category' => 'market']) }}"
               class="hp-sort-pill {{ request('category','market') === 'market' ? 'is-active' : '' }}">
                Market
            </a>

            <a href="{{ route('home', ['category' => 'working']) }}"
               class="hp-sort-pill {{ request('category') === 'working' ? 'is-active' : '' }}">
                Working Spot
            </a>

            <a href="{{ route('home', ['category' => 'tourist']) }}"
               class="hp-sort-pill {{ request('category') === 'tourist' ? 'is-active' : '' }}">
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

                    <a href="{{ route('home', [
                        'category' => request('category', 'market'),
                        'sort' => $value
                    ]) }}"
                       class="hp-sort-pill {{ request('sort','newest') === $value ? 'is-active' : '' }}">

                        {{ $label }}

                    </a>

                @endforeach

            </div>

        </div>

        <div class="hp-view-toggle">

            <button class="hp-toggle-btn active">
                <i class="fa-solid fa-grip"></i>
            </button>

            <button class="hp-toggle-btn">
                <i class="fa-solid fa-list"></i>
            </button>

        </div>

    </div>

</div>