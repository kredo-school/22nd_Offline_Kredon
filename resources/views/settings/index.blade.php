{{--
    設定ページ共通レイアウト（親テンプレート）
    ─────────────────────────────────────────
    各タブ（_account.blade.php 等）は @extends('settings.index') で
    この骨格を継承し、@section('settings-content') に固有コンテンツを書く。

    768px未満 : 縦積み（タブ → コンテンツ）
    768px以上 : 左ナビ + 右コンテンツの2カラム
--}}
@extends('layouts.app')

@php
    /*
     * 設定タブの定義を1箇所に集約。
     * 新タブ追加時は配列に1行足すだけでナビが自動更新される。
     * （本番では ViewComposer や Config へ移すのがより望ましい）
     */
    $settingsNav = [
        ['route' => 'settings.account',      'icon' => 'fa-regular fa-user',           'label' => 'Account'],
        ['route' => 'settings.display',      'icon' => 'fa-regular fa-eye',            'label' => 'Display'],
        ['route' => 'settings.notification', 'icon' => 'fa-regular fa-bell',           'label' => 'Notifications'],
        ['route' => 'settings.comment',      'icon' => 'fa-regular fa-comment',        'label' => 'Comments & Safety'],
        ['route' => 'settings.privacy',      'icon' => 'fa-solid fa-shield-halved',    'label' => 'Privacy'],
        ['route' => 'settings.app',          'icon' => 'fa-solid fa-mobile-screen',    'label' => 'App Settings'],
    ];
@endphp

@section('content')

<div class="st-wrap">

    {{-- ページ見出し（全タブ共通） --}}
    <header class="st-wrap__head">
        <h1 class="st-wrap__title">Settings</h1>
        <p class="st-wrap__desc">Customize your account, display, privacy, and other preferences.</p>
    </header>

    {{-- 768px以上: 左ナビ + 右エリア / 未満: 縦積み --}}
    <div class="st-wrap__body">

        {{--
            インナーナビ
            request()->routeIs() で現在のルートと照合し is-active を付与。
            aria-current="page" でスクリーンリーダーにも現在位置を伝える。
        --}}
        <nav class="st-inner-nav" aria-label="Settings menu">
            <ul class="st-inner-nav__list" role="list">
                @foreach ($settingsNav as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <li>
                        <a href="{{ route($item['route']) }}"
                           class="st-inner-nav__link {{ $isActive ? 'is-active' : '' }}"
                           @if($isActive) aria-current="page" @endif>
                            <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        {{-- 各タブの固有コンテンツが入るメインエリア --}}
        <div class="st-wrap__content">

            {{-- フラッシュメッセージ: 保存成功・エラーを全タブ共通で表示 --}}
            @if (session('success'))
                <div class="st-alert st-alert--success" role="alert">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="st-alert st-alert--error" role="alert">
                    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('settings-content')

        </div>
    </div>
</div>

@endsection
