@extends('settings.index')

@section('settings-content')

<div class="st-page">

    {{-- メイン: アカウント設定リスト --}}
    <div class="st-page__main">

        <section class="st-card st-card--account" aria-labelledby="account-heading">

            <div class="st-card__head">
                <h2 id="account-heading" class="st-card__heading">Account Settings</h2>
                <p class="st-card__lead">
                    Manage your profile, security, membership, and other account details.
                </p>
            </div>

            {{-- 各行 = 1つの設定項目。label/value + action のパターンで統一 --}}
            <ul class="st-setting-list" role="list">

                {{-- プロフィール編集 --}}
                <li class="st-setting-item st-setting-item--profile">
                    <div class="st-setting-item__profile">
                        {{-- アバター: 画像がなければ名前の頭文字を表示 --}}
                        <div class="st-avatar st-avatar--lg">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}'s avatar">
                            @else
                                <span class="st-avatar__placeholder" id="row-avatar-char">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </span>
                            @endif
                            <span class="st-avatar__camera" aria-hidden="true">
                                <i class="fa-solid fa-camera"></i>
                            </span>
                        </div>
                        <div>
                            <p class="st-setting-item__label">Edit Profile</p>
                            <p class="st-setting-item__desc">Change your profile and cover photos.</p>
                        </div>
                    </div>
                    {{-- dialog要素: JSライブラリ不要・ネイティブでモーダル表示 --}}
                    <button type="button"
                            class="st-btn st-btn--ghost st-btn--sm"
                            onclick="document.getElementById('modal-profile').showModal()">
                        Edit
                    </button>
                </li>

                {{-- ユーザー名 --}}
                <li class="st-setting-item">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label">Username</p>
                        <p class="st-setting-item__value" id="display-name">
                            {{ $user->name }}
                            <span class="st-setting-item__handle">{{ '@' . $user->username }}</span>
                        </p>
                    </div>
                    <button type="button"
                            class="st-btn st-btn--ghost st-btn--sm"
                            onclick="document.getElementById('modal-username').showModal()">
                        Change
                    </button>
                </li>

                {{-- 自己紹介 --}}
                <li class="st-setting-item">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label">Bio</p>
                        <p class="st-setting-item__value st-setting-item__value--bio" id="display-bio">{{ $user->bio }}</p>
                    </div>
                    <button type="button"
                            class="st-btn st-btn--ghost st-btn--sm"
                            onclick="document.getElementById('modal-bio').showModal()">
                        Change
                    </button>
                </li>

                {{-- メールアドレス --}}
                <li class="st-setting-item">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label">Email Address</p>
                        <p class="st-setting-item__value" id="display-email">{{ $user->email }}</p>
                    </div>
                    <button type="button"
                            class="st-btn st-btn--ghost st-btn--sm"
                            onclick="document.getElementById('modal-email').showModal()">
                        Change
                    </button>
                </li>

                {{-- ── パスワード ── --}}
                <li class="st-setting-item">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label">Password</p>
                        {{-- 実際の値は表示せずマスク。セキュリティのベストプラクティス --}}
                        <p class="st-setting-item__value st-setting-item__value--masked" aria-label="Password is set">••••••••••••</p>
                    </div>
                    <button type="button"
                            class="st-btn st-btn--ghost st-btn--sm"
                            onclick="document.getElementById('modal-password').showModal()">
                        Change
                    </button>
                </li>

                {{-- 2段階認証  --}}
                <li class="st-setting-item">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label">Two-Factor Authentication (2FA)</p>
                        <p class="st-setting-item__desc">Strengthen your account security.</p>
                    </div>

                    @if($user->two_factor_enabled)
                        {{-- ON状態: 押すと無効化される --}}
                        <form action="{{ route('settings.two-factor.disable') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="st-toggle st-toggle--button" aria-label="Disable two-factor authentication">
                                <span class="st-toggle__slider st-toggle__slider--on"></span>
                            </button>
                        </form>
                    @else
                        {{-- OFF状態: 押すとQRコード設定画面へ --}}
                        <a href="{{ route('settings.two-factor.setup') }}" class="st-toggle st-toggle--button" aria-label="Set up two-factor authentication">
                            <span class="st-toggle__slider"></span>
                        </a>
                    @endif
                </li>

                {{-- プレミアムステータス  --}}
                <li class="st-setting-item">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label">Premium Status</p>
                        <div class="st-setting-item__premium">
                            @if ($user->plan === 'premium')
                                <span class="st-badge st-badge--premium">
                                    <i class="fa-solid fa-crown" aria-hidden="true"></i> KREDON Premium
                                </span>
                                <span class="st-badge st-badge--active">Active</span>
                            @else
                                <span class="st-badge st-badge--free">Free Plan</span>
                            @endif
                        </div>
                    </div>
                    @if ($user->plan === 'premium')
                        <a href="#" class="st-btn st-btn--ghost st-btn--sm">View Details</a>
                    @else
                        <a href="#" class="st-btn st-btn--primary st-btn--sm">Upgrade</a>
                    @endif
                </li>

                {{--  ログアウト  --}}
                <li class="st-setting-item">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label">Log Out</p>
                        <p class="st-setting-item__desc">Sign out from all devices.</p>
                    </div>
                    {{-- POST + @csrf: Laravelのログアウトは必ずPOST --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="st-btn st-btn--outline-danger st-btn--sm">
                            Log Out
                        </button>
                    </form>
                </li>

                {{-- アカウント削除 --}}
                <li class="st-setting-item st-setting-item--danger">
                    <div class="st-setting-item__body">
                        <p class="st-setting-item__label st-setting-item__label--danger">Delete Account</p>
                        <p class="st-setting-item__desc st-setting-item__desc--danger">
                            Permanently delete your account and data. This action cannot be undone.
                        </p>
                    </div>
                    <button type="button"
                            class="st-btn st-btn--outline-danger st-btn--sm"
                            onclick="document.getElementById('delete-modal').showModal()">
                        Delete Account
                    </button>
                </li>

            </ul>
        </section>

    </div>


    {{--  右サイドバー: プレビュー & ステータス768px未満では設定リストの下に表示 --}}
    <aside class="st-page__aside" aria-label="Account preview">

        {{--  ライブプレビュー  --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-eye" aria-hidden="true"></i> Live Preview
            </h3>
            <p class="st-widget__sub">This is how your profile will appear</p>

            {{-- テーマ名 + 変更リンク --}}
            <div class="st-preview__theme-row">
                <span class="st-preview__theme">
                    <i class="fa-solid fa-palette" aria-hidden="true"></i> {{ $user->theme }}
                </span>
                <a href="{{ route('settings.display') }}" class="st-btn st-btn--ghost st-btn--xs">Change</a>
            </div>

            {{-- ミニプロフィールカード --}}
            <div class="st-preview__card">
                <div class="st-preview__avatar" id="preview-avatar">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                    @else
                        {{ mb_substr($user->name, 0, 1) }}
                    @endif
                </div>
                @if ($user->plan === 'premium')
                    <span class="st-preview__premium-tag">PREMIUM</span>
                @endif
                <p class="st-preview__name" id="preview-name">{{ $user->name }}</p>
                <p class="st-preview__handle" id="preview-handle">{{ '@' . $user->username }}</p>

                {{-- 投稿数のみ表示（フォロー機能は未実装のため Followers/Following は除外） --}}
                <div class="st-preview__stats">
                    <div class="st-preview__stat">
                        <span class="st-preview__stat-num">{{ number_format($user->posts_count) }}</span>
                        <span class="st-preview__stat-label">Posts</span>
                    </div>
                </div>

                <p class="st-preview__bio" id="preview-bio">{{ $user->bio }}</p>
            </div>
        </div>

        {{--  アカウントステータス  --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-solid fa-circle-info" aria-hidden="true"></i> Account Status
            </h3>
            {{-- dl/dt/dd: キー・バリューのペアを意味的に正しくマークアップ。cssで左側と右側を分けて表示する --}}
            {{-- 目的: これらの構造はGoogleなどに情報を正しく伝えるために使用する --}}
            <dl class="st-status-list">
                <div class="st-status-list__row">
                    <dt>Status</dt>
                    <dd><span class="st-badge st-badge--active">Active</span></dd>
                </div>
                <div class="st-status-list__row">
                    <dt>Membership Plan</dt>
                    <dd>{{ $user->plan === 'premium' ? 'KREDON Premium' : 'Free Plan' }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>Registration Date</dt>
                    <dd>{{ date('F j, Y', strtotime($user->created_at)) }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>Last Login</dt>
                    <dd>{{ $user->last_login }}</dd>
                </div>
                <div class="st-status-list__row">
                    <dt>Account Security</dt>
                    <dd><span class="st-badge st-badge--active">{{ $user->security_label }}</span></dd>
                </div>
            </dl>
        </div>

        {{-- ── 通知プレビュー ── --}}
        <div class="st-widget">
            <h3 class="st-widget__title">
                <i class="fa-regular fa-bell" aria-hidden="true"></i> Notification Preview
            </h3>
            <ul class="st-notif-list" role="list">
                @forelse ($user->notifications as $notif)
                    <li class="st-notif-list__item">
                        <span class="st-notif-list__icon st-notif-list__icon--{{ $notif['color'] }}" aria-hidden="true">
                            <i class="{{ $notif['icon'] }}"></i>
                        </span>
                        <div class="st-notif-list__body">
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
            <a href="{{ route('settings.notification') }}" class="st-notif-list__more">
                View all notifications
            </a>
        </div>

    </aside>

</div>


{{-- 編集モーダル群
     <dialog> を使用: アクセシビリティ対応・JSライブラリ不要
     各フォームは @method('PATCH') で RESTful に更新ルートへ送信 --}}

<dialog id="modal-profile" class="st-modal" aria-labelledby="modal-profile-title">
    <div class="st-modal__inner">
        <h3 id="modal-profile-title" class="st-modal__title st-modal__title--normal">
            <i class="fa-regular fa-user" aria-hidden="true"></i> Edit Profile
        </h3>
        <form action="{{ route('settings.account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="st-avatar-row">
                <div class="st-avatar st-avatar--lg">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar">
                    @else
                        <span class="st-avatar__placeholder">{{ mb_substr($user->name, 0, 1) }}</span>
                    @endif
                </div>
                <label class="st-btn st-btn--ghost st-btn--sm" for="avatar_input">
                    <i class="fa-solid fa-camera" aria-hidden="true"></i> Change Photo
                </label>
                <input type="file" id="avatar_input" name="avatar" accept="image/*" class="st-avatar__file-input">
            </div>
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-profile').close()">Cancel</button>
                <button type="submit" class="st-btn st-btn--primary">Save</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="modal-username" class="st-modal" aria-labelledby="modal-username-title">
    <div class="st-modal__inner">
        <h3 id="modal-username-title" class="st-modal__title st-modal__title--normal">Change Username</h3>
        <form action="{{ route('settings.account.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="st-field">
                <label class="st-field__label" for="name">Display Name</label>
                <input type="text" id="name" name="name" class="st-input"
                       value="{{ old('name', $user->name) }}" maxlength="50" required>
            </div>
            <div class="st-field">
                <label class="st-field__label" for="username">User ID</label>
                <div class="st-input-prefix">
                    <span aria-hidden="true">@</span>
                    <input type="text" id="username" name="username" class="st-input"
                           value="{{ old('username', $user->username) }}" maxlength="30" required>
                </div>
            </div>
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-username').close()">Cancel</button>
                <button type="submit" class="st-btn st-btn--primary">Save Changes</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="modal-bio" class="st-modal" aria-labelledby="modal-bio-title">
    <div class="st-modal__inner">
        <h3 id="modal-bio-title" class="st-modal__title st-modal__title--normal">Change Bio</h3>
        <form action="{{ route('settings.account.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="st-field">
                <label class="st-field__label" for="bio">Bio</label>
                <textarea id="bio" name="bio" class="st-input st-input--textarea"
                          maxlength="200" rows="4">{{ old('bio', $user->bio) }}</textarea>
            </div>
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-bio').close()">Cancel</button>
                <button type="submit" class="st-btn st-btn--primary">Save Changes</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="modal-email" class="st-modal" aria-labelledby="modal-email-title">
    <div class="st-modal__inner">
        <h3 id="modal-email-title" class="st-modal__title st-modal__title--normal">Change Email Address</h3>
        <form action="{{ route('settings.account.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="st-field">
                <label class="st-field__label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="st-input"
                       value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-email').close()">Cancel</button>
                <button type="submit" class="st-btn st-btn--primary">Save Changes</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="modal-password" class="st-modal" aria-labelledby="modal-password-title">
    <div class="st-modal__inner">
        <h3 id="modal-password-title" class="st-modal__title st-modal__title--normal">Change Password</h3>
        <form action="{{ route('settings.account.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="st-field">
                <label class="st-field__label" for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="st-input" autocomplete="current-password">
            </div>
            <div class="st-field">
                <label class="st-field__label" for="password">New Password</label>
                <input type="password" id="password" name="password" class="st-input" autocomplete="new-password">
            </div>
            <div class="st-field">
                <label class="st-field__label" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="st-input" autocomplete="new-password">
            </div>
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('modal-password').close()">Cancel</button>
                <button type="submit" class="st-btn st-btn--primary">Save Changes</button>
            </div>
        </form>
    </div>
</dialog>

<dialog id="delete-modal" class="st-modal" aria-labelledby="delete-modal-title">
    <div class="st-modal__inner">
        <h3 id="delete-modal-title" class="st-modal__title">
            <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
            Are you sure you want to delete?
        </h3>
        <p class="st-modal__desc">
            This action cannot be undone. All posts and data linked to your account will be permanently deleted.
            Please enter your current password to confirm.
        </p>
        <form action="{{ route('settings.account.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="st-field">
                <label class="st-field__label" for="delete_password">Password</label>
                <input type="password" id="delete_password" name="password" class="st-input" autocomplete="current-password" required>
                @error('password')
                    <p class="st-form-error" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="st-modal__footer">
                <button type="button" class="st-btn st-btn--ghost"
                        onclick="document.getElementById('delete-modal').close()">Cancel</button>
                <button type="submit" class="st-btn st-btn--danger">Delete</button>
            </div>
        </form>
    </div>
</dialog>
@endsection