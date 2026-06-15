<div class="card border-0 shadow-sm rounded-4 mt-4">

    <div class="card-body p-4" style="background-color:#F1F4F2;">

        <h4 class="fw-bold mb-3">

            <i class="fa-solid fa-user-nurse text-success me-2"></i>

            6階医務室

        </h4>
        
        <div class="d-flex gap-2 mb-4">
            <span class="badge text-white"  
                  style="background-color: #d63384; padding: 0.5em 0.8em;">
            <i class="fa-solid fa-user-md me-1"></i>看護師常駐
            </span>
            
            <span class="badge {{ $doctorStatus['type'] === 'success' ? 'bg-success' : 'bg-danger' }}">
            {{ $doctorStatus['type'] === 'success' ? '開室中' : '閉室中' }}
            </span>
        </div>

    <p class="text-muted mb-4">
        看護師が常駐しています。体調不良や健康上の不安がある際は、まず6階医務室に相談してください。<br>
        健康管理から救急の手配、病院紹介まで幅広くサポートしています。
    </p>

    <div class="alert alert-warning py-2 px-3 mb-4 small"              style="background-color: #fff3cd; border-color: #ffecb5;">

        <i class="fa-solid fa-circle-exclamation me-1"></i>
        <strong>注意事項:</strong> 医務室では診断や処方は行っておりません。また、常備薬は日本からご持参いただくことをおすすめします。
    </div>
            
        <div class="row g-3">

            <div class="col-md-6">

                <div class="bg-white border border-success-subtle rounded-3 p-3 h-100">

                    <h6 class="fw-bold mb-2 pb-2" style= "border-bottom: 1px solid #dee2e6;">
                        医務室開室時間
                    </h6>

                    平日 8:00～17:00

                    <br>

                    ※土日閉室

                </div>

            </div>

            <div class="col-md-6">

                <div class="bg-white border border-success-subtle rounded-3 p-3 h-100 {{   $doctorStatus['type'] === 'success' ? 'border-success shadow-sm' : 'border-light' }}">

                    <h6 class="fw-bold mb-2 pb-2 border-bottom">
                        医師訪問時間
                    </h6>

                    <span class="badge bg-primary mb-2">日本語対応</span>

                    <p class="mb-0 text-sm">月・水・金 13:00～17:00</p>

                    <hr class="my-2">

                    <span class="badge bg-primary mb-1">日本語対応</span>

                    <br>

                    火・木

                    10:00～12:00 <br>

                </div>

            </div>
            
        </div>

        @if($doctorStatus['type'] !== 'success')

        <div class="d-grid mt-4">

            <a href="#search-section"
               class="btn btn-success btn-lg shadow-sm">

               病院を探す(ウィザードを開始)

            </a>

        </div>

        @endif

    </div>
</div>