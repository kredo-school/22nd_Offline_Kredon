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

        /* ── Mobile Drawer ── */
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: -280px;
            width: 260px;
            height: 100vh;
            background: #f7f5f0;
            border-right: 1px solid #e9ecef;
            z-index: 2000;
            transition: left 0.28s cubic-bezier(.4, 0, .2, 1);
            overflow-y: auto;
        }

        .mobile-drawer.open {
            left: 0;
        }

        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 1999;
        }

        .drawer-overlay.open {
            display: block;
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
                /* overflow: hidden !important; */
                /* margin-top: 70px; */
            }

            .content-body {
                margin-left: 200px !important;
                margin-top: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                height: calc(100vh - 70px) !important;
                width: calc(100% - 200px) !important;
                overflow-y: auto !important;
                background-color: #f8f9fa;
            }

            /* スマホ専用要素をPC時は非表示 */
            .mobile-drawer,
            .drawer-overlay,
            .hamburger-btn {
                display: none !important;
            }
        }

        /* ── Mobile ── */
        @media (max-width: 767px) {

            /* PC用サイドバー非表示 */
            .sidebar-left {
                display: none !important;
            }

            .navbar-top {
                margin-left: 0 !important;
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

        .sidebar-link:hover {
            background-color: #edeae4 !important;
            color: #000;
        }

        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        #spotSubmenu a:hover {
            background-color: #edeae4;
            color: #000 !important;
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
            height: 48px;
            width: auto;
        }

        .mobile-topbar-icons {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .mobile-topbar-icons a {
            color: #495057;
            font-size: 1.1rem;
            position: relative;
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
                <form class="d-flex mx-auto" style="width:40%;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control bg-light border-0" type="search" placeholder="Search here...">
                    </div>
                </form>

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
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                                role="button" data-bs-toggle="dropdown">
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
                {{-- ハンバーガー --}}
                <button class="hamburger-btn btn btn-light border-0 p-2" onclick="openDrawer()" aria-label="Menu">
                    <i class="fa-solid fa-bars fa-lg text-secondary"></i>
                </button>

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
                        <a href="#" class="d-flex align-items-center">
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
                    @endauth
                </div>
            </div>
        </nav>

        {{-- ══════════════════════════════════
         スマホ用ドロワー
    ══════════════════════════════════ --}}
        <div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>

        <div class="mobile-drawer" id="mobileDrawer">
            <div class="py-3">
                {{-- ロゴ --}}
                <div class="text-center mb-2 px-3">
                    <img src="{{ asset('images/kredon.png') }}" alt="Kredon" style="height:100px; width:auto;">
                </div>

                @auth
                    <div class="px-3 mb-3 d-flex align-items-center gap-2">
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
                        <span class="fw-bold small">{{ Auth::user()->name }}</span>
                    </div>
                @endauth

                <hr class="mx-3 my-2">

                <div class="command">
                    {{-- SPOT --}}
                    <a href="#" class="sidebar-link" onclick="toggleSpot(event)">
                        <i class="fa-solid fa-map-location-dot"></i> SPOT
                        <i class="fa-solid fa-chevron-down ms-auto small" id="spotChevron"
                            style="transition:transform 0.2s;"></i>
                    </a>
                    <div id="spotSubmenu" style="display:none;" class="ps-2">
                        <a href="#" class="d-block text-decoration-none text-muted py-2 ps-5"
                            style="font-size:0.82rem;">Working</a>
                        <a href="#" class="d-block text-decoration-none text-muted py-2 ps-5"
                            style="font-size:0.82rem;">Hospital</a>
                        <a href="#" class="d-block text-decoration-none text-muted py-2 ps-5"
                            style="font-size:0.82rem;">Tourism</a>
                    </div>

                    <a href="#" class="sidebar-link"><i class="fa-solid fa-calendar-days"></i> EVENT</a>
                    <a href="#" class="sidebar-link"><i class="fa-solid fa-store"></i> MARKET</a>
                    <a href="#" class="sidebar-link"><i class="fa-regular fa-bookmark"></i> BOOKMARK</a>
                    <a href="#" class="sidebar-link"><i class="fa-regular fa-star"></i>
                        REVIEW</a>

                    <hr class="mx-3 my-2 text-muted">

                    <a href="#" class="sidebar-link"><i class="fa-regular fa-user"></i> MY PAGE</a>
                    <a href="#" class="sidebar-link"><i class="fa-solid fa-gear"></i> SETTING</a>
                    <a href="#" class="sidebar-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> LOGOUT
                    </a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf</form>
                </div>

                {{-- Premium card --}}
                <div class="px-3 mt-4">
                    <div class="card shadow-sm" style="background-color:rgb(218,238,246);border-radius:12px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-crown" style="color:gold;"></i>
                                <h6 class="card-title fw-bold m-0 ms-2" style="color:darkcyan;">KREDON PREMIUM</h6>
                            </div>
                            <p class="card-text text-muted mb-3" style="font-size:0.8rem;line-height:1.4;">
                                Update to Premium to enjoy exclusive events, advanced filters, and unlimited gameplay!
                            </p>
                            <a href="#" class="btn btn-light btn-sm w-100" style="color:darkcyan;">Details</a>
                        </div>
                    </div>
                </div>
            </div>
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

                    <div class="command">                       
                        {{-- PCサイドバーのSPOTリンク --}}
                        <a href="#" class="sidebar-link" onclick="toggleSpotPC(event)">
                            <i class="fa-solid fa-map-location-dot"></i> SPOT
                            <i class="fa-solid fa-chevron-down ms-auto small" id="spotChevronPC"
                                style="transition:transform 0.2s;"></i>
                        </a>
                        <div id="spotSubmenuPC" style="display:none;" class="accordion-item">
                            <a href="#" class="d-block text-decoration-none text-muted py-2 ps-5"
                                style="font-size:0.82rem;">Working</a>
                            <a href="#" class="d-block text-decoration-none text-muted py-2 ps-5"
                                style="font-size:0.82rem;">Hospital</a>
                            <a href="#" class="d-block text-decoration-none text-muted py-2 ps-5"
                                style="font-size:0.82rem;">Tourism</a>
                        </div>

                        <a href="#" class="sidebar-link"><i class="fa-solid fa-calendar-days"></i> EVENT</a>
                        <a href="#" class="sidebar-link"><i class="fa-solid fa-store"></i> MARKET</a>
                        <a href="#" class="sidebar-link"><i class="fa-regular fa-bookmark"></i> BOOKMARK</a>
                        <a href="#" class="sidebar-link"><i
                                class="fa-regular fa-star"></i> REVIEW</a>

                        <hr class="mx-3 my-2 text-muted">

                        <a href="#" class="sidebar-link"><i class="fa-regular fa-user"></i> MY PAGE</a>
                        <a href="#" class="sidebar-link"><i class="fa-solid fa-gear"></i> SETTING</a>
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
                                    <h6 class="card-title fw-bold m-0 ms-1" style="color:darkcyan; font-size: 0.75rem;">KREDON PREMIUM
                                    </h6>
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
        // ── ドロワー開閉 ──
        function openDrawer() {
            document.getElementById('mobileDrawer').classList.add('open');
            document.getElementById('drawerOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            document.getElementById('mobileDrawer').classList.remove('open');
            document.getElementById('drawerOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        // ── SPOTサブメニュー ──      
        function toggleSpotPC(e) {
            e.preventDefault();
            const menu = document.getElementById('spotSubmenuPC');
            const chevron = document.getElementById('spotChevronPC');
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        // スワイプで閉じる
        let touchStartX = 0;
        document.getElementById('mobileDrawer').addEventListener('touchstart', e => {
            touchStartX = e.touches[0].clientX;
        });
        document.getElementById('mobileDrawer').addEventListener('touchend', e => {
            if (touchStartX - e.changedTouches[0].clientX > 60) closeDrawer();
        });
    </script>
</body>

</html>