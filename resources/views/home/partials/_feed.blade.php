<div class="hp-feed-container">

    <section class="hp-section">

        <div class="hp-grid">

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

    </section>

</div>