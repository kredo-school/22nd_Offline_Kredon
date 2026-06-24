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

// 