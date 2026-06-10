{{-- 1. 右下に常駐する固定緊急ボタン --}}

<button type="button" 

        class="btn btn-danger rounded-circle d-flex flex-column align-items-center justify-content-center shadow-lg" 

        data-bs-toggle="modal" 

        data-bs-target="#emergencyModal"

        style="width: 75px !important; height: 75px !important; position: fixed !important; bottom: 25px !important; right: 25px !important; z-index: 9999 !important; border: 2px solid #fff !important; animation: pulse 2s infinite;">

    <i class="fa-solid fa-phone-flip fs-5 mb-1" style="color: #fff !important;"></i>

    <span class="fw-bold" style="font-size: 9px !important; line-height: 1 !important; color: #fff !important;">EMERGENCY</span>

</button>

{{-- 2. 緊急メニュー（モーダル本体） --}}

<div class="modal fade" id="emergencyModal" tabindex="-1" aria-labelledby="emergencyModalLabel" aria-hidden="true" style="z-index: 10000 !important;">

    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px !important; margin: 1.75rem auto !important; width: 92% !important;">

        <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 20px !important; overflow: hidden !important; background: #fff !important;">

            

            {{-- モーダルヘッダー --}}

            <div class="modal-header bg-danger text-white border-0 py-3 px-4 d-flex align-items-center justify-content-between" style="display: flex !important;">

                <h5 class="modal-title fw-bold text-white mb-0" id="emergencyModalLabel" style="font-size: 1.1rem !important;">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>緊急連絡・SOSメニュー

                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%) !important; opacity: 0.8 !important;"></button>

            </div>

            {{-- モーダルボディ --}}

            <div class="modal-body p-4 bg-light" style="display: block !important;">

                <p class="text-muted text-center small mb-3" style="font-size: 0.75rem !important;">項目をタップすると直接発信やアプリを起動できます</p>

                

                <div class="d-flex flex-column gap-3" style="display: flex !important; flex-direction: column !important; gap: 1rem !important;">

                    <!-- 学校緊急連絡 -->

                    <div class="p-3 bg-white border border-secondary border-opacity-10 rounded-3 shadow-sm" style="border-left: 5px solid #0d6efd !important;">

                        <div class="small text-muted fw-bold mb-1" style="font-size: 0.75rem !important;">🏫 学校（医務室・日本人スタッフ）</div>

                        <a href="tel:09123456789" class="d-flex align-items-center justify-content-between text-decoration-none">

                            <span class="fw-bold text-dark" style="font-size: 0.9rem !important;">学校緊急ダイヤル</span>

                            <span class="badge bg-primary px-2 py-1.5" style="color: #fff !important;"><i class="fa-solid fa-phone me-1"></i>通話する</span>

                        </a>

                    </div>

                    <!-- ジャパニーズヘルプデスク -->

                    <div class="p-3 bg-white border border-secondary border-opacity-10 rounded-3 shadow-sm" style="border-left: 5px solid #0dcaf0 !important;">

                        <div class="small text-muted fw-bold mb-1" style="font-size: 0.75rem !important;">🏥 24時間対応病院（JHD日本語窓口）</div>

                        <a href="tel:0322338620" class="d-flex align-items-center justify-content-between text-decoration-none">

                            <span class="fw-bold text-dark" style="font-size: 0.9rem !important;">セブドク JHD直通</span>

                            <span class="badge bg-info text-dark px-2 py-1.5 fw-bold"><i class="fa-solid fa-phone me-1"></i>日本語</span>

                        </a>

                    </div>



                    <!-- フィリピン国家警察・救急 -->

                    <div class="p-3 bg-white border border-secondary border-opacity-10 rounded-3 shadow-sm" style="border-left: 5px solid #dc3545 !important;">

                        <div class="small text-muted fw-bold mb-1" style="font-size: 0.75rem !important;">🚨 フィリピン国家緊急番号（警察・救急車）</div>

                        <a href="tel:911" class="d-flex align-items-center justify-content-between text-decoration-none">

                            <span class="fw-bold text-danger" style="font-size: 0.9rem !important;">救急車・警察 (911)</span>

                            <span class="badge bg-danger px-2 py-1.5" style="color: #fff !important;"><i class="fa-solid fa-phone me-1"></i>911発信</span>

                        </a>

                    </div>



                    <!-- Grab自力移動 -->

                    <div class="p-3 bg-white border border-secondary border-opacity-10 rounded-3 shadow-sm" style="border-left: 5px solid #198754 !important;">

                        <div class="small text-muted fw-bold mb-1" style="font-size: 0.75rem !important;">🚗 自力で即座に病院へ向かう場合</div>

                        <a href="https://grab.onelink.me/2695614242/v7889v8a?dropoff_name=Cebu%20Doctors%27%20University%20Hospital&dropoff_lat=10.3134&dropoff_lng=123.8927" 

                           target="_blank" 

                           class="d-flex align-items-center justify-content-between text-decoration-none">

                            <span class="fw-bold text-dark" style="font-size: 0.9rem !important;">Grabでセブドクを開く</span>

                            <span class="badge bg-success px-2 py-1.5" style="color: #fff !important;"><i class="fa-solid fa-car me-1"></i>起動</span>

                        </a>

                    </div>

                </div>

            </div>
            {{-- モーダルClose --}}

            <div class="modal-footer bg-white border-0 pt-0 d-flex justify-content-center">

                <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">メニューを閉じる</button>

            </div>

        </div>

    </div>

</div>

