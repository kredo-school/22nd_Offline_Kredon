@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')

<div class="row">

    {{-- 左設定メニュー --}}
    <div class="col-12 col-lg-3">

        <div class="card border-0 shadow-sm">

            <div class="list-group list-group-flush">

                <a href="#"
                   class="list-group-item list-group-item-action active">
                    <i class="fa-solid fa-user me-2"></i>
                    Account
                </a>

                <a href="#"
                   class="list-group-item list-group-item-action">
                    <i class="fa-solid fa-desktop me-2"></i>
                    Display
                </a>

                <a href="#"
                   class="list-group-item list-group-item-action">
                    <i class="fa-solid fa-bell me-2"></i>
                    Notification
                </a>

                <a href="#"
                   class="list-group-item list-group-item-action">
                    <i class="fa-solid fa-shield-halved me-2"></i>
                    Privacy
                </a>

                <a href="#"
                   class="list-group-item list-group-item-action">
                    <i class="fa-solid fa-mobile-screen me-2"></i>
                    App
                </a>

            </div>

        </div>

    </div>

    {{-- 中央 --}}
    <div class="col12 col-lg-6">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5 class="fw-bold mb-4">
                    Account Settings
                </h5>

                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <input type="text"
                           class="form-control"
                           value="Kredon User">
                </div>

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email"
                           class="form-control"
                           value="sample@gmail.com">
                </div>

                <div class="mb-4">
                    <label class="form-label">Bio</label>
                    <textarea class="form-control"
                              rows="3"></textarea>
                </div>

                <button class="btn btn-primary">
                    Save Changes
                </button>

            </div>

        </div>

    </div>

    {{-- 右サイド --}}
    <div class="col-12 col-lg-3">

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-body">

                <h6 class="fw-bold">
                    Live Preview
                </h6>

                <img src="https://placehold.co/600x250"
                     class="img-fluid rounded">

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="fw-bold">
                    Account Status
                </h6>

                <p class="text-success mb-1">
                    Active
                </p>

            </div>

        </div>

    </div>

</div>
@endsection