@extends('settings.index')

@section('settings-content')

<div class="st-page">

    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="app-heading">

            <div class="st-card__head">
                <h2 id="app-heading" class="st-card__heading">アプリ設定</h2>
                <p class="st-card__lead">アプリの機能や動作に関する設定をカスタマイズできます。</p>
            </div>

            <form action="{{ route('settings.app.update') }}" method="POST" id="app-settings-form">
                @csrf
                @method('PATCH')

                {{--  AI・おすすめ設定  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> AI・おすすめ設定
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">AIおすすめを有効にする</p>
                            <p class="st-toggle-row__desc">あなたの興味に基づいてスポットやイベントを提案します。</p>
                        </div>
                        <label class="st-toggle" aria-label="AIおすすめを有効にする">
                            <input type="checkbox" name="ai_recommendations" value="1"
                                   data-app-preview="ai-spots"
                                   {{ $app->ai_recommendations ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">興味の学習を続ける</p>
                            <p class="st-toggle-row__desc">あなたの行動から学習し、より精度の高いおすすめを提供します。</p>
                        </div>
                        <label class="st-toggle" aria-label="興味の学習を続ける">
                            <input type="checkbox" name="continue_learning" value="1"
                                   {{ $app->continue_learning ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-app-action-row">
                        <div class="st-app-action-row__body">
                            <p class="st-app-action-row__label">おすすめをリセット</p>
                            <p class="st-app-action-row__desc">学習履歴をリセットし、おすすめを最初からやり直します。</p>
                        </div>
                        <button type="button" class="st-btn st-btn--ghost st-btn--sm">リセットする</button>
                    </div>
                </div>

                {{--  言語・翻訳設定  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-language" aria-hidden="true"></i> 言語・翻訳設定
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">自動翻訳を有効にする</p>
                            <p class="st-toggle-row__desc">外国語の投稿やコメントを自動的に日本語に翻訳します。</p>
                        </div>
                        <label class="st-toggle" aria-label="自動翻訳を有効にする">
                            <input type="checkbox" name="auto_translate" value="1"
                                   data-app-preview="translate"
                                   {{ $app->auto_translate ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-privacy-row">
                        <div class="st-privacy-row__body">
                            <label class="st-privacy-row__label" for="translate_language">翻訳言語</label>
                            <p class="st-privacy-row__desc">翻訳結果の表示言語を選択します。</p>
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
                        <i class="fa-solid fa-database" aria-hidden="true"></i> データ・パフォーマンス
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">データセーバーモード</p>
                            <p class="st-toggle-row__desc">画像・動画の読み込みを最適化し、データ使用量を節約します。</p>
                        </div>
                        <label class="st-toggle" aria-label="データセーバーモード">
                            <input type="checkbox" name="data_saver" value="1"
                                   data-app-preview="data-saver"
                                   {{ $app->data_saver ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Wi-Fi時のみ高画質表示</p>
                            <p class="st-toggle-row__desc">Wi-Fi接続時のみ高画質、モバイルデータ時は軽量版を表示します。</p>
                        </div>
                        <label class="st-toggle" aria-label="Wi-Fi時のみ高画質表示">
                            <input type="checkbox" name="wifi_hd_only" value="1"
                                   {{ $app->wifi_hd_only ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-app-action-row">
                        <div class="st-app-action-row__body">
                            <p class="st-app-action-row__label">キャッシュを削除</p>
                            <p class="st-app-action-row__desc">一時ファイルを削除してストレージを解放します。</p>
                        </div>
                        <button type="button" class="st-btn st-btn--ghost st-btn--sm" id="app-clear-cache">
                            キャッシュを削除
                        </button>
                    </div>

                    <a href="#" class="st-link-row">
                        <div>
                            <p class="st-link-row__label">ストレージ使用量</p>
                        </div>
                        <span class="st-link-row__meta">
                            {{ $app->cache_size }}
                            <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                        </span>
                    </a>
                </div>

                {{--  スポット・マップ設定  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> スポット・マップ設定
                    </h3>

                    <div class="st-privacy-row">
                        <div class="st-privacy-row__body">
                            <label class="st-privacy-row__label" for="spot_priority">おすすめスポットの優先度</label>
                            <p class="st-privacy-row__desc">AIおすすめや一覧の並び順を設定します。</p>
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
                            <label class="st-privacy-row__label" for="map_priority">マップ表示の優先度</label>
                            <p class="st-privacy-row__desc">マップ上で優先的に表示する情報を選びます。</p>
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
                            <p class="st-toggle-row__label">位置情報の精度を改善</p>
                            <p class="st-toggle-row__desc">現在地をより正確に取得し、近くのスポットをおすすめします。</p>
                        </div>
                        <label class="st-toggle" aria-label="位置情報の精度を改善">
                            <input type="checkbox" name="location_accuracy" value="1"
                                   {{ $app->location_accuracy ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>
                </div>

                {{--  その他  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-ellipsis" aria-hidden="true"></i> その他
                    </h3>

                    <a href="#" class="st-link-row">
                        <div>
                            <p class="st-link-row__label">アプリバージョン</p>
                        </div>
                        <span class="st-link-row__meta">
                            {{ $app->app_version }}
                            <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                        </span>
                    </a>

                    <a href="#" class="st-link-row">
                        <div>
                            <p class="st-link-row__label">利用規約・ライセンス</p>
                        </div>
                        <span class="st-link-row__meta">
                            <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                        </span>
                    </a>
                </div>

            </form>

            <div class="st-card__footer-bar">
                <button type="submit" form="app-settings-form" class="st-btn st-btn--primary">
                    設定を保存
                </button>
            </div>

        </section>

    </div>


    {{-- 右サイドバー: ライブプレビュー --}}
    <aside class="st-page__aside" aria-label="アプリプレビュー">

        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> ライブプレビュー
            </h3>
            <p class="st-widget__sub">設定がアプリにどう反映されるか確認できます</p>

            <div class="st-app-preview" id="app-preview-root">

                {{-- プロフィールカード --}}
                <div class="st-app-preview__profile">
                    <div class="st-preview__banner">
                        <div class="st-preview__event">
                            <p class="st-preview__event-title">{{ $user->preview_event['title'] }}</p>
                            <p class="st-preview__event-date">{{ $user->preview_event['date'] }}</p>
                        </div>
                    </div>
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
                <div class="st-app-preview__spots {{ $app->ai_recommendations ? '' : 'is-hidden' }}"
                     id="app-preview-spots">
                    <p class="st-app-preview__spots-title">
                        <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> AIおすすめ
                    </p>
                    <div class="st-app-spot-scroll">
                        @foreach ($app->recommended_spots as $spot)
                            <article class="st-app-spot-card">
                                <div class="st-app-spot-card__image"
                                     style="background: {{ $spot['gradient'] }}"></div>
                                <p class="st-app-spot-card__name">{{ $spot['name'] }}</p>
                                <p class="st-app-spot-card__meta">
                                    <i class="fa-solid fa-star" aria-hidden="true"></i> {{ $spot['rating'] }}
                                    · {{ $spot['location'] }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </div>

                {{-- 通知プレビュー --}}
                <div class="st-app-preview__notif">
                    <p class="st-app-preview__notif-title">
                        <i class="fa-regular fa-bell" aria-hidden="true"></i> 通知
                    </p>
                    <ul class="st-notif-list" role="list">
                        @foreach ($app->preview_notifications as $notif)
                            <li class="st-notif-list__item">
                                <span class="st-notif-list__icon st-notif-list__icon--{{ $notif['color'] }}" aria-hidden="true">
                                    <i class="{{ $notif['icon'] }}"></i>
                                </span>
                                <div>
                                    <p class="st-notif-list__text">{{ $notif['text'] }}</p>
                                    <p class="st-notif-list__time">{{ $notif['time'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- アプリステータス --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-circle-info" aria-hidden="true"></i> アプリステータス
            </h3>

            <dl class="st-status-list">
                <div class="st-status-list__row">
                    <dt>データセーバー</dt>
                    <dd id="app-status-data-saver">{{ $app->status_summary['data_saver'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>自動翻訳</dt>
                    <dd id="app-status-translate">{{ $app->status_summary['auto_translate'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>キャッシュサイズ</dt>
                    <dd id="app-status-cache">{{ $app->status_summary['cache_size'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>ストレージ空き</dt>
                    <dd>{{ $app->status_summary['storage_free'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>ネットワーク</dt>
                    <dd>{{ $app->status_summary['network'] }}</dd>
                </div>
            </dl>

            <button type="button" class="st-btn st-btn--outline-danger st-btn--full st-btn--sm">
                すべての設定をリセット
            </button>
        </div>

    </aside>

</div>

@endsection
