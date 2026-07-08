@extends('settings.index')

@section('settings-content')

<div class="st-guide">

    {{-- 戻るリンク --}}
    <a href="{{ route('settings.privacy') }}" class="st-guide__back">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to Privacy Settings
    </a>

    <header class="st-guide__head">
        <div class="st-guide__head-icon" aria-hidden="true">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h2 class="st-guide__title">KREDON Cebu Privacy Guide</h2>
        <p class="st-guide__lead">
            A portal for Japanese students studying in Cebu. This guide helps you protect your personal
            information when using marketplace, hospital search, study spots, and tourism features.
        </p>
    </header>

    {{-- 機能別ガイドセクション --}}
    @foreach ($guide->sections as $section)
        <section class="st-guide__section" aria-labelledby="guide-{{ $section['key'] }}">
            <h3 id="guide-{{ $section['key'] }}" class="st-guide__section-title">
                <span class="st-guide__section-icon st-notify-row__icon st-notify-row__icon--{{ $section['color'] }}">
                    <i class="{{ $section['icon'] }}" aria-hidden="true"></i>
                </span>
                {{ $section['title'] }}
            </h3>
            <p class="st-guide__section-desc">{{ $section['desc'] }}</p>

            <ul class="st-guide__tips" role="list">
                @foreach ($section['tips'] as $tip)
                    <li class="st-guide__tip">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <span>{{ $tip }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    @endforeach

    {{-- 共通の権利とお問い合わせ --}}
    <section class="st-guide__section st-guide__section--highlight">
        <h3 class="st-guide__section-title">
            <span class="st-guide__section-icon st-notify-row__icon st-notify-row__icon--blue">
                <i class="fa-solid fa-user-lock" aria-hidden="true"></i>
            </span>
            Your Rights
        </h3>
        <ul class="st-guide__tips" role="list">
            @foreach ($guide->rights as $right)
                <li class="st-guide__tip">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    <span>{{ $right }}</span>
                </li>
            @endforeach
        </ul>
    </section>

    <div class="st-guide__footer">
        <p class="st-guide__updated">Last updated: {{ $guide->updated_at }}</p>
        <a href="{{ route('settings.privacy') }}" class="st-btn st-btn--primary">
            Open Privacy Settings
        </a>
    </div>

</div>

@endsection
