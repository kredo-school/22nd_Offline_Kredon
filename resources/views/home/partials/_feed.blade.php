<div class="kk-feed-container">
    {{-- Market Section --}}
    <section class="kk-section">
        <h5 class="kk-section-title">Market</h5>
        <div class="kk-grid">
            @forelse($marketItems as $item)
                <div class="kk-grid-item">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>

    {{-- Working Spot Section --}}
    <section class="kk-section">
        <h5 class="kk-section-title">Working</h5>
        <div class="kk-grid">
            @forelse($workingSpots as $item)
                <div class="kk-grid-item">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>

    {{-- Tourist Spot Section --}}
    <section class="kk-section">
        <h5 class="kk-section-title">Tourist Spot</h5>
        <div class="kk-grid">
            @forelse($touristSpots as $item)
                <div class="kk-grid-item">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>
</div>