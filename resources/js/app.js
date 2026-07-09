import './bootstrap';

import './hospitals/hospital';
import { initGrabLoading } from './hospitals/grab';
import { initWizardResult } from './hospitals/wizard-result';
import AOS from 'aos';
import 'aos/dist/aos.css';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import './homepage/hp';
import './usersettings/settings';

window.AOS = AOS;

document.addEventListener('DOMContentLoaded', () => {
    initGrabLoading();
    initWizardResult();
    AOS.init({
        duration: 800,
        once: true,
        offset: 80,
    });
});
