/** Homepage **/
document.addEventListener('DOMContentLoaded', () => {
    
    // スライダーの要素を探す
    const swiperElement = document.querySelector('.hp-hero-swiper');
    
    if (swiperElement) {
        try {
            // app.jsで既に読み込まれている Swiper クラスを使う
            new Swiper('.hp-hero-swiper', {
                modules: [Pagination, Autoplay, Navigation], 
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
            console.log('Swiper [hp-hero-swiper] 初期化成功');
        } catch (error) {
            console.error('Swiper 初期化失敗:', error);
        }
    }

    // 2. _action.blade.php 
    console.log('_action.blade.php 用の処理準備完了');
});