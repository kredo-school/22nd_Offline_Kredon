import './bootstrap';
import './hospitals/hospital';
import { initGrabLoading } from './hospitals/grab';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.AOS = AOS;

document.addEventListener('DOMContentLoaded', () => {
    initGrabLoading();
    AOS.init({
        duration: 800,
        once: true,
        offset: 80,
    });
});
