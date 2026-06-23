<div class="card border-0 shadow-sm rounded-4 mt-4">

    <div class="card-body p-4 hs-medical-office">

        <h4 class="fw-bold mb-3">
            <i class="fa-solid fa-user-nurse text-success me-2"></i>
            6階医務室
        </h4>

        <div class="d-flex gap-2 mb-4">

            <span class="badge hs-medical-office__nurse-badge">
                <i class="fa-solid fa-user-md me-1"></i>
                看護師常駐
            </span>

            <span class="badge {{ $doctorStatus['type'] === 'success' ? 'bg-success' : 'bg-danger' }}">
                {{ $doctorStatus['type'] === 'success' ? '開室中' : '閉室中' }}
            </span>

        </div>

        <p class="text-muted mb-4">
            看護師が常駐しています。体調不良や健康上の不安がある際は、まず6階医務室に相談してください。
        </p>

        <div class="alert hs-medical-office__alert py-2 px-3 mb-4 small">

            <i class="fa-solid fa-circle-exclamation me-1"></i>

            <strong>注意事項:</strong>

            医務室では診断や処方は行っておりません。

        </div>

        <div class="row g-3">

            <div class="col-md-6">

                <div class="hs-medical-office__box">

                    <h6 class="hs-medical-office__heading">
                        医務室開室時間
                    </h6>

                    平日 8:00～17:00

                </div>

            </div>

            <div class="col-md-6">

                <div class="hs-medical-office__box
                    {{ $doctorStatus['type'] === 'success'
                        ? 'hs-medical-office__box--active'
                        : '' }}">

                    <h6 class="hs-medical-office__heading">
                        医師訪問時間
                    </h6>

                    ...
                </div>

            </div>

        </div>

    </div>

</div>