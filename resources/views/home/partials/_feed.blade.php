<div class="hp-feed-container">
    {{-- Market Section --}}
    <section class="hp-section">
        <h5 class="hp-section-title">Market</h5>
        <div class="hp-grid">
            @forelse($marketItems as $item)
                <div class="hp-grid-item">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>

    {{-- Working Spot Section --}}
    <section class="hp-section">
        <h5 class="hp-section-title">Working</h5>
        <div class="hp-grid">
            @forelse($workingSpots as $item)
                <div class="hp-grid-item">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>

    {{-- Tourist Spot Section --}}
    <section class="hp-section">
        <h5 class="hp-section-title">Tourist Spot</h5>
        <div class="hp-grid">
            @forelse($touristSpots as $item)
                <div class="hp-grid-item">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>
</div>