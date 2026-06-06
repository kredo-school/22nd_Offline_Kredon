<div class="feed-container">
    {{-- Market Section --}}
    <section class="mb-5">
        <h5 class="fw-bold m-0">Market</h5>
        <div class="row row-cols-md-3 g-3">
            @forelse($marketItems as $item)
                <div class="col">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>

    {{-- Working Spot Section --}}
    <section class="mb-5">
        <h5 class="fw-bold m-0">Working</h5>
        <div class="row row-cols-md-3 g-3">
            @forelse($workingSpots as $item)
                <div class="col">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>

    {{-- Tourist Spot Section (追加しました) --}}
    <section class="mb-5">
        <h5 class="fw-bold m-0">Tourist Spot</h5>
        <div class="row row-cols-md-3 g-3">
            @forelse($touristSpots as $item)
                <div class="col">@include('home.partials._post_card', ['item' => $item])</div>
            @empty
                <p>投稿はありません。</p>
            @endforelse
        </div>
    </section>
</div>
