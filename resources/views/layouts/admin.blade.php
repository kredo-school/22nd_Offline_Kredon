<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} Admin | @yield('title')</title>
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
            background-color: #f0f2f5;
            min-height: 100vh;
        }

        /* ══════════════════════════════
           CSS Variables
        ══════════════════════════════ */
        :root {
            --admin-sidebar-bg: #1a1f2e;
            --admin-sidebar-width: 220px;
            --admin-navbar-height: 70px;
            --admin-accent: #0ea5e9;
            --admin-accent-hover: #0284c7;
            --admin-text-muted: #8892a4;
            --admin-link-color: #c9d1e0;
            --admin-link-hover-bg: rgba(255, 255, 255, 0.08);
            --admin-link-active-bg: rgba(14, 165, 233, 0.15);
            --admin-link-active-color: #0ea5e9;
            --admin-divider: rgba(255, 255, 255, 0.08);
            --admin-section-label: #5a6478;
        }

        /* ══════════════════════════════
           Navbar (Top)
        ══════════════════════════════ */
        .admin-navbar {
            position: fixed;
            top: 0;
            left: var(--admin-sidebar-width);
            right: 0;
            z-index: 1040;
            height: var(--admin-navbar-height);
            background: #ffffff;
            border-bottom: 1px solid #e5e9f0;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        }

        .admin-navbar .search-wrap {
            flex: 1;
            max-width: 400px;
        }

        .admin-navbar .search-wrap .input-group-text {
            background: #f0f2f5;
            border: 1px solid #e5e9f0;
            border-right: none;
            color: #8892a4;
        }

        .admin-navbar .search-wrap .form-control {
            background: #f0f2f5;
            border: 1px solid #e5e9f0;
            border-left: none;
            font-size: 0.875rem;
        }

        .admin-navbar .search-wrap .form-control:focus {
            box-shadow: none;
            border-color: var(--admin-accent);
        }

        .admin-navbar-icons {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-left: auto;
        }

        .admin-navbar-icons .icon-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
        }

        .admin-navbar-icons .icon-btn:hover {
            background: #f0f2f5;
            color: #111827;
        }

        .admin-navbar-icons .badge-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .admin-navbar .vr {
            height: 40px;
            background: #273247;
            margin: 0 8px;
        }

        .admin-user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 10px;
            border: 1px solid #e5e9f0;
            background: transparent;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
            cursor: pointer;
        }

        .admin-user-btn:hover {
            background: #f0f2f5;
            color: #111827;
        }

        .admin-user-btn .avatar {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            object-fit: cover;
        }

        .admin-user-btn .avatar-initials {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--admin-accent);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        /* ══════════════════════════════
           Sidebar (Left)
        ══════════════════════════════ */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            background: var(--admin-sidebar-bg);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        /* Logo Area */
        .admin-logo-area {
            margin: 0;
            margin-bottom: 0;
            border-bottom: 1px solid var(--admin-divider);
            flex-shrink: 0;
        }

        .admin-logo-area img {
            height: 70px;
            width: auto;
            filter: brightness(0) invert(1);
            opacity: 0.9;
            margin: 0 auto;
        }

        .admin-logo-area .admin-badge {
            display: inline-block;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--admin-accent);
            background-color: #185b7a;
            color: #fff;
            padding: 5px 5px;
            border-radius: 4px;
            margin-left: 6px;
            vertical-align: middle;
        }

        /* Nav */
        .admin-nav {
            flex: 1;
            padding: 12px 0;
        }

        .admin-nav-section {
            padding: 16px 16px 4px;
        }

        .admin-nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--admin-section-label);
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            color: var(--admin-link-color);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            border-radius: 0;
            transition: background 0.15s, color 0.15s;
            position: relative;
        }

        .admin-nav-link:hover {
            background: var(--admin-link-hover-bg);
            color: #fff;
        }

        .admin-nav-link.active {
            background: var(--admin-link-active-bg);
            color: var(--admin-link-active-color);
        }

        .admin-nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            background: var(--admin-accent);
            border-radius: 0 3px 3px 0;
        }

        .admin-nav-link i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            flex-shrink: 0;
            opacity: 0.8;
        }

        .admin-nav-link.active i,
        .admin-nav-link:hover i {
            opacity: 1;
        }

        .admin-nav-link .badge-count {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 700;
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 2px 7px;
            border-radius: 20px;
            line-height: 1.4;
        }

        .admin-nav-divider {
            border: none;
            border-top: 1px solid var(--admin-divider);
            margin: 8px 16px;
        }

        /* Admin info at bottom */
        .admin-sidebar-footer {
            padding: 12px 16px 16px;
            border-top: 1px solid var(--admin-divider);
            flex-shrink: 0;
        }

        .admin-sidebar-footer .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
        }

        .admin-sidebar-footer .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--admin-accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .admin-sidebar-footer .admin-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: #c9d1e0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-sidebar-footer .admin-role {
            font-size: 0.68rem;
            color: var(--admin-text-muted);
        }

        /* ══════════════════════════════
           Mobile Drawer
        ══════════════════════════════ */
        .admin-mobile-drawer {
            position: fixed;
            top: 0;
            left: -280px;
            width: 260px;
            height: 100vh;
            background: var(--admin-sidebar-bg);
            z-index: 2000;
            transition: left 0.28s cubic-bezier(.4, 0, .2, 1);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .admin-mobile-drawer.open {
            left: 0;
        }

        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1999;
        }

        .drawer-overlay.open {
            display: block;
        }

        /* ══════════════════════════════
           Mobile Topbar
        ══════════════════════════════ */
        .admin-mobile-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
            height: var(--admin-navbar-height);
            background: var(--admin-sidebar-bg);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .admin-mobile-topbar img {
            height: 120px;
            width: auto;
            filter: brightness(0) invert(1);
            opacity: 0.9;
        }

        .admin-mobile-topbar .hamburger-btn {
            border: none;
            background: rgba(255, 255, 255, 0.08);
            color: #c9d1e0;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .admin-mobile-topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-mobile-topbar .icon-btn {
            position: relative;
            color: #c9d1e0;
            font-size: 1rem;
            text-decoration: none;
        }

        /* ══════════════════════════════
           Layout
        ══════════════════════════════ */
        .admin-main-wrapper {
            display: flex;
            flex-direction: column;
        }

        .admin-content-body {
            margin-left: 0;
            margin-top: var(--admin-navbar-height);
            flex: 1;
        }

        /* ── Desktop ── */
        @media (min-width: 768px) {

            html,
            body,
            #app {
                height: 100vh !important;
                overflow: hidden !important;
            }

            .admin-main-wrapper {
                flex-direction: row !important;
                height: 100vh !important;
            }

            .admin-content-body {
                margin-left: var(--admin-sidebar-width) !important;
                margin-top: var(--admin-navbar-height) !important;
                width: calc(100% - var(--admin-sidebar-width)) !important;
                height: calc(100vh - var(--admin-navbar-height)) !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
            }

            .admin-mobile-drawer,
            .drawer-overlay,
            .admin-mobile-topbar {
                display: none !important;
            }
        }

        /* ── Mobile ── */
        @media (max-width: 767px) {

            .admin-sidebar,
            .admin-navbar {
                display: none !important;
            }

            .admin-content-body {
                margin-top: var(--admin-navbar-height) !important;
            }
        }

        /* ══════════════════════════════
           Dropdown (logout etc.)
        ══════════════════════════════ */
        .admin-user-dropdown .dropdown-menu {
            min-width: 180px;
            border: 1px solid #e5e9f0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 6px;
        }

        .admin-user-dropdown .dropdown-item {
            border-radius: 7px;
            font-size: 0.875rem;
            padding: 7px 12px;
        }

        .admin-user-dropdown .dropdown-item:hover {
            background: #f0f2f5;
        }

        .admin-user-dropdown .dropdown-divider {
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <div id="app">

        {{-- ══════════════════════════════════
         PC用 Topbar Navbar（md以上）
    ══════════════════════════════════ --}}
        <nav class="admin-navbar d-none d-md-flex">
            {{-- 右側アイコン --}}
            <div class="admin-navbar-icons">
                {{-- ホーム（ユーザー側） --}}
                <a href="{{ url('/') }}" class="icon-btn" title="View Site">
                    <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                </a>

                {{-- 通知 --}}
                <a href="#" class="icon-btn" title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge-dot"></span>
                </a>

                {{-- メッセージ --}}
                <a href="#" class="icon-btn" title="Messages">
                    <i class="fa-regular fa-envelope"></i>
                </a>

                <div class="vr"></div>

                {{-- ユーザードロップダウン --}}
                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary px-3">Login</a>
                @else
                    <div class="dropdown admin-user-dropdown">
                        <button class="admin-user-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar" class="avatar">
                            @else
                                <span class="avatar-initials">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa-regular fa-user me-2 text-muted"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-gear me-2 text-muted"></i>Settings
                                </a>
                            </li>
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
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endguest
            </div>
        </nav>

        {{-- ══════════════════════════════════
スマホ用 Topbar（md未満）
══════════════════════════════════ --}}
        <div class="admin-mobile-topbar d-flex d-md-none">
            <button class="hamburger-btn" onclick="openAdminDrawer()" aria-label="Menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <a href="{{ url('/admin/dashboard') }}">
                <img src="{{ asset('images/kredon.png') }}" alt="Kredon">
            </a>

            <div class="topbar-right">
                <a href="{{ url('/') }}" class="icon-btn" title="View Site">
                    <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                </a>

                <a href="#" class="icon-btn position-relative me-2">
                    <i class="fa-solid fa-bell"></i>
                    <span class="position-absolute badge rounded-pill bg-danger"
                        style="font-size:0.5rem;padding:2px 4px;top:-3px;right:-5px;">2</span>
                </a>

                {{-- メッセージ --}}
                <a href="#" class="icon-btn me-2" title="Messages">
                    <i class="fa-regular fa-envelope"></i>
                </a>

                @auth
                    <a href="#">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar"
                                style="width:28px;height:28px;border-radius:7px;object-fit:cover;">
                        @else
                            <span
                                style="display:inline-flex;align-items:center;justify-content:center;
                                     width:28px;height:28px;border-radius:7px;background:var(--admin-accent);
                                     color:#fff;font-size:0.72rem;font-weight:700;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif
                    </a>
                @endauth
            </div>
        </div>

        {{-- ══════════════════════════════════
         Drawer Overlay
    ══════════════════════════════════ --}}
        <div class="drawer-overlay" id="adminDrawerOverlay" onclick="closeAdminDrawer()"></div>

        {{-- ══════════════════════════════════
         スマホ用ドロワー
    ══════════════════════════════════ --}}
        <div class="admin-mobile-drawer" id="adminMobileDrawer">
            @include('layouts.admin-sidebar')
        </div>

        {{-- ══════════════════════════════════
         メインラッパー
    ══════════════════════════════════ --}}
        <div class="admin-main-wrapper">

            {{-- PC用左サイドバー --}}
            <aside class="admin-sidebar d-none d-md-flex">
                @include('layouts.admin-sidebar')
            </aside>

            {{-- コンテンツ --}}
            <main class="admin-content-body">
                @yield('content')
                @stack('scripts')
            </main>

        </div>
    </div>

    <script>
        // ── Drawer開閉 ──
        function openAdminDrawer() {
            document.getElementById('adminMobileDrawer').classList.add('open');
            document.getElementById('adminDrawerOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeAdminDrawer() {
            document.getElementById('adminMobileDrawer').classList.remove('open');
            document.getElementById('adminDrawerOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        // スワイプで閉じる
        const drawer = document.getElementById('adminMobileDrawer');
        if (drawer) {
            let touchStartX = 0;
            drawer.addEventListener('touchstart', e => {
                touchStartX = e.touches[0].clientX;
            });
            drawer.addEventListener('touchend', e => {
                if (touchStartX - e.changedTouches[0].clientX > 60) closeAdminDrawer();
            });
        }

        // アクティブリンクのハイライト
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.admin-nav-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.startsWith(href) && href !== '/') {
                    link.classList.add('active');
                } else if (href === '/' && currentPath === '/') {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>
