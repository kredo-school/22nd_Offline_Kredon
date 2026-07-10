@extends('settings.index')

@section('settings-content')

<div class="st-page">

    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="app-heading">

            <div class="st-card__head">
                <h2 id="app-heading" class="st-card__heading">App Settings</h2>
                <p class="st-card__lead">Customize app features and behavior.</p>
            </div>

            <form action="{{ route('settings.app.update') }}" method="POST" id="app-settings-form">
                @csrf
                @method('PATCH')

                {{--  AI・おすすめ設定  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> AI & Recommendations
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Enable AI Recommendations</p>
                            <p class="st-toggle-row__desc">Suggest spots and events based on your interests.</p>
                        </div>
                        <label class="st-toggle" aria-label="Enable AI Recommendations">
                            <input type="checkbox" name="ai_recommendations" value="1"
                                   data-app-preview="ai-spots"
                                   {{ $app->ai_recommendations ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Continue Interest Learning</p>
                            <p class="st-toggle-row__desc">Learn from your activity to provide more accurate recommendations.</p>
                        </div>
                        <label class="st-toggle" aria-label="Continue Interest Learning">
                            <input type="checkbox" name="continue_learning" value="1"
                                   {{ $app->continue_learning ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-app-action-row">
                        <div class="st-app-action-row__body">
                            <p class="st-app-action-row__label">Reset Recommendations</p>
                            <p class="st-app-action-row__desc">Clear learning history and start recommendations from scratch.</p>
                        </div>
                        <button type="button" class="st-btn st-btn--ghost st-btn--sm" disabled title="Coming soon">Reset</button>
                    </div>
                </div>

                {{--  言語・翻訳設定  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-language" aria-hidden="true"></i> Language & Translation
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Enable Auto-translation</p>
                            <p class="st-toggle-row__desc">Automatically translate foreign-language posts and comments into Japanese.</p>
                        </div>
                        <label class="st-toggle" aria-label="Enable Auto-translation">
                            <input type="checkbox" name="auto_translate" value="1"
                                   data-app-preview="translate"
                                   {{ $app->auto_translate ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-privacy-row">
                        <div class="st-privacy-row__body">
                            <label class="st-privacy-row__label" for="translate_language">Translation Language</label>
                            <p class="st-privacy-row__desc">Choose the language for translated content.</p>
                        </div>
                        <select id="translate_language" name="translate_language" class="st-select"
                                data-app-preview="translate-lang">
                            @foreach ($app->translate_languages as $value => $label)
                                <option value="{{ $value }}" {{ $app->translate_language === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{--  データ・パフォーマンス  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-database" aria-hidden="true"></i> Data & Performance
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Data Saver Mode</p>
                            <p class="st-toggle-row__desc">Optimize image and video loading to reduce data usage.</p>
                        </div>
                        <label class="st-toggle" aria-label="Data Saver Mode">
                            <input type="checkbox" name="data_saver" value="1"
                                   data-app-preview="data-saver"
                                   {{ $app->data_saver ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">HD Only on Wi-Fi</p>
                            <p class="st-toggle-row__desc">Show high-quality media on Wi-Fi; use lightweight versions on mobile data.</p>
                        </div>
                        <label class="st-toggle" aria-label="HD Only on Wi-Fi">
                            <input type="checkbox" name="wifi_hd_only" value="1"
                                   {{ $app->wifi_hd_only ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-app-action-row">
                        <div class="st-app-action-row__body">
                            <p class="st-app-action-row__label">Clear Cache</p>
                            <p class="st-app-action-row__desc">Delete temporary data stored in your browser.</p>
                        </div>
                        <button type="button" class="st-btn st-btn--ghost st-btn--sm" id="app-clear-cache">
                            Clear Cache
                        </button>
                    </div>
                </div>

                {{--  スポット・マップ設定  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Spots & Map
                    </h3>

                    <div class="st-privacy-row">
                        <div class="st-privacy-row__body">
                            <label class="st-privacy-row__label" for="spot_priority">Recommended Spot Priority</label>
                            <p class="st-privacy-row__desc">Set the sort order for AI recommendations and spot listings.</p>
                        </div>
                        <select id="spot_priority" name="spot_priority" class="st-select">
                            @foreach ($app->spot_priority_options as $value => $label)
                                <option value="{{ $value }}" {{ $app->spot_priority === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="st-privacy-row">
                        <div class="st-privacy-row__body">
                            <label class="st-privacy-row__label" for="map_priority">Map Display Priority</label>
                            <p class="st-privacy-row__desc">Choose which information to prioritize on the map.</p>
                        </div>
                        <select id="map_priority" name="map_priority" class="st-select">
                            @foreach ($app->map_priority_options as $value => $label)
                                <option value="{{ $value }}" {{ $app->map_priority === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Improve Location Accuracy</p>
                            <p class="st-toggle-row__desc">Get a more precise location to recommend nearby spots.</p>
                        </div>
                        <label class="st-toggle" aria-label="Improve Location Accuracy">
                            <input type="checkbox" name="location_accuracy" value="1"
                                   {{ $app->location_accuracy ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>
                </div>

                {{--  その他  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-ellipsis" aria-hidden="true"></i> Other
                    </h3>

                    <div class="st-link-row st-link-row--static">
                        <div>
                            <p class="st-link-row__label">App Version</p>
                        </div>
                        <span class="st-link-row__meta">v{{ $app->app_version }}</span>
                    </div>

                    <a href="#" class="st-link-row">
                        <div>
                            <p class="st-link-row__label">Terms of Service & Licenses</p>
                        </div>
                        <span class="st-link-row__meta">
                            <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                        </span>
                    </a>
                </div>

            </form>

            <div class="st-card__footer-bar">
                <button type="submit" form="app-settings-form" class="st-btn st-btn--primary">
                    Save Settings
                </button>
            </div>

        </section>

    </div>


    {{-- 右サイドバー: ライブプレビュー --}}
    <aside class="st-page__aside" aria-label="App preview">

        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> Live Preview
            </h3>
            <p class="st-widget__sub">See how your settings affect the app</p>

            <div class="st-app-preview" id="app-preview-root">

                {{-- プロフィールカード --}}
                <div class="st-app-preview__profile">
                    <div class="st-preview__card">
                        <div class="st-preview__avatar">{{ mb_substr($user->name, 0, 1) }}</div>
                        @if ($user->plan === 'premium')
                            <span class="st-preview__premium-tag">PREMIUM</span>
                        @endif
                        <p class="st-preview__name">{{ $user->name }}</p>
                        <p class="st-preview__handle">{{ '@' . $user->username }}</p>
                        <div class="st-preview__stats">
                            <div class="st-preview__stat">
                                <span class="st-preview__stat-num">{{ number_format($user->posts_count) }}</span>
                                <span class="st-preview__stat-label">Posts</span>
                            </div>
                        </div>
                        <p class="st-preview__bio">{{ $user->bio }}</p>
                    </div>
                </div>

                {{-- AIおすすめスポット --}}
                <div class="st-app-preview__spots {{ ($app->ai_recommendations && count($app->recommended_spots)) ? '' : 'is-hidden' }}"
                     id="app-preview-spots">
                    <p class="st-app-preview__spots-title">
                        <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> AI Recommendations
                    </p>
                    <div class="st-app-spot-scroll">
                        @forelse ($app->recommended_spots as $spot)
                            <article class="st-app-spot-card">
                                <div class="st-app-spot-card__image"
                                     style="background: {{ $spot['gradient'] ?? 'linear-gradient(135deg, #2A87C8 0%, #6BBD99 100%)' }}"></div>
                                <p class="st-app-spot-card__name">{{ $spot['name'] }}</p>
                                <p class="st-app-spot-card__meta">
                                    <i class="fa-solid fa-star" aria-hidden="true"></i> {{ $spot['rating'] ?? '—' }}
                                    · {{ $spot['location'] ?? '' }}
                                </p>
                            </article>
                        @empty
                            <p class="st-app-preview__empty">No recommended spots yet</p>
                        @endforelse
                    </div>
                </div>

                {{-- 通知プレビュー --}}
                <div class="st-app-preview__notif">
                    <p class="st-app-preview__notif-title">
                        <i class="fa-regular fa-bell" aria-hidden="true"></i> Notifications
                    </p>
                    <ul class="st-notif-list" role="list">
                        @forelse ($app->preview_notifications as $notif)
                            <li class="st-notif-list__item">
                                <span class="st-notif-list__icon st-notif-list__icon--{{ $notif['color'] }}" aria-hidden="true">
                                    <i class="{{ $notif['icon'] }}"></i>
                                </span>
                                <div>
                                    <p class="st-notif-list__text">{{ $notif['text'] }}</p>
                                    <p class="st-notif-list__time">{{ $notif['time'] }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="st-notif-list__item st-notif-list__item--empty">
                                <p class="st-notif-list__text">No notifications yet</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- アプリステータス --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-circle-info" aria-hidden="true"></i> App Status
            </h3>

            <dl class="st-status-list">
                <div class="st-status-list__row">
                    <dt>Data Saver</dt>
                    <dd id="app-status-data-saver">{{ $app->status_summary['data_saver'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>Auto-translation</dt>
                    <dd id="app-status-translate">{{ $app->status_summary['auto_translate'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>App Version</dt>
                    <dd>v{{ $app->app_version }}</dd>
                </div>
            </dl>

            <form action="{{ route('settings.app.reset') }}" method="POST">
                @csrf
                <button type="submit" class="st-btn st-btn--outline-danger st-btn--full st-btn--sm">
                    Reset All Settings
                </button>
            </form>
        </div>

    </aside>

</div>

@endsection
