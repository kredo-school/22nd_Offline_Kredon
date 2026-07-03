// _account.blade.php

// ライブプレビュー同期JS
document.addEventListener('DOMContentLoaded', () => {

    const previewName   = document.getElementById('preview-name');
    const previewHandle = document.getElementById('preview-handle');
    const previewBio    = document.getElementById('preview-bio');
    const previewAvatar = document.getElementById('preview-avatar');
    const displayName   = document.getElementById('display-name');
    const displayBio    = document.getElementById('display-bio');
    const rowAvatarChar = document.getElementById('row-avatar-char');

    const nameInput     = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const bioInput      = document.getElementById('bio');
    const avatarInput   = document.getElementById('avatar_input');

    if (!nameInput || !usernameInput) {
        return;
    }

    const defaultName     = nameInput.value;
    const defaultUsername = usernameInput.value;

    function syncUsername() {

        const name =
            nameInput.value || defaultName;

        const handle =
            usernameInput.value || defaultUsername;

        if (previewName) {
            previewName.textContent = name;
        }

        if (previewHandle) {
            previewHandle.textContent = '@' + handle;
        }

        if (
            previewAvatar &&
            !previewAvatar.querySelector('img')
        ) {
            previewAvatar.textContent =
                name.charAt(0);
        }

        if (rowAvatarChar) {
            rowAvatarChar.textContent =
                name.charAt(0);
        }

        if (displayName) {
            displayName.innerHTML =
                `${name}
                <span class="st-setting-item__handle">
                    @${handle}
                </span>`;
        }
    }

    nameInput.addEventListener('input', syncUsername);
    usernameInput.addEventListener('input', syncUsername);

    bioInput?.addEventListener('input', function () {

        if (previewBio) {
            previewBio.textContent = this.value;
        }

        if (displayBio) {
            displayBio.textContent = this.value;
        }

    });

    avatarInput?.addEventListener('change', function () {

        const file = this.files[0];

        if (!file || !previewAvatar) {
            return;
        }

        const reader = new FileReader();

        reader.onload = (e) => {

            previewAvatar.innerHTML =
                `<img src="${e.target.result}"
                      alt="preview"
                      style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        };

        reader.readAsDataURL(file);
    });

});

// _comment.blade.php

//セグメントコントロールの見た目同期。ラジオボタンで切り替える
document.addEventListener('DOMContentLoaded', () => {

    document
        .querySelectorAll('.st-segment')
        .forEach((group) => {

            const radios =
                group.querySelectorAll('input[type="radio"]');

            radios.forEach((radio) => {

                radio.addEventListener('change', () => {

                    group
                        .querySelectorAll('.st-segment__btn')
                        .forEach((btn) => {
                            btn.classList.remove('is-active');
                        });

                    const label =
                        radio.closest('.st-segment__btn');

                    if (label) {
                        label.classList.add('is-active');
                    }

                });

            });

        });

});

// _display.blade.php — 外観モード・キャラクターのライブプレビュー同期
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('display-settings-form');
    if (!form) {
        return;
    }

    const previewRoot      = document.getElementById('display-preview-root');
    const statusMode       = document.getElementById('display-status-mode');
    const statusCharacter  = document.getElementById('display-status-character');
    const charLogin        = document.getElementById('display-preview-char-login');
    const charRegister     = document.getElementById('display-preview-char-register');
    const previewReset     = document.getElementById('display-preview-reset');

    const colorModeOptions = form.querySelectorAll('.st-color-mode__option');
    const characterItems   = form.querySelectorAll('.st-char-picker__item');

    const authTabs   = document.querySelectorAll('[data-auth-tab]');
    const authPanels = document.querySelectorAll('[data-auth-panel]');

    function buildCharVisual(label) {
        const name    = label.dataset.charName ?? '';
        const initial = label.dataset.charInitial ?? name.charAt(0);
        const bg      = label.dataset.charBg ?? '#2A87C8';
        const pickerImg = label.querySelector('.st-char-picker__img');

        if (pickerImg) {
            return `<img src="${pickerImg.src}" alt="${name}" class="st-display-char__img">`;
        }

        return `<span class="st-display-char__fallback" style="background:${bg}">${initial}</span>`;
    }

    function syncCharacterPreview() {
        const selected = form.querySelector('input[name="character_id"]:checked');
        if (!selected) {
            return;
        }

        const label = selected.closest('.st-char-picker__item');
        if (!label) {
            return;
        }

        const html = buildCharVisual(label);

        if (charLogin) {
            charLogin.innerHTML = html;
        }

        if (charRegister) {
            charRegister.innerHTML = html;
        }

        if (statusCharacter) {
            statusCharacter.textContent = label.dataset.charName ?? '';
        }

        characterItems.forEach((item) => {
            item.classList.toggle('is-selected', item === label);
        });
    }

    function resolvePreviewMode(mode) {
        if (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }

        return mode;
    }

    function syncColorModePreview() {
        const selected = form.querySelector('input[name="color_mode"]:checked');
        if (!selected || !previewRoot) {
            return;
        }

        const mode = selected.value;
        const visualMode = resolvePreviewMode(mode);

        previewRoot.classList.remove('st-display-preview--light', 'st-display-preview--dark', 'st-display-preview--system');
        previewRoot.classList.add(`st-display-preview--${visualMode}`);
        previewRoot.dataset.colorMode = mode;

        if (statusMode) {
            statusMode.textContent = selected.dataset.previewLabel ?? mode;
        }

        colorModeOptions.forEach((option) => {
            const input = option.querySelector('input[name="color_mode"]');
            option.classList.toggle('is-active', input === selected);
        });
    }

    form.querySelectorAll('input[name="color_mode"]').forEach((input) => {
        input.addEventListener('change', syncColorModePreview);
    });

    form.querySelectorAll('input[name="character_id"]').forEach((input) => {
        input.addEventListener('change', syncCharacterPreview);
    });

    authTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.authTab;

            authTabs.forEach((t) => {
                const active = t === tab;
                t.classList.toggle('is-active', active);
                t.setAttribute('aria-selected', active ? 'true' : 'false');
            });

            authPanels.forEach((panel) => {
                panel.classList.toggle('is-hidden', panel.dataset.authPanel !== target);
            });
        });
    });

    previewReset?.addEventListener('click', () => {
        syncColorModePreview();
        syncCharacterPreview();
    });

    syncColorModePreview();
    syncCharacterPreview();

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (previewRoot?.dataset.colorMode === 'system') {
            syncColorModePreview();
        }
    });
});

// _app.blade.php — アプリ設定のライブプレビュー同期
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('app-settings-form');
    if (!form) {
        return;
    }

    const previewRoot   = document.getElementById('app-preview-root');
    const previewSpots  = document.getElementById('app-preview-spots');
    const statusSaver   = document.getElementById('app-status-data-saver');
    const statusTranslate = document.getElementById('app-status-translate');
    const clearCacheBtn = document.getElementById('app-clear-cache');

    const translateLangSelect = form.querySelector('[data-app-preview="translate-lang"]');
    const langLabels = translateLangSelect
        ? Object.fromEntries([...translateLangSelect.options].map((o) => [o.value, o.textContent.trim()]))
        : {};

    function syncAiSpots() {
        const enabled = form.querySelector('[data-app-preview="ai-spots"]')?.checked ?? true;

        if (previewSpots) {
            previewSpots.classList.toggle('is-hidden', !enabled);
        }
    }

    function syncDataSaver() {
        const enabled = form.querySelector('[data-app-preview="data-saver"]')?.checked ?? false;

        if (previewRoot) {
            previewRoot.classList.toggle('st-app-preview--data-saver', enabled);
        }

        if (statusSaver) {
            statusSaver.textContent = enabled ? 'オン' : 'オフ';
        }
    }

    function syncTranslate() {
        const enabled = form.querySelector('[data-app-preview="translate"]')?.checked ?? true;
        const lang    = translateLangSelect?.value ?? 'ja';
        const label   = langLabels[lang] ?? lang;

        if (statusTranslate) {
            statusTranslate.textContent = enabled ? `オン (${label.replace(/\s*\(.*\)\s*/, '')})` : 'オフ';
        }
    }

    form.querySelector('[data-app-preview="ai-spots"]')
        ?.addEventListener('change', syncAiSpots);

    form.querySelector('[data-app-preview="data-saver"]')
        ?.addEventListener('change', syncDataSaver);

    form.querySelector('[data-app-preview="translate"]')
        ?.addEventListener('change', syncTranslate);

    translateLangSelect?.addEventListener('change', syncTranslate);

    clearCacheBtn?.addEventListener('click', () => {
        if ('caches' in window) {
            caches.keys().then((keys) => Promise.all(keys.map((key) => caches.delete(key))));
        }
    });

    syncAiSpots();
    syncDataSaver();
    syncTranslate();
});
