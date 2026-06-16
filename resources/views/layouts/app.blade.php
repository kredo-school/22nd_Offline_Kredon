<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        html,
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        body {
            overflow-x: hidden;
        }

        /* TOP NAVBAR */
        .navbar-top {
            position: fixed;
            top: 0;
            left: 200px;
            right: 0;
            height: 70px;
            background: #fff;
            z-index: 1000;
        }

        /* SIDEBAR */
        .sidebar-left {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100vh;
            overflow-y: auto;
            background: #f7f5f0;
            border-right: 1px solid #e9ecef;
            z-index: 1100;
        }

        /* CONTENT */
        .content-body {
            margin-left: 200px;
            margin-top: 70px;
            padding: 24px;
            min-height: calc(100vh - 70px);
        }

        /* SIDEBAR MENU */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #495057;
            text-decoration: none;
            transition: .2s;
        }

        .sidebar-link:hover {
            background: #edeae4;
            color: #000;
        }

        .sidebar-link i {
            width: 20px;
        }

        .premium-card {
            background: rgb(218, 238, 246);
            border-radius: 12px;
        }

        .premium-title {
            color: darkcyan;
            font-weight: bold;
        }

        @media(max-width:768px) {

            .navbar-top {
                left: 0;
            }

            .sidebar-left {
                display: none;
            }

            .content-body {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

<div id="app">

    {{-- TOP NAVBAR --}}
    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom navbar-top shadow-sm">

        <div class="container-fluid px-4">

            {{-- SEARCH --}}
            <form class="d-none d-md-flex mx-auto" style="width:40%;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>

                    <input
                        class="form-control bg-light border-0"
                        type="search"
                        placeholder="Search here...">
                </div>
            </form>

            {{-- RIGHT --}}
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fa-solid fa-house-chimney"></i>
                    </a>
                </li>

                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="#">
                        <i class="fa-solid fa-bell"></i>
                    </a>
                </li>

                <li class="nav-item me-3">
                    <a class="nav-link" href="#">
                        <i class="fa-regular fa-envelope"></i>
                    </a>
                </li>

                @auth

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       data-bs-toggle="dropdown">

                        {{ Auth::user()->name }}

                    </a>

                    <div class="dropdown-menu dropdown-menu-end">

                        <a class="dropdown-item"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">

                            Logout

                        </a>

                    </div>

                </li>

                @endauth

            </ul>

        </div>

    </nav>

    {{-- SIDEBAR --}}
    <aside class="sidebar-left">

        <div class="text-center py-3">

            <img
                src="{{ asset('images/kredon.png') }}"
                alt="logo"
                style="height:90px">

        </div>

        <a href="#" class="sidebar-link">
            <i class="fa-solid fa-map-location-dot"></i>
            SPOT
        </a>

        <a href="{{ route('event.index') }}"
           class="sidebar-link">
            <i class="fa-solid fa-calendar-days"></i>
            EVENT
        </a>

        <a href="{{ route('marketplace.index') }}"
           class="sidebar-link">
            <i class="fa-solid fa-store"></i>
            MARKET
        </a>

        <a href="#" class="sidebar-link">
            <i class="fa-regular fa-bookmark"></i>
            BOOKMARK
        </a>

        <a href="#" class="sidebar-link">
            <i class="fa-regular fa-star"></i>
            REVIEW
        </a>

        <hr>

        <a href="#" class="sidebar-link">
            <i class="fa-regular fa-user"></i>
            MY PAGE
        </a>

        <a href="#" class="sidebar-link">
            <i class="fa-solid fa-gear"></i>
            SETTING
        </a>

        <div class="p-3">

            <div class="card premium-card">

                <div class="card-body">

                    <h6 class="premium-title">
                        KREDON PREMIUM
                    </h6>

                    <p class="small text-muted">
                        Update to Premium to enjoy exclusive features.
                    </p>

                </div>

            </div>

        </div>

    </aside>

    {{-- CONTENT --}}
    <main class="content-body">

        @yield('content')

    </main>

</div>

<form id="logout-form"
      action="{{ route('logout') }}"
      method="POST"
      class="d-none">

    @csrf

</form>

</body>
</html>