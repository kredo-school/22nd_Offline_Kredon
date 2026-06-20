/** Homepage **/

// _hero

console.log('hp.js が読み込まれました！');

// [ _hero.blade.php ] の制御  Swiperの初期化
try {
    const swiperElement = document.querySelector('.mySwiper');
    if (swiperElement) {
        new Swiper('.mySwiper', {
            modules: [Pagination, Autoplay],
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '._swiper-pagination',
                clickable: true,
            },
        });
        console.log('Swiper [_hero.blade.php] 初期化完了');
    }
} catch (error) {
    console.warn('Swiper [_hero.blade.php] の初期化に失敗しましたが続行します:', error);
}

// [ _action.blade.php ] の制御  プルダウンメニューの開閉処理

document.addEventListener('DOMContentLoaded', () => {
    console.log('アクションメニュー [_action.blade.php] の処理開始');
    const dropdowns = document.querySelectorAll('.hp-dropdown');

    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('.hp-menu-btn');
        if (button) {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                
                // 他のメニューを閉じる
                closeAllDropdowns();

                // 現在のメニューの開閉状態を切り替え
                button.setAttribute('aria-expanded', !isExpanded);
            });
        }
    });

    // 画面外クリックやEscキーでのメニュー閉鎖処理
    document.addEventListener('click', closeAllDropdowns);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeAllDropdowns();
    });

    // 共通関数：全てのメニューを閉じる
    function closeAllDropdowns() {
        document.querySelectorAll('.hp-menu-btn').forEach(btn => {
            btn.setAttribute('aria-expanded', 'false');
        });
    }
});