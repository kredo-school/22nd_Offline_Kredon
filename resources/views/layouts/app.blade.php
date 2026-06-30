<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        html,
        body,
        #app {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
            height: 70px;
            overflow: visible !important;
        }

        .navbar-top .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            margin-top: 4px;
            z-index: 1050;
        }

        /* ── Sidebar ── */
        .sidebar-left {
            width: 200px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #f7f5f0;
            border-right: 1px solid #e9ecef;
        }

        /* ── Layout ── */
        .main-wrapper {
            display: flex;
            flex-direction: column;
        }

        .content-body {
            flex: 1;
            margin-left: 0;
            margin-top: 70px;
        }

        /* ── Desktop ── */
        @media (min-width: 768px) {

            html,
            body,
            #app {
                height: 100vh !important;
                overflow: hidden !important;
            }

            .navbar-top {
                margin-left: 200px;
            }

            .main-wrapper {
                flex-direction: row !important;
                height: calc(100vh - 70px) !important;
                overflow: hidden !important;
            }

            .content-body {
                margin-left: 200px !important;
                margin-top: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                height: calc(100vh - 70px) !important;
                width: calc(100% - 200px) !important;
                overflow: hidden !important;
                background-color: #f8f9fa;
            }
        }

        /* ── Mobile ── */
        @media (max-width: 767px) {
            .sidebar-left {
                display: none !important;
            }

            .navbar-top {
                margin-left: 0 !important;
            }

            .content-body {
                padding-bottom: 60px;
            }
        }

        /* ── Sidebar共通スタイル ── */
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: #495057;
            text-decoration: none;
            transition: background 0.2s;
            font-size: 0.85rem;
        }

        .sidebar-link:hover,
        .sidebar-link:active {
            background-color: #edeae4 !important;
            color: #000;
        }

        .sidebar-link.active {
            background-color: #edeae4;
            color: #000;
            font-weight: 600;
        }

        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* ── Spot submenu ── */
        .spot-sub-link {
            display: block;
            text-decoration: none;
            color: #6c757d;
            padding: 8px 0 8px 48px;
            font-size: 0.82rem;
            transition: background 0.2s, color 0.2s;
        }

        .spot-sub-link:hover,
        .spot-sub-link:active {
            background-color: #edeae4;
            color: #000;
        }

        /* ── Premium card ── */
        .card-title {
            font-size: 0.65rem;
            font-style: italic;
            font-weight: bolder;
            border-bottom: darkcyan 1px solid;
        }

        .command a {
            font-size: 0.85rem;
        }

        /* ── Mobile topbar ── */
        .mobile-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            height: 70px;
        }

        .mobile-topbar .logo-img {
            height: 100px;
            width: auto;
        }

        .mobile-topbar-icons {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .mobile-topbar-icons>a {
            color: #495057;
            font-size: 1.1rem;
            position: relative;
        }

        /* ── Bottom Nav ── */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #fff;
            border-top: 1px solid #e9ecef;
            z-index: 1040;
            justify-content: space-around;
            align-items: center;
            display: none;
            /* non-display (default) */
        }

        @media (max-width: 767px) {
            .bottom-nav {
                display: flex !important;
                /* スマホのみ表示 */
            }

            .content-body {
                padding-bottom: 60px;
            }
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            color: #adb5bd;
            text-decoration: none;
            font-size: 0.6rem;
            gap: 3px;
            padding: 6px 0;
            transition: color 0.2s;
        }

        .bottom-nav-item i {
            font-size: 1.2rem;
        }

        .bottom-nav-item.active,
        .bottom-nav-item:active {
            color: darkcyan;
        }

        /* ── Spot Modal ── */
        @media (min-width: 768px) {

            .spot-modal,
            .spot-modal-overlay {
                display: none !important;
            }
        }

        .spot-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 2000;
        }

        .spot-modal-overlay.open {
            display: block;
        }

        .spot-modal {
            position: fixed;
            bottom: -400px;
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 16px 16px 0 0;
            padding: 12px 24px 80px;
            z-index: 2001;
            transition: bottom 0.3s cubic-bezier(.4, 0, .2, 1);
        }

        .spot-modal.open {
            bottom: 0;
        }

        .spot-modal-handle {
            width: 40px;
            height: 4px;
            background: #dee2e6;
            border-radius: 2px;
            margin: 0 auto 16px;
        }

        .spot-modal-title {
            font-size: 0.75rem;
            font-weight: bold;
            color: #adb5bd;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .spot-modal-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            font-size: 1rem;
            color: #495057;
            text-decoration: none;
            border-bottom: 1px solid #f1f3f5;
        }

        .spot-modal-item:last-child {
            border-bottom: none;
        }

        .spot-modal-item:active {
            color: darkcyan;
        }
    </style>
</head>

<body>
    <div id="app">

        {{-- ══════════════════════════════════
             PC用 Navbar（md以上）
        ══════════════════════════════════ --}}
        <nav class="navbar navbar-light bg-white border-bottom navbar-top shadow-sm d-none d-md-flex">
            <div class="container-fluid px-4">
                {{-- <form class="d-flex mx-auto" style="width:40%;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control bg-light border-0" type="search" placeholder="Search here...">
                    </div>
                </form> --}}

                <ul class="navbar-nav ms-auto align-items-center flex-row gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-house-chimney fa-lg"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#">
                            <i class="fa-solid fa-bell fa-lg"></i>
                            <span
                                class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">2</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-regular fa-envelope fa-lg"></i></a>
                    </li>

                    {{-- User drop down --}}
                    <div class="vr mx-1"></div>
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link d-flex align-items-center gap-2 dropdown-toggle" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar"
                                        style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;justify-content:center;
                             width:32px;height:32px;border-radius:50%;background:#212529;
                             color:#fff;font-size:0.8rem;font-weight:bold;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                @endif
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-regular fa-user me-2"></i>My Page
                                    </a>
                                </li>
                                @if (Auth::user()->role == 1)
                                    <li>
                                        <a class="dropdown-item fw-bold" href="{{ route('admin.dashboard') }}" style="color: darkcyan;">
                                            <i class="fa-solid fa-shield-halved me-2"></i>Admin Page
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        {{-- ══════════════════════════════════
             スマホ用 Topbar（md未満）
        ══════════════════════════════════ --}}
        <nav class="navbar-top bg-white border-bottom shadow-sm d-flex d-md-none">
            <div class="mobile-topbar w-100">
                {{-- ロゴ中央 --}}
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/kredon.png') }}" alt="Kredon" class="logo-img">
                </a>

                {{-- 右アイコン --}}
                <div class="mobile-topbar-icons">
                    <a href="#" class="position-relative">
                        <i class="fa-solid fa-bell"></i>
                        <span class="position-absolute badge rounded-pill bg-danger"
                            style="font-size:0.55rem;padding:2px 4px;top:-4px;right:-6px;">2</span>
                    </a>
                    <a href="#">
                        <i class="fa-regular fa-envelope"></i>
                    </a>
                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar"
                                        style="width:30px;height:30px;border-radius:50%;object-fit:cover;">
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;justify-content:center;
                                             width:30px;height:30px;border-radius:50%;background:#212529;
                                             color:#fff;font-size:0.75rem;font-weight:bold;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-regular fa-user me-2"></i>My Page
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-regular fa-bookmark me-2"></i>Bookmark
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-gear me-2"></i>Setting
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @if (Auth::user()->role === 1)
                                    <li>
                                        <a class="dropdown-item fw-bold" href="{{ route('admin.dashboard') }}" style="color: darkcyan;">
                                            <i class="fa-solid fa-shield-halved me-2"></i>Admin Page
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item fw-bold" href="#" style="color: darkcyan;">
                                        <i class="fa-solid fa-crown me-2" style="color:gold;"></i>Premium Member
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        {{-- </div> --}}  {{-- [Step3 変更前] nav を div で閉じていた（コンフリクト混入） --}}
        </nav>

        {{-- ══════════════════════════════════
             スマホ用 ボトムナビ（md未満）
        ══════════════════════════════════ --}}
        <nav class="bottom-nav">
            <a href="{{ url('/home') }}" class="bottom-nav-item {{ request()->is('home') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
            <a href="#" class="bottom-nav-item {{ request()->routeIs('spot.*') ? 'active' : '' }}"
                onclick="openSpotModal(event)">
                <i class="fa-solid fa-map-location-dot"></i>
                <span>Spot</span>
            </a>
            <a href="#" class="bottom-nav-item {{ request()->routeIs('event.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Event</span>
            </a>
            <a href="#" class="bottom-nav-item {{ request()->routeIs('market.*') ? 'active' : '' }}">
                <i class="fa-solid fa-store"></i>
                <span>Market</span>
            </a>
            <a href="#" class="bottom-nav-item {{ request()->routeIs('review.*') ? 'active' : '' }}">
                <i class="fa-regular fa-star"></i>
                <span>Review</span>
            </a>
        </nav>

        {{-- ══════════════════════════════════
             スマホ用 SPOTモーダル
        ══════════════════════════════════ --}}
        <div class="spot-modal-overlay" id="spotModalOverlay" onclick="closeSpotModal()"></div>
        <div class="spot-modal" id="spotModal">
            <div class="spot-modal-handle"></div>
            <p class="spot-modal-title">SPOT</p>
            <a href="#" class="spot-modal-item">
                <i class="fa-solid fa-briefcase"></i> Working
            </a>
            <a href="#" class="spot-modal-item">
                <i class="fa-solid fa-hospital"></i> Hospital
            </a>
            <a href="#" class="spot-modal-item">
                <i class="fa-solid fa-camera"></i> Tourism
            </a>
        </div>

        {{-- ══════════════════════════════════
             PC用 左サイドバー（md以上）
        ══════════════════════════════════ --}}
        <div class="main-wrapper">
            <aside class="sidebar-left d-none d-md-block">
                <div class="py-2">
                    <a class="d-block text-center" href="{{ url('/') }}">
                        <img src="{{ asset('images/kredon.png') }}" alt="Logo"
                            style="height:130px;width:auto;object-fit:contain; margin-bottom: -30px; margin-top: -20px;">
                    </a>

                    <hr class="mx-3 my-2 text-muted">

                    <div class="command">
                        {{-- PCサイドバーのSPOTリンク --}}
                        <a href="#" class="sidebar-link {{ request()->routeIs('spot.*') ? 'active' : '' }}"
                            onclick="toggleSpotPC(event)">
                            <i class="fa-solid fa-map-location-dot"></i> SPOT
                            <i class="fa-solid fa-chevron-down ms-auto small" id="spotChevronPC"
                                style="transition:transform 0.2s;"></i>
                        </a>
                        <div id="spotSubmenuPC" style="display:none;">
                            <a href="#" class="spot-sub-link">Working</a>
                            <a href="#" class="spot-sub-link">Hospital</a>
                            <a href="#" class="spot-sub-link">Tourism</a>
                        </div>

                        <a href="#" class="sidebar-link {{ request()->routeIs('event.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-days"></i> EVENT
                        </a>
                        <a href="#" class="sidebar-link {{ request()->routeIs('market.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-store"></i> MARKET
                        </a>
                        <a href="#"
                            class="sidebar-link {{ request()->routeIs('bookmark.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-bookmark"></i> BOOKMARK
                        </a>
                        <a href="#" class="sidebar-link {{ request()->routeIs('review.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-star"></i> REVIEW
                        </a>

                        <hr class="mx-3 my-2 text-muted">

                        <a href="#" class="sidebar-link {{ request()->routeIs('mypage.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-user"></i> MY PAGE
                        </a>
                        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('setting.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-gear"></i> SETTING
                        </a>
                        <a href="#" class="sidebar-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> LOGOUT
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                        </form>
                    </div>

                    {{-- Kredon Premium --}}
                    <hr class="mx-3 my-2 text-muted">
                    <div class="px-3 mt-4">
                        <div class="card shadow-sm" style="background-color:rgb(218,238,246);border-radius:12px;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-crown" style="color:gold;"></i>
                                    <h6 class="card-title fw-bold m-0 ms-1"
                                        style="color:darkcyan; font-size: 0.75rem;">KREDON PREMIUM</h6>
                                </div>
                                <p class="card-text text-muted mb-3" style="font-size:0.8rem;line-height:1.4;">
                                    Update to Premium to enjoy exclusive events, advanced filters, and unlimited
                                    gameplay!
                                </p>
                                <a href="#" class="btn btn-light btn-sm w-100"
                                    style="color:darkcyan;">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="content-body">
                @yield('content')
                @stack('scripts')
            </main>
        </div>
    </div>

    <script>
        // ── PC SPOTサブメニュー ──
        function toggleSpotPC(e) {
            e.preventDefault();
            const menu = document.getElementById('spotSubmenuPC');
            const chevron = document.getElementById('spotChevronPC');
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        // ── スマホ SPOTモーダル ──
        function openSpotModal(e) {
            e.preventDefault();
            document.getElementById('spotModal').classList.add('open');
            document.getElementById('spotModalOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeSpotModal() {
            document.getElementById('spotModal').classList.remove('open');
            document.getElementById('spotModalOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        // スワイプ下げで閉じる
        let touchStartY = 0;
        document.getElementById('spotModal').addEventListener('touchstart', e => {
            touchStartY = e.touches[0].clientY;
        });
        document.getElementById('spotModal').addEventListener('touchend', e => {
            if (e.changedTouches[0].clientY - touchStartY > 60) closeSpotModal();
        });
    </script>
</body>

</html>