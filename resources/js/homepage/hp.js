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

        console.log('Swiper初期化成功');
    }
});