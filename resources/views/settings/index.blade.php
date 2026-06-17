@extends('layouts.app')

@section('content')
<div class="kk-st-wrap">

    {{-- ── 設定サイドバー ── --}}
    <aside class="kk-st-sidebar">

        <div class="kk-st-sidebar__head">
            <i class="fa-solid fa-gear kk-st-sidebar__gear"></i>
            <h2 class="kk-st-sidebar__title">設定</h2>
        </div>

        <p class="kk-st-sidebar__desc">
            アカウント、プライバシーなど各種設定をカスタマイズできます。
        </p>

        <nav aria-label="設定メニュー">
            <ul class="kk-st-nav">

                <li>
                    <a href="{{ route('settings.account') }}"
                       class="kk-st-nav__link {{ request()->routeIs('settings.account') ? 'is-active' : '' }}">
                        <i class="fa-regular fa-user"></i>
                        アカウント
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings.display') }}"
                       class="kk-st-nav__link {{ request()->routeIs('settings.display') ? 'is-active' : '' }}">
                        <i class="fa-regular fa-eye"></i>
                        表示設定
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings.notification') }}"
                       class="kk-st-nav__link {{ request()->routeIs('settings.notification') ? 'is-active' : '' }}">
                        <i class="fa-regular fa-bell"></i>
                        通知
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings.comment') }}"
                       class="kk-st-nav__link {{ request()->routeIs('settings.comment') ? 'is-active' : '' }}">
                        <i class="fa-regular fa-comment"></i>
                        コメント・安全設定
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings.privacy') }}"
                       class="kk-st-nav__link {{ request()->routeIs('settings.privacy') ? 'is-active' : '' }}">
                        <i class="fa-solid fa-shield-halved"></i>
                        プライバシー
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings.app') }}"
                       class="kk-st-nav__link {{ request()->routeIs('settings.app') ? 'is-active' : '' }}">
                        <i class="fa-solid fa-mobile-screen"></i>
                        アプリ設定
                    </a>
                </li>

            </ul>
        </nav>

        {{-- Premium バナー --}}
        <div class="kk-st-premium">
            <p class="kk-st-premium__badge">
                <i class="fa-solid fa-crown"></i> KREDON Premium
            </p>
            <p class="kk-st-premium__copy">
                限定イベント・高度なフィルター・無制限のゲームプレイが楽しめます。
            </p>
            <a href="#" class="kk-st-premium__btn">詳細を見る</a>
        </div>

    </aside>

    {{-- ── メインコンテンツ ── --}}
    <main class="kk-st-main">

        {{-- フラッシュメッセージ --}}
        @if(session('success'))
            <div class="kk-st-alert kk-st-alert--success" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="kk-st-alert kk-st-alert--error" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('settings-content')

    </main>

</div>
@endsection