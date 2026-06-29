@extends('settings.index')

@section('settings-content')

<div class="st-page">

    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="privacy-heading">

            <div class="st-card__head">
                <h2 id="privacy-heading" class="st-card__heading">プライバシー設定</h2>
                <p class="st-card__lead">あなたの情報やアクティビティの公開範囲を管理できます。</p>
            </div>

            <form action="{{ route('settings.privacy.update') }}" method="POST" id="privacy-settings-form">
                @csrf
                @method('PATCH')

                {{--  1. アカウントのプライバシー  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-user-shield" aria-hidden="true"></i> アカウントのプライバシー
                    </h3>

                    @foreach ($privacy->account as $item)
                        @if ($item['type'] === 'toggle')
                            <div class="st-toggle-row">
                                <div class="st-toggle-row__body">
                                    <p class="st-toggle-row__label">{{ $item['label'] }}</p>
                                    @if (!empty($item['desc']))
                                        <p class="st-toggle-row__desc">{{ $item['desc'] }}</p>
                                    @endif
                                </div>
                                <label class="st-toggle" aria-label="{{ $item['label'] }}">
                                    <input type="checkbox" name="{{ $item['key'] }}" value="1"
                                           {{ $item['enabled'] ? 'checked' : '' }}>
                                    <span class="st-toggle__slider"></span>
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{--  2. 投稿・アクティビティの公開範囲  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-regular fa-eye" aria-hidden="true"></i> 投稿・アクティビティの公開範囲
                    </h3>

                    @foreach ($privacy->activity as $item)
                        @if ($item['type'] === 'select')
                            <div class="st-privacy-row">
                                <div class="st-privacy-row__body">
                                    <label class="st-privacy-row__label" for="{{ $item['key'] }}">{{ $item['label'] }}</label>
                                    @if (!empty($item['desc']))
                                        <p class="st-privacy-row__desc">{{ $item['desc'] }}</p>
                                    @endif
                                </div>
                                <select id="{{ $item['key'] }}" name="{{ $item['key'] }}" class="st-select">
                                    @foreach ($item['options'] as $value => $label)
                                        <option value="{{ $value }}" {{ $item['value'] === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="st-toggle-row">
                                <div class="st-toggle-row__body">
                                    <p class="st-toggle-row__label">{{ $item['label'] }}</p>
                                    @if (!empty($item['desc']))
                                        <p class="st-toggle-row__desc">{{ $item['desc'] }}</p>
                                    @endif
                                </div>
                                <label class="st-toggle" aria-label="{{ $item['label'] }}">
                                    <input type="checkbox" name="{{ $item['key'] }}" value="1"
                                           {{ $item['enabled'] ? 'checked' : '' }}>
                                    <span class="st-toggle__slider"></span>
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{--  3. 位置情報・ロケーション  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i> 位置情報・ロケーション
                    </h3>

                    @foreach ($privacy->location as $item)
                        @if ($item['type'] === 'select')
                            <div class="st-privacy-row">
                                <div class="st-privacy-row__body">
                                    <label class="st-privacy-row__label" for="{{ $item['key'] }}">{{ $item['label'] }}</label>
                                    @if (!empty($item['desc']))
                                        <p class="st-privacy-row__desc">{{ $item['desc'] }}</p>
                                    @endif
                                </div>
                                <select id="{{ $item['key'] }}" name="{{ $item['key'] }}" class="st-select">
                                    @foreach ($item['options'] as $value => $label)
                                        <option value="{{ $value }}" {{ $item['value'] === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="st-toggle-row">
                                <div class="st-toggle-row__body">
                                    <p class="st-toggle-row__label">{{ $item['label'] }}</p>
                                    @if (!empty($item['desc']))
                                        <p class="st-toggle-row__desc">{{ $item['desc'] }}</p>
                                    @endif
                                </div>
                                <label class="st-toggle" aria-label="{{ $item['label'] }}">
                                    <input type="checkbox" name="{{ $item['key'] }}" value="1"
                                           {{ $item['enabled'] ? 'checked' : '' }}>
                                    <span class="st-toggle__slider"></span>
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{--  4. メッセージ・検索のプライバシー  --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-regular fa-envelope" aria-hidden="true"></i> メッセージ・検索のプライバシー
                    </h3>

                    @foreach ($privacy->message as $item)
                        @if ($item['type'] === 'select')
                            <div class="st-privacy-row">
                                <div class="st-privacy-row__body">
                                    <label class="st-privacy-row__label" for="{{ $item['key'] }}">{{ $item['label'] }}</label>
                                    @if (!empty($item['desc']))
                                        <p class="st-privacy-row__desc">{{ $item['desc'] }}</p>
                                    @endif
                                </div>
                                <select id="{{ $item['key'] }}" name="{{ $item['key'] }}" class="st-select">
                                    @foreach ($item['options'] as $value => $label)
                                        <option value="{{ $value }}" {{ $item['value'] === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="st-toggle-row">
                                <div class="st-toggle-row__body">
                                    <p class="st-toggle-row__label">{{ $item['label'] }}</p>
                                    @if (!empty($item['desc']))
                                        <p class="st-toggle-row__desc">{{ $item['desc'] }}</p>
                                    @endif
                                </div>
                                <label class="st-toggle" aria-label="{{ $item['label'] }}">
                                    <input type="checkbox" name="{{ $item['key'] }}" value="1"
                                           {{ $item['enabled'] ? 'checked' : '' }}>
                                    <span class="st-toggle__slider"></span>
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>

            </form>

            <p class="st-privacy-note">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                プライバシー設定はいつでも変更できます。保存後すぐに反映されます。
            </p>

            <div class="st-card__footer-bar">
                <button type="submit" form="privacy-settings-form" class="st-btn st-btn--primary">
                    設定を保存
                </button>
            </div>

        </section>

    </div>


    {{-- 右サイドバー --}}
    <aside class="st-page__aside" aria-label="プライバシープレビュー">

        {{-- ライブプレビュー --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> ライブプレビュー
            </h3>
            <p class="st-widget__sub">他のユーザーから見えるプロフィールのイメージ</p>

            <div class="st-privacy-preview">
                <div class="st-privacy-preview__banner"></div>
                <div class="st-privacy-preview__card">
                    <div class="st-privacy-preview__avatar">{{ mb_substr($user->name, 0, 1) }}</div>
                    <p class="st-privacy-preview__name">{{ $user->name }}</p>
                    <p class="st-privacy-preview__handle">{{ '@' . $user->username }}</p>
                    <p class="st-privacy-preview__bio">{{ $user->bio }}</p>
                    <div class="st-privacy-preview__stat">
                        <span class="st-privacy-preview__stat-num">{{ number_format($user->posts_count) }}</span>
                        <span class="st-privacy-preview__stat-label">Posts</span>
                    </div>
                </div>
                <ul class="st-privacy-preview__summary" role="list">
                    @foreach ($privacy->preview_summary as $row)
                        <li>
                            <span>{{ $row['label'] }}</span>
                            <span>{{ $row['value'] }}</span>
                        </li>
                    @endforeach
                </ul>
                <button type="button" class="st-btn st-btn--ghost st-btn--full st-btn--sm">プレビューを更新</button>
            </div>
        </div>

        {{-- プライバシーステータス --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i> プライバシーステータス
            </h3>

            <div class="st-safety-status">
                <div class="st-safety-status__icon" aria-hidden="true">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <p class="st-safety-status__label">プライバシー保護レベル</p>
                <p class="st-safety-status__value">{{ $privacy->protection_level }}</p>
            </div>

            <ul class="st-safety-checklist" role="list">
                @foreach ($privacy->status_checklist as $item)
                    <li class="st-safety-checklist__item">
                        <span>{{ $item['label'] }}</span>
                        <span class="st-safety-checklist__tag">{{ $item['status'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- プライバシーガイド --}}
        <div class="st-privacy-guide-card">
            <div class="st-privacy-guide-card__icon" aria-hidden="true">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="st-privacy-guide-card__title">プライバシーガイド</h3>
            <p class="st-privacy-guide-card__desc">
                マーケット・病院検索・スポット投稿など、KREDON Cebu での個人情報の取り扱いについて学べます。
            </p>
            <a href="{{ route('settings.privacy.guide') }}" class="st-btn st-btn--primary st-btn--full st-btn--sm">
                ガイドを見る
                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
            </a>
        </div>

    </aside>

</div>

@endsection
