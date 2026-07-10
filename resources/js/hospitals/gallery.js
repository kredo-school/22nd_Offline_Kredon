export function initHospitalGallery() {
    document.querySelectorAll('.hs-gallery.carousel').forEach((carouselEl) => {
        carouselEl.addEventListener('slid.bs.carousel', (event) => {
            const counter = carouselEl.querySelector('.hs-gallery__counter-current');

            if (counter) {
                counter.textContent = event.to + 1;
            }
        });
    });
}
