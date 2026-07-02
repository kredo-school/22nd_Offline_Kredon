@extends('settings.index')

@section('settings-content')

<div class="st-page">

    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="notification-heading">

            <div class="st-card__head">
                <h2 id="notification-heading" class="st-card__heading">通知設定</h2>
                <p class="st-card__lead">受け取りたい通知をカスタマイズできます。</p>
            </div>

            <form action="{{ route('settings.notification.update') }}" method="POST" id="notification-settings-form">
                @csrf
                @method('PATCH')

                {{-- 通知の種類  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-regular fa-bell" aria-hidden="true"></i> 通知の種類
                    </h3>

                    @foreach ($notification->types as $type)
                        <div class="st-notify-row">
                            <span class="st-notify-row__icon st-notify-row__icon--{{ $type['color'] }}" aria-hidden="true">
                                <i class="{{ $type['icon'] }}"></i>
                            </span>
                            <div class="st-notify-row__body">
                                <p class="st-notify-row__label">{{ $type['label'] }}</p>
                                <p class="st-notify-row__desc">{{ $type['desc'] }}</p>
                            </div>
                            <label class="st-toggle" aria-label="{{ $type['label'] }}">
                                <input type="checkbox"
                                       name="notify_{{ $type['key'] }}"
                                       value="1"
                                       {{ $type['enabled'] ? 'checked' : '' }}>
                                <span class="st-toggle__slider"></span>
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- 通知の受け取り方法 --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i> 通知の受け取り方法
                    </h3>

                    @foreach ($notification->channels as $channel)
                        <div class="st-notify-row">
                            <span class="st-notify-row__icon st-notify-row__icon--gray" aria-hidden="true">
                                <i class="{{ $channel['icon'] }}"></i>
                            </span>
                            <div class="st-notify-row__body">
                                <p class="st-notify-row__label">{{ $channel['label'] }}</p>
                                <p class="st-notify-row__desc">{{ $channel['desc'] }}</p>
                            </div>
                            <label class="st-toggle" aria-label="{{ $channel['label'] }}">
                                <input type="checkbox"
                                       name="channel_{{ $channel['key'] }}"
                                       value="1"
                                       {{ $channel['enabled'] ? 'checked' : '' }}>
                                <span class="st-toggle__slider"></span>
                            </label>
                        </div>
                    @endforeach
                </div>

            </form>

            <div class="st-card__footer-bar">
                <button type="submit" form="notification-settings-form" class="st-btn st-btn--primary">
                    設定を保存
                </button>
            </div>

        </section>

    </div>


    {{-- 右サイドバー: プレビュー & ステータス --}}
    <aside class="st-page__aside" aria-label="通知プレビュー">

        {{--  ライブプレビュー（スマホモック）  --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> ライブプレビュー
            </h3>
            <p class="st-widget__sub">実際の通知のイメージを確認できます</p>

            <div class="st-phone-preview">
                <div class="st-phone-preview__frame">
                    <div class="st-phone-preview__header">
                        <span class="st-phone-preview__title">通知</span>
                        <button type="button" class="st-phone-preview__mark-read">すべて既読にする</button>
                    </div>
                    <ul class="st-phone-preview__list" role="list">
                        @forelse ($notification->preview_items as $item)
                            <li class="st-phone-preview__item">
                                <span class="st-phone-preview__item-icon st-notify-row__icon st-notify-row__icon--{{ $item['color'] }}">
                                    <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                                </span>
                                <div class="st-phone-preview__item-body">
                                    <p class="st-phone-preview__item-text">{{ $item['text'] }}</p>
                                    <p class="st-phone-preview__item-time">{{ $item['time'] }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="st-phone-preview__item st-phone-preview__item--empty">
                                <p class="st-phone-preview__item-text">通知はまだありません</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{--  通知ステータス  --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-circle-info" aria-hidden="true"></i> 通知ステータス
            </h3>

            <dl class="st-status-list">
                <div class="st-status-list__row">
                    <dt>全体設定</dt>
                    <dd><span class="st-badge st-badge--active">{{ $notification->status_summary['general'] }}</span></dd>
                </div>
                <div class="st-status-list__row">
                    <dt>プッシュ通知</dt>
                    <dd>{{ $notification->status_summary['push'] }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>メール通知</dt>
                    <dd>{{ $notification->status_summary['email'] }}</dd>
                </div>
            </dl>

            <form action="{{ route('settings.notification.reset') }}" method="POST">
                @csrf
                <button type="submit" class="st-btn st-btn--outline-danger st-btn--full st-btn--sm">
                    通知設定をリセット
                </button>
            </form>
        </div>

        {{--  トラブルシューティング  --}}
        <a href="#" class="st-notify-help">
            <i class="fa-solid fa-life-ring" aria-hidden="true"></i>
            <span>通知が届かない場合</span>
            <i class="fa-solid fa-chevron-right st-notify-help__chevron" aria-hidden="true"></i>
        </a>

    </aside>

</div>

@endsection
