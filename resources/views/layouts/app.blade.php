<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- TITLE --}}
    <title>{{ config('app.name') }} | @yield('title')</title>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    {{-- Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        #app {
            min-height: 100vh;
        }

        /* TOP NAVBAR */
        .navbar-top {
            position: fixed;
            top: 0;
            left: 200px;
            right: 0;
            z-index: 1000;
            height: 70px;
            background: white;
        }

        /* MAIN */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar-left {
            width: 200px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1100;
            overflow-y: auto;
            background-color: #f7f5f0;
            border-right: 1px solid #e9ecef;
            font-size: 0.9rem;
        }

        /* CONTENT */
        .content-body {
            margin-left: 200px;
            margin-top: 70px;
            width: calc(100% - 200px);
            padding: 24px;
        }

        /* SIDEBAR LINKS */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #495057;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar-link:hover {
            background-color: #edeae4;
            color: #000;
        }

        .sidebar-link i {
            font-size: 1.1rem;
        }

        /* ACCORDION */
        .sidebar-left .accordion-item,
        .sidebar-left .accordion-button {
            background-color: #f7f5f0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .sidebar-left .accordion-button:not(.collapsed) {
            background-color: #edeae4 !important;
            color: #000;
        }

        /* PREMIUM CARD */
        .premium-card {
            background-color: rgb(218, 238, 246);
            border-radius: 12px;
        }

        .premium-title {
            color: darkcyan;
            font-weight: bold;
            font-size: 0.9rem;
        }

        /* CLICK FIX */
        a,
        button,
        .btn,
        .card {
            pointer-events: auto !important;
        }

        /* CARD */
        .card {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>

<div id="app">

    {{-- TOP NAVBAR --}}
    <nav class="navbar navbar-expand-md navbar-light border-bottom navbar-top shadow-sm">

        <div class="container-fluid px-4">

            {{-- SEARCH --}}
            <form class="d-none d-md-flex mx-auto" style="width: 40%;">
                <div class="input-group">

                    <span class="input-group-text bg-light border-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>

                    <input class="form-control bg-light border-0"
                        type="search"
                        placeholder="Search here...">

                </div>
            </form>

            {{-- RIGHT --}}
            <div class="navbar-collapse flex-grow-0 d-flex">

                <ul class="navbar-nav ms-auto align-items-center">

                    {{-- HOME --}}
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fa-solid fa-house-chimney fa-lg"></i>
                        </a>
                    </li>

                    {{-- NOTIFICATION --}}
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="#">

                            <i class="fa-solid fa-bell fa-lg"></i>

                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                2
                            </span>

                        </a>
                    </li>

                    {{-- MESSAGE --}}
                    <li class="nav-item me-3">
                        <a href="#" class="nav-link">
                            <i class="fa-regular fa-envelope fa-lg"></i>
                        </a>
                    </li>

                    {{-- POST --}}
                    <li class="nav-item me-3">

                        <a href="{{ route('marketplace.create') }}"
                            class="btn btn-primary btn-sm px-3 py-2">

                            <i class="fa-solid fa-plus"></i>
                            Post

                        </a>

                    </li>

                    <div class="vr mx-3"></div>

                    {{-- AUTH --}}
                    @guest

                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('login') }}">
                                    Login
                                </a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                        @endif

                    @else

                        <li class="nav-item dropdown">

                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">

                                {{ Auth::user()->name }}

                            </a>

                            <div class="dropdown-menu dropdown-menu-end">

                                <a class="dropdown-item"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">

                                    Logout

                                </a>

                                <form id="logout-form"
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    class="d-none">

                                    @csrf

                                </form>

                            </div>

                        </li>

                    @endguest

                </ul>

            </div>

        </div>

    </nav>

    {{-- MAIN --}}
    <div class="main-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar-left d-none d-md-block">

            <div class="py-2">

                {{-- LOGO --}}
                <a class="navbar-brand fw-bold text-primary m-0 p-0 d-block text-center"
                    href="{{ url('/') }}"
                    style="margin-top: 10px;">

                    <img src="{{ asset('images/kredon.png') }}"
                        alt="Logo"
                        style="height: 90px; object-fit: contain;">

                </a>

                {{-- MENU --}}
                <div class="command mt-4">

                    {{-- SPOT --}}
                    <div class="accordion accordion-flush"
                        id="sidebarAccordion">

                        <div class="accordion-item border-0">

                            <h2 class="accordion-header">

                                <button class="accordion-button collapsed sidebar-link bg-transparent"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseSpot">

                                    <i class="fa-solid fa-map-location-dot"></i>
                                    SPOT

                                </button>

                            </h2>

                            <div id="collapseSpot"
                                class="accordion-collapse collapse">

                                <div class="accordion-body py-1 ps-5 text-muted">

                                    <a href="#"
                                        class="d-block text-decoration-none text-muted py-2">
                                        Working
                                    </a>

                                    <a href="#"
                                        class="d-block text-decoration-none text-muted py-2">
                                        Hospital
                                    </a>

                                    <a href="#"
                                        class="d-block text-decoration-none text-muted py-2">
                                        Tourism
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- MARKET --}}
                    <a href="{{ route('marketplace.index') }}"
                        class="sidebar-link">

                        <i class="fa-solid fa-store"></i>
                        MARKET

                    </a>

                    {{-- EVENT --}}
                    <a href="#" class="sidebar-link">
                        <i class="fa-solid fa-calendar-days"></i>
                        EVENT
                    </a>

                    {{-- BOOKMARK --}}
                    <a href="#" class="sidebar-link">
                        <i class="fa-regular fa-bookmark"></i>
                        BOOKMARK
                    </a>

                    {{-- REVIEW --}}
                    <a href="#" class="sidebar-link">
                        <i class="fa-regular fa-star"></i>
                        REVIEW
                    </a>

                    <hr class="mx-3 my-2 text-muted">

                    {{-- MY PAGE --}}
                    <a href="#" class="sidebar-link">
                        <i class="fa-regular fa-user"></i>
                        MY PAGE
                    </a>

                    {{-- SETTING --}}
                    <a href="#" class="sidebar-link">
                        <i class="fa-solid fa-gear"></i>
                        SETTING
                    </a>

                    {{-- LOGOUT --}}
                    <a href="{{ route('logout') }}"
                        class="sidebar-link"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">

                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        LOGOUT

                    </a>

                </div>

                <hr class="mx-3 my-3 text-muted">

                {{-- PREMIUM --}}
                <div class="px-3 mt-4">

                    <div class="card shadow-sm premium-card">

                        <div class="card-body p-3">

                            <div class="d-flex align-items-center mb-2">

                                <i class="fa-solid fa-crown me-2"
                                    style="color: gold;"></i>

                                <h6 class="premium-title m-0">
                                    KREDON PREMIUM
                                </h6>

                            </div>

                            <p class="text-muted mb-3"
                                style="font-size: 0.8rem;">

                                Update to Premium to enjoy exclusive events,
                                advanced filters, and unlimited gameplay!

                            </p>

                            <a href="#"
                                class="btn btn-light btn-sm w-100">

                                Details

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </aside>

        {{-- CONTENT --}}
        <main class="content-body">

            @yield('content')

        </main>

    </div>

</div>

</body>

</html>
