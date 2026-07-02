/** Homepage **/
import Swiper from 'swiper';
import { Pagination, Navigation, Autoplay } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', () => {

    const swiperElement = document.querySelector('.hp-hero-swiper');

    if (swiperElement) {

        new Swiper('.hp-hero-swiper', {

            modules: [
                Pagination,
                Navigation,
                Autoplay
            ],

            loop: true,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },

            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        });

    }

    initFeedViewToggle();
});

function initFeedViewToggle() {
    const grid = document.getElementById('hp-feed-grid');
    const buttons = document.querySelectorAll('[data-hp-view]');

    if (!grid || buttons.length === 0) {
        return;
    }

    const storageKey = 'hp-feed-view';

    const applyView = (view) => {
        const isList = view === 'list';

        grid.classList.toggle('hp-grid--list', isList);

        buttons.forEach((btn) => {
            const active = btn.dataset.hpView === view;
            btn.classList.toggle('active', active);
            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        try {
            localStorage.setItem(storageKey, view);
        } catch (e) {
            // localStorage unavailable
        }
    };

    let savedView = 'grid';

    try {
        savedView = localStorage.getItem(storageKey) === 'list' ? 'list' : 'grid';
    } catch (e) {
        // localStorage unavailable
    }

    applyView(savedView);

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            applyView(btn.dataset.hpView);
        });
    });
}