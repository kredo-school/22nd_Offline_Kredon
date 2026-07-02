<div class="hp-feed-container">

    <section class="hp-section">

        <div class="hp-grid" id="hp-feed-grid">

            @forelse($posts as $item)

                <div class="hp-grid-item">
                    @include('home.partials._post_card', [
                        'item' => $item
                    ])
                </div>

            @empty

                <p>投稿はありません。</p>

            @endforelse

        </div>

        @if ($posts instanceof \Illuminate\Contracts\Pagination\Paginator && $posts->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        @endif

    </section>

</div>
