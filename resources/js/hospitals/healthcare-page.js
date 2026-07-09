export function initHealthcarePage() {
    if (!document.querySelector('.hs-page')) {
        return;
    }

    const scroller = document.querySelector('.content-body');
    const emergencyModal = document.getElementById('emergencyModal');

    const scrollOffset = () => {
        const navbar = document.querySelector('.navbar-top');
        return (navbar?.offsetHeight ?? 70) + 16;
    };

    const scrollToHash = (hash) => {
        if (!hash) {
            return;
        }

        const target = document.querySelector(hash);

        if (!target) {
            return;
        }

        const offset = scrollOffset();
        const desktopScroller = window.matchMedia('(min-width: 768px)').matches && scroller;

        if (desktopScroller && getComputedStyle(scroller).overflowY !== 'visible') {
            const top = target.getBoundingClientRect().top
                - scroller.getBoundingClientRect().top
                + scroller.scrollTop
                - 16;

            scroller.scrollTo({ top: Math.max(top, 0), behavior: 'smooth' });
            return;
        }

        const top = window.scrollY + target.getBoundingClientRect().top - offset;
        window.scrollTo({ top: Math.max(top, 0), behavior: 'smooth' });
    };

    const showCollapse = (element) => {
        if (!element || element.classList.contains('show')) {
            return Promise.resolve();
        }

        const instance = bootstrap.Collapse.getOrCreateInstance(element, { toggle: false });

        return new Promise((resolve) => {
            element.addEventListener('shown.bs.collapse', resolve, { once: true });
            instance.show();
        });
    };

    const openEmergencyPhrasesAndScroll = () => {
        const anchor = document.getElementById('hs-emergency-phrases');

        if (!anchor) {
            return;
        }

        const categoryEl = document.querySelector(anchor.dataset.hsCategoryCollapse || '');
        const faqEl = document.querySelector(anchor.dataset.hsFaqCollapse || '');

        showCollapse(categoryEl)
            .then(() => showCollapse(faqEl))
            .then(() => {
                scrollToHash('#hs-emergency-phrases');
                history.replaceState(null, '', '#hs-faq-section');
            });
    };

    document.querySelector('.hs-emergency-modal__phrases-link')?.addEventListener('click', (event) => {
        event.preventDefault();

        if (!emergencyModal) {
            openEmergencyPhrasesAndScroll();
            return;
        }

        const modalInstance = bootstrap.Modal.getInstance(emergencyModal)
            || bootstrap.Modal.getOrCreateInstance(emergencyModal);

        emergencyModal.addEventListener('hidden.bs.modal', openEmergencyPhrasesAndScroll, { once: true });
        modalInstance.hide();
    });

    if (window.location.hash) {
        if (window.location.hash === '#hs-emergency-phrases') {
            openEmergencyPhrasesAndScroll();
        } else if (window.location.hash !== '#wizard-result') {
            scrollToHash(window.location.hash);
        }
    }

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href^="#"]');

        if (!link) {
            return;
        }

        if (link.classList.contains('hs-emergency-modal__phrases-link')) {
            return;
        }

        const hash = link.getAttribute('href');

        if (!hash || hash === '#' || !document.querySelector(hash)) {
            return;
        }

        if (link.hasAttribute('data-bs-toggle')) {
            return;
        }

        event.preventDefault();
        scrollToHash(hash);
        history.replaceState(null, '', hash);
    });
}
