<div class="hp-filter-control-area">

    <div class="hp-filter-inner">

        <div class="hp-sort-pills">

            @foreach([
                'newest'  => '新着',
                'ranking' => '人気',
                'reviews' => '口コミ',
            ] as $value => $label)

                <a
                    href="{{ route('home', ['sort' => $value]) }}"
                    class="hp-sort-pill {{ request('sort', 'newest') === $value ? 'is-active' : '' }}">

                    {{ $label }}

                </a>

            @endforeach

        </div>

        <div class="hp-view-toggle">

            <button class="hp-toggle-btn active">
                ▦
            </button>

            <button class="hp-toggle-btn">
                ≣
            </button>

        </div>

    </div>

</div>