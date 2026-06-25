{{-- キャラクター表示（ライブプレビュー・ピッカー共通のフォールバック） --}}

@if (!empty($character['image']) && file_exists(public_path(ltrim($character['image'], '/'))))
    <img src="{{ asset($character['image']) }}"
         alt="{{ $character['name'] }}"
         class="st-display-char__img">
@else
    <span class="st-display-char__fallback"
          style="background: {{ $character['bg'] }}">
        {{ $character['initial'] }}
    </span>
@endif
