const LOADING_DURATION_MS = 1350;
const MESSAGE_INTERVAL_MS = 450;

function scrollToElement(element) {
    const scroller = document.querySelector('.content-body');

    if (!element || !scroller) {
        return;
    }

    const top = element.getBoundingClientRect().top
        - scroller.getBoundingClientRect().top
        + scroller.scrollTop
        - 16;

    scroller.scrollTo({ top: Math.max(top, 0), behavior: 'smooth' });
}

export function initWizardResult() {
    const section = document.getElementById('wizard-result');

    if (!section || section.dataset.animate !== 'true') {
        return;
    }

    const loading = section.querySelector('.hs-wizard-result__loading');
    const content = section.querySelector('.hs-wizard-result__content');
    const textEl = section.querySelector('.hs-wizard-result__loading-text');
    const progressBar = section.querySelector('.hs-wizard-result__progress-bar');

    let messages = [];

    try {
        messages = JSON.parse(section.dataset.loadingMessages || '[]');
    } catch {
        messages = [];
    }

    if (!loading || !content) {
        return;
    }

    let messageIndex = 0;

    if (textEl && messages.length > 0) {
        textEl.textContent = messages[0];
    }

    const messageTimer = window.setInterval(() => {
        if (!textEl || messages.length === 0) {
            return;
        }

        messageIndex = Math.min(messageIndex + 1, messages.length - 1);
        textEl.textContent = messages[messageIndex];
    }, MESSAGE_INTERVAL_MS);

    const startTime = performance.now();

    const animateProgress = (now) => {
        const elapsed = now - startTime;
        const progress = Math.min((elapsed / LOADING_DURATION_MS) * 100, 100);

        if (progressBar) {
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', String(Math.round(progress)));
        }

        if (elapsed < LOADING_DURATION_MS) {
            window.requestAnimationFrame(animateProgress);
        }
    };

    window.requestAnimationFrame(animateProgress);

    window.setTimeout(() => {
        window.clearInterval(messageTimer);

        loading.classList.add('is-hidden');
        content.hidden = false;
        content.classList.add('is-visible');

        scrollToElement(section);

        if (window.location.hash === '#wizard-result') {
            history.replaceState(null, '', `${window.location.pathname}${window.location.search}#wizard-result`);
        }
    }, LOADING_DURATION_MS);
}
