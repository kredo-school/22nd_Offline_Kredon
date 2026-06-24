@extends('settings.index')

@section('settings-content')

<div class="st-page">

    {{-- メイン: コメント・安全設定 --}}
    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="comment-heading">

            <div class="st-card__head">
                <h2 id="comment-heading" class="st-card__heading">コメント・安全設定</h2>
                <p class="st-card__lead">
                    快適で安全なコミュニティを維持するための設定をカスタマイズできます。
                </p>
            </div>

            {{--
                設定変更フォーム
                PATCH + @csrf: Laravel標準の更新リクエスト
                本番では各トグル変更時に個別送信 or JSでdebounce送信も可
            --}}
            <form action="{{ route('settings.comment.update') }}" method="POST" id="comment-settings-form">
                @csrf
                @method('PATCH')

                {{--  1. コメントの基本設定 --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-regular fa-comment" aria-hidden="true"></i> コメントの基本設定
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">コメントを許可する</p>
                            <p class="st-toggle-row__desc">あなたの投稿へのコメントを許可します。</p>
                        </div>
                        <label class="st-toggle" aria-label="コメントを許可する">
                            <input type="checkbox" name="allow_comments" value="1"
                                   {{ $comment->allow_comments ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    {{-- <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">フォロワー限定コメント</p>
                            <p class="st-toggle-row__desc">フォローしているユーザーのみコメントできます。</p>
                        </div>
                        <label class="st-toggle" aria-label="フォロワー限定コメント">
                            <input type="checkbox" name="follower_only" value="1"
                                   {{ $comment->follower_only ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div> --}}

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">コメントの事前承認</p>
                            <p class="st-toggle-row__desc">コメントはあなたの承認後に公開されます。</p>
                        </div>
                        <label class="st-toggle" aria-label="コメントの事前承認">
                            <input type="checkbox" name="pre_approval" value="1"
                                   {{ $comment->pre_approval ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>
                </div>

                {{--  2. NGワード・フィルター --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-filter" aria-hidden="true"></i> NGワード・フィルター
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">NGワードフィルター</p>
                            <p class="st-toggle-row__desc">設定したNGワードを含むコメントを自動的に非表示にします。</p>
                        </div>
                        <div class="st-toggle-row__action">
                            <button type="button" class="st-btn st-btn--ghost st-btn--sm">NGワードを管理</button>
                            <label class="st-toggle" aria-label="NGワードフィルター">
                                <input type="checkbox" name="ng_word_filter" value="1"
                                       {{ $comment->ng_word_filter ? 'checked' : '' }}>
                                <span class="st-toggle__slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- セグメントコントロール: ラジオボタンで1つだけ選択 --}}
                    <p class="st-segment__label">NGワード強度</p>
                    <div class="st-segment" role="group" aria-label="NGワード強度">
                        @foreach (['low' => '低', 'standard' => '標準', 'high' => '高'] as $value => $label)
                            <label class="st-segment__btn {{ $comment->ng_word_strength === $value ? 'is-active' : '' }}">
                                <input type="radio" name="ng_word_strength" value="{{ $value }}"
                                       {{ $comment->ng_word_strength === $value ? 'checked' : '' }}
                                       class="visually-hidden">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- 3. スパム・不正対策 --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i> スパム・不正対策
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">スパム検出</p>
                            <p class="st-toggle-row__desc">スパムの可能性が高いコメントを自動検出して非表示にします。</p>
                        </div>
                        <label class="st-toggle" aria-label="スパム検出">
                            <input type="checkbox" name="spam_detection" value="1"
                                   {{ $comment->spam_detection ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">
                                AIモデレーション
                                <span class="st-badge st-badge--recommend">おすすめ</span>
                            </p>
                            <p class="st-toggle-row__desc">AIが不適切なコメントを自動検出・処理します。</p>
                        </div>
                        <label class="st-toggle" aria-label="AIモデレーション">
                            <input type="checkbox" name="ai_moderation" value="1"
                                   {{ $comment->ai_moderation ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>
                </div>

            </form>

            {{-- 4. ブロック・ミュート管理（リンク行） --}}
            <div class="st-section-block">
                <h3 class="st-section-block__title">
                    <i class="fa-solid fa-ban" aria-hidden="true"></i> ブロック・ミュート管理
                </h3>

                <a href="#" class="st-link-row">
                    <span class="st-link-row__label">ブロックしたユーザー</span>
                    <span class="st-link-row__meta">
                        {{ $comment->blocked_count }}人
                        <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                    </span>
                </a>
                <a href="#" class="st-link-row">
                    <span class="st-link-row__label">ミュートしたユーザー</span>
                    <span class="st-link-row__meta">
                        {{ $comment->muted_count }}人
                        <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                    </span>
                </a>
                <a href="#" class="st-link-row">
                    <span class="st-link-row__label">キーワードミュート</span>
                    <span class="st-link-row__meta">
                        {{ $comment->keyword_mute_count }}件
                        <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                    </span>
                </a>
            </div>

            {{-- 5. レポート・履歴 --}}
            <div class="st-section-block">
                <h3 class="st-section-block__title">
                    <i class="fa-solid fa-flag" aria-hidden="true"></i> レポート・履歴
                </h3>

                <a href="#" class="st-link-row">
                    <span class="st-link-row__label">違反報告履歴</span>
                    <span class="st-link-row__meta">
                        <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                    </span>
                </a>
                <a href="#" class="st-link-row">
                    <span class="st-link-row__label">モデレーション履歴</span>
                    <span class="st-link-row__meta">
                        <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                    </span>
                </a>
            </div>

            {{-- フォーム送信ボタン --}}
            <div class="st-card__footer-bar">
                <button type="submit" form="comment-settings-form" class="st-btn st-btn--primary">
                    設定を保存
                </button>
            </div>

        </section>

    </div>


    {{-- 右サイドバー: プレビュー & 安全ステータ --}}
    <aside class="st-page__aside" aria-label="コメント設定プレビュー">

        {{-- ライブプレビュー（投稿表示） --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> ライブプレビュー
            </h3>
            <p class="st-widget__sub">あなたの投稿はこのように表示されます</p>

            <div class="st-post-preview">
                <div class="st-post-preview__head">
                    <div class="st-post-preview__avatar">{{ mb_substr($user->name, 0, 1) }}</div>
                    <div class="st-post-preview__meta">
                        <p class="st-post-preview__name">
                            {{ $user->name }}
                            @if ($user->plan === 'premium')
                                <span class="st-preview__premium-tag">PREMIUM</span>
                            @endif
                        </p>
                        <p class="st-post-preview__time">{{ $comment->preview_post['time'] }}</p>
                    </div>
                </div>
                <p class="st-post-preview__text">{{ $comment->preview_post['text'] }}</p>
                @if ($comment->preview_post['image'])
                    <div class="st-post-preview__image" role="img" aria-label="投稿画像プレビュー"></div>
                @endif
                {{-- いいね機能は未実装のため除外。コメント・ブックマーク・その他のみ --}}
                <div class="st-post-preview__actions" aria-label="投稿アクション">
                    <i class="fa-regular fa-comment" title="コメント"></i>
                    <i class="fa-regular fa-bookmark" title="ブックマーク"></i>
                    <i class="fa-solid fa-ellipsis" title="その他"></i>
                </div>
            </div>
        </div>

        {{-- コメントのプレビュー  --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-comments" aria-hidden="true"></i> コメントのプレビュー
            </h3>
            <ul class="st-comment-preview-list" role="list">
                @foreach ($comment->preview_comments as $previewComment)
                    <li class="st-comment-preview-list__item">
                        <div class="st-comment-preview-list__avatar">
                            {{ mb_substr($previewComment['name'], 0, 1) }}
                        </div>
                        <div>
                            <p class="st-comment-preview-list__name">
                                {{ $previewComment['name'] }}
                                @if ($previewComment['premium'])
                                    <span class="st-preview__premium-tag">PREMIUM</span>
                                @endif
                            </p>
                            <p class="st-comment-preview-list__text">{{ $previewComment['text'] }}</p>
                            <p class="st-comment-preview-list__time">{{ $previewComment['time'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
            <p class="st-comment-preview-list__note">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                不適切なコメントはフィルターにより非表示になります
            </p>
        </div>

        {{--  安全ステータス  --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i> 安全ステータス
            </h3>

            <div class="st-safety-status">
                <div class="st-safety-status__icon" aria-hidden="true">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <p class="st-safety-status__label">アカウントの安全性</p>
                <p class="st-safety-status__value">{{ $comment->safety_status }}</p>
            </div>

            <ul class="st-safety-checklist" role="list">
                @foreach ($comment->safety_features as $feature)
                    <li class="st-safety-checklist__item">
                        <span>{{ $feature['label'] }}</span>
                        <span class="st-safety-checklist__tag">{{ $feature['status'] }}</span>
                    </li>
                @endforeach
            </ul>

            <a href="#" class="st-btn st-btn--ghost st-btn--full">安全設定ガイドを見る</a>
        </div>

    </aside>

</div>
@endsection