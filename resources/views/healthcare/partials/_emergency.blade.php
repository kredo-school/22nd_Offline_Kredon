{{-- 1. 右下に常駐する固定緊急ボタン --}}
<button type="button" 
        class="btn btn-danger rounded-circle d-flex flex-column align-items-center justify-content-center shadow-lg" 
        data-bs-toggle="modal" 
        data-bs-target="#emergencyModal"
        style="width: 50px; height: 50px; 
               position: fixed; 
               bottom: 20px; right: 20px; z-index: 1050; 
               background-color: rgba(220, 53, 69, 0.85);
               border: 3px solid #fff;
               transition: all 0.2s ease-in-out;">

    {{-- アイコンとテキストの配置を微調整 --}}
    <i class="fa-solid fa-phone-flip fs-4"></i>
    <span class="fw-bold" 
          style="font-size: 8px;">SOS</span>
</button>

{{-- 2. 緊急メニュー（モーダル本体） --}}
<div class="modal fade" 
     id="emergencyModal" 
     tabindex="-1" 
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" 
         style="max-width: 400px;">

        <div class="modal-content border-0 shadow-lg" 
             style="border-radius: 20px;">
            
            <div class="modal-header bg-danger text-white border-0 py-3">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>緊急連絡・SOSメニュー
                </h5>
                <button type="button" 
                        class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body p-4 bg-light">

                {{-- 最優先：救急車 --}}
                <div class="mb-4">
                    <a href="tel:161" 
                       class="btn btn-danger w-100 py-4 shadow-sm d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-truck-medical fs-2 me-3"></i>
                        <span class="fs-4 fw-bold">911を発信 (救急車)</span>
                    </a>
                </div>

                {{-- サポート窓口 --}}
                <div class="d-flex flex-column gap-2">
                    <a href="tel:+63324799047" 
                       class="btn btn-outline-primary py-2 d-flex justify-content-between align-items-center">
                        <span>学校緊急ダイヤル</span>
                        <i class="fa-solid fa-phone"></i>
                    </a>
                    <a href="tel:09175717436" 
                       class="btn btn-outline-info py-2 d-flex justify-content-between align-items-center">
                        <span>セブドク(JHD)</span>
                        <i class="fa-solid fa-phone"></i>
                    </a>

                    <a href="tel:09177912177" 
                       class="btn btn-outline-info py-2 d-flex justify-content-between align-items-center">
                        <span>チョンワ(JHD)</span>
                        <i class="fa-solid fa-phone"></i>
                    </a>
                </div>

                {{-- Grab移動 --}}
                <div class="mt-4">
                    <a href="https://grab.onelink.me/2695614242/v7889v8a"   target="_blank" 
                    class="btn btn-success w-100 py-2">
                        <i class="fa-solid fa-car me-2"></i>Grabで病院へ向かう
                    </a>
                
                {{-- メニューを閉じる --}}
                <button type="button" class="btn btn-outline-secondary w-100 py-2 mt-2" data-bs-dismiss="modal">
                メニューを閉じる
                </button>
                </div>
            </div>
        </div>
    </div>
</div>