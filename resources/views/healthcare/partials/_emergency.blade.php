{{-- 1. 右下固定緊急ボタン --}}
<button type="button"
        class="hs-sos-btn"
        data-bs-toggle="modal"
        data-bs-target="#emergencyModal"
        aria-label="緊急SOSメニューを開く">
    <i class="fa-solid fa-phone-flip hs-sos-btn__icon"></i>
    <span class="hs-sos-btn__label">SOS</span>
</button>


{{-- 2. 緊急モーダル --}}
<div class="modal fade"
     id="emergencyModal"
     tabindex="-1"
     aria-labelledby="emergencyModalTitle"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered hs-emergency-dialog">
        <div class="modal-content hs-emergency-modal">

            {{-- ヘッダー --}}
            <div class="modal-header hs-emergency-modal__header">
                <h5 class="hs-emergency-modal__title" id="emergencyModalTitle">
                    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                    緊急連絡・SOSメニュー
                </h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="閉じる">
                </button>
            </div>

            {{-- ボディ --}}
            <div class="modal-body hs-emergency-modal__body">

                {{-- 最優先：救急車 --}}
                <a href="tel:911"
                   class="hs-emergency-modal__primary-btn">
                    <i class="fa-solid fa-truck-medical" aria-hidden="true"></i>
                    <span>911を発信（救急車）</span>
                </a>

                {{-- サポート窓口 --}}
                <div class="hs-emergency-modal__contacts">
                    <a href="tel:+63324799047"
                       class="hs-emergency-modal__contact-btn hs-emergency-modal__contact-btn--school">
                        <span>学校緊急ダイヤル</span>
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    </a>
                    <a href="tel:09175717436"
                       class="hs-emergency-modal__contact-btn hs-emergency-modal__contact-btn--jhd">
                        <span>セブドク（JHD）</span>
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    </a>
                    <a href="tel:09177912177"
                       class="hs-emergency-modal__contact-btn hs-emergency-modal__contact-btn--jhd">
                        <span>チョンワ（JHD）</span>
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    </a>
                </div>

                {{-- Grabで移動 --}}
                <a href="https://grab.onelink.me/2695614242/v7889v8a"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="hs-emergency-modal__grab-btn">
                    <i class="fa-solid fa-car" aria-hidden="true"></i>
                    Grabで病院へ向かう
                </a>

                {{-- 閉じる --}}
                <button type="button"
                        class="hs-emergency-modal__close-btn"
                        data-bs-dismiss="modal">
                    メニューを閉じる
                </button>

            </div>
        </div>
    </div>
</div>