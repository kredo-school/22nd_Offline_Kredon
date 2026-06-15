import './bootstrap';

import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';

// CSSのインポート
import 'swiper/css';
import 'swiper/css/pagination';

/** Homepage **/
/** _hero **/

// Swiperの初期化
new Swiper('.mySwiper', {
  modules:[Pagination,Autoplay],
  loop: true, // 無限ループ
  autoplay: {
    delay: 3000, // 3秒ごとに切り替え
    disableOnInteraction: false, // 触っても自動再生を止めない
  },
  pagination: {
    el:'._swiper-pagination', // HTMLのクラスと一致させる
    clickable: true,
  },
});
