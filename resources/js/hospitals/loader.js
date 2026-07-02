const LOADER_ID = 'hs-loader';
const LOADER_TEXT_ID = 'hs-loader-text';

export function showLoader(message = '読み込み中...') {
    const loader = document.getElementById(LOADER_ID);
    const text = document.getElementById(LOADER_TEXT_ID);
    if (!loader) return;

    if (text) text.textContent = message;
    loader.classList.add('is-active');
    loader.setAttribute('aria-hidden', 'false');
}

export function hideLoader() {
    const loader = document.getElementById(LOADER_ID);
    if (!loader) return;

    loader.classList.remove('is-active');
    loader.setAttribute('aria-hidden', 'true');
}
