@extends('settings.index')

@section('settings-content')

@php
    $currentCharacter = collect($display->characters)->firstWhere('id', $display->character_id)
        ?? $display->characters[0];
@endphp

<div class="st-page">

    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="display-heading">

            <div class="st-card__head">
                <h2 id="display-heading" class="st-card__heading">Display Settings</h2>
                <p class="st-card__lead">
                    Customize the site appearance, including color mode and login screen characters.
                </p>
            </div>

            <form action="{{ route('settings.display.update') }}" method="POST" id="display-settings-form">
                @csrf
                @method('PATCH')

                {{-- 外観モード（ダークモード） --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-circle-half-stroke" aria-hidden="true"></i> Appearance Mode
                    </h3>

                    <p class="st-display-note">
                        Choose the color scheme for the entire site. Dark mode is helpful for nighttime browsing and reducing eye strain.
                    </p>

                    <div class="st-color-mode" role="radiogroup" aria-label="Appearance mode">
                        @foreach ($display->color_modes as $mode)
                            <label class="st-color-mode__option {{ $display->color_mode === $mode['value'] ? 'is-active' : '' }}">
                                <input type="radio"
                                       name="color_mode"
                                       value="{{ $mode['value'] }}"
                                       data-preview-label="{{ $mode['label'] }}"
                                       {{ $display->color_mode === $mode['value'] ? 'checked' : '' }}>
                                <span class="st-color-mode__icon" aria-hidden="true">
                                    <i class="{{ $mode['icon'] }}"></i>
                                </span>
                                <span class="st-color-mode__body">
                                    <span class="st-color-mode__label">{{ $mode['label'] }}</span>
                                    <span class="st-color-mode__desc">{{ $mode['desc'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- キャラクター選択 --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-user-astronaut" aria-hidden="true"></i> Character
                    </h3>

                    <p class="st-display-note">
                        Choose the character shown on the login and registration screens. They serve as guides for this IT Park student-only site.
                    </p>

                    <div class="st-char-picker" role="radiogroup" aria-label="Character selection">
                        @foreach ($display->characters as $character)
                            <label class="st-char-picker__item {{ $display->character_id === $character['id'] ? 'is-selected' : '' }}"
                                   data-char-name="{{ $character['name'] }}"
                                   data-char-initial="{{ $character['initial'] }}"
                                   data-char-bg="{{ $character['bg'] }}"
                                   data-char-image="{{ asset($character['image']) }}">
                                <input type="radio"
                                       name="character_id"
                                       value="{{ $character['id'] }}"
                                       {{ $display->character_id === $character['id'] ? 'checked' : '' }}>
                                <span class="st-char-picker__visual st-char-picker__visual--{{ $character['accent'] }}">
                                    @if (file_exists(public_path(ltrim($character['image'], '/'))))
                                        <img src="{{ asset($character['image']) }}"
                                             alt="{{ $character['name'] }}"
                                             class="st-char-picker__img">
                                    @else
                                        <span class="st-char-picker__fallback"
                                              style="background: {{ $character['bg'] }}">
                                            {{ $character['initial'] }}
                                        </span>
                                    @endif
                                </span>
                                <span class="st-char-picker__name">{{ $character['name'] }}</span>
                                <span class="st-char-picker__desc">{{ $character['desc'] }}</span>
                                @if ($character['id'] === 'kuredon')
                                    <span class="st-badge st-badge--recommend">Recommended</span>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>

            </form>

            <div class="st-card__footer-bar">
                <button type="submit" form="display-settings-form" class="st-btn st-btn--primary">
                    Save Settings
                </button>
            </div>

        </section>

    </div>


    {{-- 右サイドバー: ライブプレビュー --}}
    <aside class="st-page__aside" aria-label="Display preview">

        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> Live Preview
            </h3>
            <p class="st-widget__sub">Preview of login, registration, and site UI</p>

            <div class="st-display-preview st-display-preview--{{ $display->color_mode }}"
                 id="display-preview-root"
                 data-color-mode="{{ $display->color_mode }}">

                {{-- 認証画面プレビュー（ログイン / 新規登録） --}}
                <div class="st-display-preview__tabs" role="tablist" aria-label="Auth screen preview">
                    <button type="button"
                            class="st-display-preview__tab is-active"
                            role="tab"
                            aria-selected="true"
                            data-auth-tab="login">
                        Log In
                    </button>
                    <button type="button"
                            class="st-display-preview__tab"
                            role="tab"
                            aria-selected="false"
                            data-auth-tab="register">
                        Sign Up
                    </button>
                </div>

                <div class="st-display-preview__auth" id="display-preview-auth-login" data-auth-panel="login">
                    <div class="st-display-preview__auth-card">
                        <div class="st-display-preview__auth-char" id="display-preview-char-login">
                            @include('settings.partials._display_char_visual', ['character' => $currentCharacter])
                        </div>
                        <p class="st-display-preview__auth-brand">KREDON Cebu</p>
                        <p class="st-display-preview__auth-title" id="display-preview-login-title">
                            {{ $display->preview['login_title'] }}
                        </p>
                        <p class="st-display-preview__auth-sub">IT Park — Japanese students only</p>
                        <div class="st-display-preview__auth-fields">
                            <span></span>
                            <span></span>
                        </div>
                        <span class="st-display-preview__auth-btn">Log In</span>
                    </div>
                </div>

                <div class="st-display-preview__auth is-hidden" id="display-preview-auth-register" data-auth-panel="register">
                    <div class="st-display-preview__auth-card">
                        <div class="st-display-preview__auth-char" id="display-preview-char-register">
                            @include('settings.partials._display_char_visual', ['character' => $currentCharacter])
                        </div>
                        <p class="st-display-preview__auth-brand">KREDON Cebu</p>
                        <p class="st-display-preview__auth-title" id="display-preview-register-title">
                            {{ $display->preview['register_title'] }}
                        </p>
                        <p class="st-display-preview__auth-sub">Create an account with your character</p>
                        <div class="st-display-preview__auth-fields">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <span class="st-display-preview__auth-btn">Sign Up</span>
                    </div>
                </div>

                {{-- アプリUIプレビュー --}}
                <div class="st-display-preview__app">
                    <div class="st-display-preview__app-head">
                        <span class="st-display-preview__app-logo">KREDON</span>
                        <span class="st-display-preview__app-badge">CEBU</span>
                    </div>
                    <div class="st-display-preview__app-post">
                        <div class="st-display-preview__app-avatar">{{ mb_substr($display->preview['sample_user'], 0, 1) }}</div>
                        <div class="st-display-preview__app-body">
                            <p class="st-display-preview__app-name">{{ $display->preview['sample_user'] }}</p>
                            <p class="st-display-preview__app-text">{{ $display->preview['sample_post'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 表示ステータス --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-circle-info" aria-hidden="true"></i> Display Status
            </h3>

            <dl class="st-status-list">
                <div class="st-status-list__row">
                    <dt>Appearance Mode</dt>
                    <dd id="display-status-mode">{{ $display->status_summary['color_mode'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>Character</dt>
                    <dd id="display-status-character">{{ $display->status_summary['character'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>Applied Screens</dt>
                    <dd>{{ $display->status_summary['auth_screens'] }}</dd>
                </div>
            </dl>

            <button type="button" class="st-btn st-btn--ghost st-btn--full st-btn--sm" id="display-preview-reset">
                Refresh Preview
            </button>
        </div>

    </aside>

</div>

@endsection
