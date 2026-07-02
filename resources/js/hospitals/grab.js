import { showLoader, hideLoader } from './loader';

const GRAB_LOADING_MS = 1800;

export function initGrabLoading() {
    document.querySelectorAll('.hs-grab-link').forEach((link) => {
        link.addEventListener('click', () => {
            const label = link.dataset.loaderText || 'Grabを開いています...';
            showLoader(label);

            window.setTimeout(hideLoader, GRAB_LOADING_MS);
        });
    });
}
