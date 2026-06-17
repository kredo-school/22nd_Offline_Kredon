@extends('settings.index')

@section('settings-content')

<div class="kk-st-account">

    {{-- ページタイトル --}}
    <div class="kk-st-section">
        <h3 class="kk-st-section__title">アカウント設定</h3>
        <p class="kk-st-section__sub">
            アカウント、プライバシーなど各種設定をカスタマイズできます。
        </p>
    </div>

    <div class="kk-st-account__layout">

        {{-- 左：設定フォーム群 --}}
        <div class="kk-st-account__forms">

            {{-- プロフィール編集 --}}
            <section class="kk-st-card">
                <h4 class="kk-st-card__title">
                    <i class="fa-regular fa-user"></i> プロフィール編集
                </h4>

                <form action="{{ route('settings.account.update') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- アバター --}}
                    <div class="kk-st-avatar-row">
                        <div class="kk-st-avatar">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="アバター">
                            @else
                                <span class="kk-st-avatar__placeholder">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </span>
                            @endif
                        </div>
                        <div class="kk-st-avatar-row__actions">
                            <label class="kk-st-btn kk-st-btn--ghost kk-st-btn--sm" for="avatar_input">
                                <i class="fa-solid fa-camera"></i> 画像を変更
                            </label>
                            <input type="file"
                                   id="avatar_input"
                                   name="avatar"
                                   accept="image/*"
                                   class="kk-st-avatar__file-input">
                        </div>
                    </div>

                    {{-- 名前 --}}
                    <div class="kk-st-field">
                        <label class="kk-st-field__label" for="name">ユーザー名</label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="kk-st-input @error('name') is-error @enderror"
                               value="{{ old('name', $user->name) }}"
                               maxlength="50">
                        @error('name')
                            <p class="kk-st-field__error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 自己紹介 --}}
                    <div class="kk-st-field">
                        <label class="kk-st-field__label" for="bio">自己紹介</label>
                        <textarea id="bio"
                                  name="bio"
                                  class="kk-st-input kk-st-input--textarea @error('bio') is-error @enderror"
                                  maxlength="200"
                                  rows="3">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="kk-st-field__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="kk-st-card__footer">
                        <button type="submit" class="kk-st-btn kk-st-btn--primary">
                            保存する
                        </button>
                    </div>
                </form>
            </section>

            {{--  メールアドレス --}}
            <section class="kk-st-card">
                <h4 class="kk-st-card__title">
                    <i class="fa-regular fa-envelope"></i> メールアドレス
                </h4>

                <form action="{{ route('settings.account.update') }}"
                      method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="kk-st-field">
                        <label class="kk-st-field__label" for="email">メールアドレス</label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="kk-st-input @error('email') is-error @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="kk-st-field__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="kk-st-card__footer">
                        <button type="submit" class="kk-st-btn kk-st-btn--primary">
                            変更する
                        </button>
                    </div>
                </form>
            </section>

            {{--  パスワード --}}
            <section class="kk-st-card">
                <h4 class="kk-st-card__title">
                    <i class="fa-solid fa-lock"></i> パスワード
                </h4>

                <form action="{{ route('settings.account.update') }}"
                      method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="kk-st-field">
                        <label class="kk-st-field__label" for="current_password">現在のパスワード</label>
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               class="kk-st-input">
                    </div>

                    <div class="kk-st-field">
                        <label class="kk-st-field__label" for="password">新しいパスワード</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="kk-st-input">
                    </div>

                    <div class="kk-st-field">
                        <label class="kk-st-field__label" for="password_confirmation">確認用パスワード</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="kk-st-input">
                    </div>

                    <div class="kk-st-card__footer">
                        <button type="submit" class="kk-st-btn kk-st-btn--primary">
                            変更する
                        </button>
                    </div>
                </form>
            </section>

            {{--  2段階認証 --}}
            <section class="kk-st-card">
                <h4 class="kk-st-card__title">
                    <i class="fa-solid fa-shield-halved"></i> 2段階認証（2FA）
                </h4>

                <div class="kk-st-row">
                    <div>
                        <p class="kk-st-row__label">2段階認証を有効にする</p>
                        <p class="kk-st-row__desc">ログイン時にSMSまたは認証アプリで確認します</p>
                    </div>
                    {{-- TODO: DB完成後に $user->two_factor_enabled を使用 --}}
                    <label class="kk-st-toggle" aria-label="2段階認証の切り替え">
                        <input type="checkbox" {{ false ? 'checked' : '' }}>
                        <span class="kk-st-toggle__slider"></span>
                    </label>
                </div>
            </section>

            {{--  プレミアムステータス --}}
            <section class="kk-st-card">
                <h4 class="kk-st-card__title">
                    <i class="fa-solid fa-crown"></i> プレミアムステータス
                </h4>

                <div class="kk-st-row">
                    <div>
                        <p class="kk-st-row__label">現在のプラン</p>
                        <p class="kk-st-row__desc">
                            {{-- TODO: $user->plan で切り替え --}}
                            @if($user->plan === 'premium')
                                <span class="kk-st-badge kk-st-badge--premium">
                                    <i class="fa-solid fa-crown"></i> KREDON Premium
                                </span>
                            @else
                                <span class="kk-st-badge kk-st-badge--free">無料プラン</span>
                            @endif
                        </p>
                    </div>
                    @if($user->plan !== 'premium')
                        <a href="#" class="kk-st-btn kk-st-btn--primary kk-st-btn--sm">
                            アップグレード
                        </a>
                    @endif
                </div>
            </section>

            {{--  ログアウト --}}
            <section class="kk-st-card">
                <h4 class="kk-st-card__title">
                    <i class="fa-solid fa-right-from-bracket"></i> ログアウト
                </h4>
                <p class="kk-st-card__desc">すべてのデバイスからログアウトします。</p>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="kk-st-btn kk-st-btn--ghost">
                        ログアウト
                    </button>
                </form>
            </section>

            {{-- ⑦ アカウント削除 --}}
            <section class="kk-st-card kk-st-card--danger">
                <h4 class="kk-st-card__title kk-st-card__title--danger">
                    <i class="fa-solid fa-triangle-exclamation"></i> アカウントの削除
                </h4>
                <p class="kk-st-card__desc">
                    削除すると、すべてのデータが完全に失われます。この操作は取り消せません。
                </p>
                <button type="button"
                        class="kk-st-btn kk-st-btn--danger"
                        onclick="document.getElementById('kk-delete-modal').showModal()">
                    アカウントを削除する
                </button>
            </section>

        </div>

        {{-- 右 --}}
        <aside class="kk-st-account__preview">
            <p class="kk-st-preview__label">ライブプレビュー</p>
            <p class="kk-st-preview__sub">あなたのプロフィールはこのように表示されます</p>

            <div class="kk-st-preview__card">
                {{-- アバター --}}
                <div class="kk-st-preview__avatar" id="preview-avatar">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>

                {{-- 名前 --}}
                <p class="kk-st-preview__name" id="preview-name">{{ $user->name }}</p>
                <p class="kk-st-preview__email" id="preview-email">{{ $user->email }}</p>

                {{-- 統計ダミー --}}
                <div class="kk-st-preview__stats">
                    <div class="kk-st-preview__stat">
                        <span class="kk-st-preview__stat-num">2,840</span>
                        <span class="kk-st-preview__stat-label">フォロワー</span>
                    </div>
                    <div class="kk-st-preview__stat">
                        <span class="kk-st-preview__stat-num">312</span>
                        <span class="kk-st-preview__stat-label">フォロー中</span>
                    </div>
                </div>

                {{-- 自己紹介 --}}
                <p class="kk-st-preview__bio" id="preview-bio">{{ $user->bio }}</p>
            </div>
        </aside>

    </div>

</div>


{{-- 削除確認モーダル --}}
<dialog id="kk-delete-modal" class="kk-st-modal">
    <div class="kk-st-modal__inner">
        <h3 class="kk-st-modal__title">
            <i class="fa-solid fa-triangle-exclamation"></i>
            本当に削除しますか？
        </h3>
        <p class="kk-st-modal__desc">
            この操作は取り消せません。アカウントに紐づくすべての投稿・データが削除されます。
        </p>
        <div class="kk-st-modal__footer">
            <button type="button"
                    class="kk-st-btn kk-st-btn--ghost"
                    onclick="document.getElementById('kk-delete-modal').close()">
                キャンセル
            </button>
            <form action="#" method="POST">
                {{-- TODO: route('settings.account.destroy') --}}
                @csrf
                @method('DELETE')
                <button type="submit" class="kk-st-btn kk-st-btn--danger">
                    削除する
                </button>
            </form>
        </div>
    </div>
</dialog>


{{-- ライブプレビュー用JS --}}
@push('scripts')
<script>
    // 名前入力 → プレビュー即時反映
    document.getElementById('name')?.addEventListener('input', function () {
        const name = this.value || 'ユーザー名';
        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-avatar').textContent = name.charAt(0);
    });

    // 自己紹介 → プレビュー即時反映
    document.getElementById('bio')?.addEventListener('input', function () {
        document.getElementById('preview-bio').textContent = this.value;
    });

    // アバター画像 → プレビュー即時反映
    document.getElementById('avatar_input')?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById('preview-avatar');
            el.innerHTML = `<img src="${e.target.result}" alt="プレビュー"
                                 style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush

@endsection