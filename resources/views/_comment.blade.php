@section('content')

<div class="container-fluid py-4">
    <div class="row g-3">

        {{-- スマホでは上に来る --}}
        <div class="col-12 col-lg-3">

            <div class="card border-0 shadow-sm">
                <div class="list-group list-group-flush">

                    <a href="#" class="list-group-item">
                        Account
                    </a>

                    <a href="#" class="list-group-item">
                        Notification
                    </a>

                    <a href="#" class="list-group-item">
                        Comment
                    </a>

                    <a href="#" class="list-group-item">
                        Privacy
                    </a>

                </div>
            </div>

        </div>

        {{-- Main --}}
        <div class="col-12 col-lg-6">

            {{-- コメント設定 --}}
            <div class="card border-0 shadow-sm mb-3">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        Comment Settings
                    </h5>

                    {{-- コメント許可 --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h6 class="fw-bold mb-1">
                                コメント許可
                            </h6>

                            <small class="text-muted">
                                他のユーザーがコメント可能です
                            </small>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   checked>
                        </div>

                    </div>

                    <hr>

                    {{-- フォロワー限定コメント --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h6 class="fw-bold mb-1">
                                フォロワー限定コメント
                            </h6>

                            <small class="text-muted">
                                フォロワーのみコメント可能
                            </small>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox">
                        </div>

                    </div>

                    <hr>

                    {{-- コメント事前承認 --}}
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h6 class="fw-bold mb-1">
                                コメント事前承認
                            </h6>

                            <small class="text-muted">
                                承認後に公開されます
                            </small>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox">
                        </div>

                    </div>

                </div>

            </div>

            {{-- NGワード --}}
            <div class="card border-0 shadow-sm mb-3">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        NG Word Filter
                    </h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>
                            <h6 class="fw-bold mb-1">
                                NGワードフィルター
                            </h6>

                            <small class="text-muted">
                                不適切な単語を非表示
                            </small>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   checked>
                        </div>

                    </div>

                    <button class="btn btn-outline-primary btn-sm">
                        NGワード管理
                    </button>

                </div>

            </div>

            {{-- スパム対策 --}}
            <div class="card border-0 shadow-sm mb-3">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        Spam Protection
                    </h5>

                    {{-- スパム検出 --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>
                            <h6 class="fw-bold mb-1">
                                スパム検出
                            </h6>

                            <small class="text-muted">
                                自動でスパム検出
                            </small>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   checked>
                        </div>

                    </div>

                    {{-- AIモデレーション --}}
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h6 class="fw-bold mb-1">
                                AIモデレーション
                            </h6>

                            <small class="text-muted">
                                AIが不適切コメントを検出
                            </small>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   checked>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- プレビュー --}}
        <div class="col-12 col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Live Preview
                    </h5>

                    <div class="border rounded p-3">

                        <div class="d-flex align-items-center mb-3">

                            <img src="https://ui-avatars.com/api/?      name=User" class="rounded-circle me-2"
                                 width: 50px
                                 height: 50px>
                        
                        </div>
                        <div class="fw-bold">
                            Kredon User
                        </div>

                        <small class="text-muted">
                            {{'@Kredon'}}
                        </small>

                    </div>

                </div>

                <p>
                    留学生活最高！
                </p>

                <img src="https://placehold.co/600x300"
                     class="img-fluid rounded">
            </div>

        </div>

    </div>
</div>
@endsection