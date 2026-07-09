@extends('settings.index')

@section('settings-content')

<div class="st-page">

    {{-- メイン: コメント・安全設定 --}}
    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="comment-heading">

            <div class="st-card__head">
                <h2 id="comment-heading" class="st-card__heading">Comments & Safety Settings</h2>
                <p class="st-card__lead">
                    Customize settings to maintain a comfortable and safe community.
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
                        <i class="fa-regular fa-comment" aria-hidden="true"></i> Basic Comment Settings
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Allow Comments</p>
                            <p class="st-toggle-row__desc">Allow others to comment on your posts.</p>
                        </div>
                        <label class="st-toggle" aria-label="Allow Comments">
                            <input type="checkbox" name="allow_comments" value="1"
                                   {{ $comment->allow_comments ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Comment Pre-approval</p>
                            <p class="st-toggle-row__desc">Comments will be published only after your approval.</p>
                        </div>
                        <label class="st-toggle" aria-label="Comment Pre-approval">
                            <input type="checkbox" name="pre_approval" value="1"
                                   {{ $comment->pre_approval ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>
                </div>

                {{--  2. NGワード・フィルター --}}
                <div class="st-section-block">
                    <h3 class="st-section-block__title">
                        <i class="fa-solid fa-filter" aria-hidden="true"></i> Blocked Words & Filters
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Blocked Word Filter</p>
                            <p class="st-toggle-row__desc">Automatically hide comments containing your blocked words.</p>
                        </div>
                        <div class="st-toggle-row__action">
                            <button type="button" class="st-btn st-btn--ghost st-btn--sm"
                                    onclick="document.getElementById('modal-ng-words').showModal()">
                                Manage Blocked Words ({{ $comment->ng_word_count }})
                            </button>
                            <label class="st-toggle" aria-label="Blocked Word Filter">
                                <input type="checkbox" name="ng_word_filter" value="1"
                                       {{ $comment->ng_word_filter ? 'checked' : '' }}>
                                <span class="st-toggle__slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- セグメントコントロール: ラジオボタンで1つだけ選択 --}}
                    <p class="st-segment__label">Filter Strength</p>
                    <div class="st-segment" role="group" aria-label="Filter strength">
                        @foreach (['low' => 'Low', 'standard' => 'Standard', 'high' => 'High'] as $value => $label)
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
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Spam & Abuse Protection
                    </h3>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">Spam Detection</p>
                            <p class="st-toggle-row__desc">Automatically detect and hide comments that are likely spam.</p>
                        </div>
                        <label class="st-toggle" aria-label="Spam Detection">
                            <input type="checkbox" name="spam_detection" value="1"
                                   {{ $comment->spam_detection ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>

                    <div class="st-toggle-row">
                        <div class="st-toggle-row__body">
                            <p class="st-toggle-row__label">
                                AI Moderation
                                <span class="st-badge st-badge--recommend">Recommended</span>
                            </p>
                            <p class="st-toggle-row__desc">AI automatically detects and handles inappropriate comments.</p>
                        </div>
                        <label class="st-toggle" aria-label="AI Moderation">
                            <input type="checkbox" name="ai_moderation" value="1"
                                   {{ $comment->ai_moderation ? 'checked' : '' }}>
                            <span class="st-toggle__slider"></span>
                        </label>
                    </div>
                </div>

            </form>

            {{-- ブロック・ミュート管理 --}}
            <div class="st-section-block">
                <h3 class="st-section-block__title">
                    <i class="fa-solid fa-ban" aria-hidden="true"></i> Block & Mute Management
                </h3>

                <button type="button" class="st-link-row st-link-row--button"
                        onclick="document.getElementById('modal-blocks').showModal()">
                    <span class="st-link-row__label">Blocked Users</span>
                    <span class="st-link-row__meta">
                        {{ $comment->blocked_count }}
                        <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                    </span>
                </button>
                <button type="button" class="st-link-row st-link-row--button"
                        onclick="document.getElementById('modal-keyword-mutes').showModal()">
                    <span class="st-link-row__label">Keyword Mutes</span>
                    <span class="st-link-row__meta">
                        {{ $comment->keyword_mute_count }}
                        <i class="fa-solid fa-chevron-right st-link-row__chevron" aria-hidden="true"></i>
                    </span>
                </button>
            </div>

            {{-- フォーム送信ボタン --}}
            <div class="st-card__footer-bar">
                <button type="submit" form="comment-settings-form" class="st-btn st-btn--primary">
                    Save Settings
                </button>
            </div>

        </section>

    </div>


    {{-- 右サイドバー: プレビュー & 安全ステータ --}}
    <aside class="st-page__aside" aria-label="Comment settings preview">

        {{-- ライブプレビュー（投稿表示） --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> Live Preview
            </h3>
            <p class="st-widget__sub">This is how your posts will appear</p>

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
                    <div class="st-post-preview__image" role="img" aria-label="Post image preview"></div>
                @endif
                {{-- いいね機能は未実装のため除外。コメント・ブックマーク・その他のみ --}}
                <div class="st-post-preview__actions" aria-label="Post actions">
                    <i class="fa-regular fa-comment" title="Comments"></i>
                    <i class="fa-regular fa-bookmark" title="Bookmark"></i>
                    <i class="fa-solid fa-ellipsis" title="More"></i>
                </div>
            </div>
        </div>

        {{-- コメント設定の説明 --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-comments" aria-hidden="true"></i> Comment Settings
            </h3>
            <p class="st-comment-preview-list__note">
                @if ($comment->allow_comments)
                    Comments are allowed.
                    @if ($comment->pre_approval)
                        Approval is required before publishing.
                    @endif
                @else
                    Comments are currently disabled.
                @endif
            </p>
            <p class="st-comment-preview-list__note">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                Blocked word filter: {{ $comment->ng_word_filter ? 'Enabled' : 'Disabled' }}
                (Strength: {{ ['low' => 'Low', 'standard' => 'Standard', 'high' => 'High'][$comment->ng_word_strength] ?? $comment->ng_word_strength }})
            </p>
        </div>

        {{--  安全ステータス  --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Safety Status
            </h3>

            <div class="st-safety-status">
                <div class="st-safety-status__icon" aria-hidden="true">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <p class="st-safety-status__label">Account Safety</p>
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

            <a href="{{ route('settings.privacy.guide') }}" class="st-btn st-btn--ghost st-btn--full">View Privacy Guide</a>
        </div>

    </aside>

</div>

{{-- ブロック管理モーダル --}}
<dialog id="modal-blocks" class="st-modal" aria-labelledby="modal-blocks-title">
    <div class="st-modal__inner">
        <h3 id="modal-blocks-title" class="st-modal__title st-modal__title--normal">Blocked Users</h3>

        @if (count($comment->blocked_users))
            <ul class="st-manage-list" role="list">
                @foreach ($comment->blocked_users as $blocked)
                    <li class="st-manage-list__item">
                        <div>
                            <p class="st-manage-list__label">{{ $blocked['name'] }}</p>
                            @if ($blocked['username'])
                                <p class="st-manage-list__meta">{{ '@' . $blocked['username'] }}</p>
                            @endif
                        </div>
                        <form action="{{ route('settings.comment.blocks.destroy', $blocked['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="st-btn st-btn--ghost st-btn--sm">Unblock</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="st-modal__desc">You have no blocked users.</p>
        @endif

        <form action="{{ route('settings.comment.blocks.store') }}" method="POST" class="st-field" style="margin-top:16px;">
            @csrf
            <label class="st-field__label" for="block_username">Block User</label>
            <div class="st-input-prefix">
                <span aria-hidden="true">@</span>
                <input type="text" id="block_username" name="username" class="st-input" placeholder="username" required>
            </div>
            @error('username')
                <p class="st-form-error" role="alert">{{ $message }}</p>
            @enderror
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-blocks').close()">Close</button>
                <button type="submit" class="st-btn st-btn--primary">Block</button>
            </div>
        </form>
    </div>
</dialog>

{{-- キーワードミュート管理モーダル --}}
<dialog id="modal-keyword-mutes" class="st-modal" aria-labelledby="modal-keyword-mutes-title">
    <div class="st-modal__inner">
        <h3 id="modal-keyword-mutes-title" class="st-modal__title st-modal__title--normal">Keyword Mutes</h3>

        @if (count($comment->keyword_mutes))
            <ul class="st-manage-list" role="list">
                @foreach ($comment->keyword_mutes as $mute)
                    <li class="st-manage-list__item">
                        <p class="st-manage-list__label">{{ $mute['keyword'] }}</p>
                        <form action="{{ route('settings.comment.keyword-mutes.destroy', $mute['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="st-btn st-btn--ghost st-btn--sm">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="st-modal__desc">You have no muted keywords.</p>
        @endif

        <form action="{{ route('settings.comment.keyword-mutes.store') }}" method="POST" class="st-field" style="margin-top:16px;">
            @csrf
            <label class="st-field__label" for="mute_keyword">Add Keyword</label>
            <input type="text" id="mute_keyword" name="keyword" class="st-input" maxlength="50" required>
            @error('keyword')
                <p class="st-form-error" role="alert">{{ $message }}</p>
            @enderror
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-keyword-mutes').close()">Close</button>
                <button type="submit" class="st-btn st-btn--primary">Add</button>
            </div>
        </form>
    </div>
</dialog>

{{-- カスタムNGワード管理モーダル --}}
<dialog id="modal-ng-words" class="st-modal" aria-labelledby="modal-ng-words-title">
    <div class="st-modal__inner">
        <h3 id="modal-ng-words-title" class="st-modal__title st-modal__title--normal">Custom Blocked Words</h3>
        <p class="st-modal__desc">In addition to system blocked words, you can register your own personal blocked words.</p>

        @if (count($comment->user_ng_words))
            <ul class="st-manage-list" role="list">
                @foreach ($comment->user_ng_words as $ngWord)
                    <li class="st-manage-list__item">
                        <p class="st-manage-list__label">{{ $ngWord['word'] }}</p>
                        <form action="{{ route('settings.comment.ng-words.destroy', $ngWord['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="st-btn st-btn--ghost st-btn--sm">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="st-modal__desc">No custom blocked words registered.</p>
        @endif

        <form action="{{ route('settings.comment.ng-words.store') }}" method="POST" class="st-field" style="margin-top:16px;">
            @csrf
            <label class="st-field__label" for="ng_word">Add Blocked Word</label>
            <input type="text" id="ng_word" name="word" class="st-input" maxlength="100" required>
            @error('word')
                <p class="st-form-error" role="alert">{{ $message }}</p>
            @enderror
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-ng-words').close()">Close</button>
                <button type="submit" class="st-btn st-btn--primary">Add</button>
            </div>
        </form>
    </div>
</dialog>
@endsection