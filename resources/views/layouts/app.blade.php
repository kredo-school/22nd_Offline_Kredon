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
        /* ── mainブランチのレイアウトスタイル ── */
        html, body, #app {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-top {
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 1060; height: 70px; margin-left: 0px;
        }
        .navbar-top .dropdown-menu {
            position: absolute !important; top: 100% !important; right: 0 !important;
            margin-top: 4px; z-index: 1050;
        }

        /* ── Sidebar ── */
        .sidebar-left {
            width: 200px;
            position: fixed; top: 0; bottom: 0; left: 0;
            z-index: 1030; overflow-y: auto; overflow-x: hidden;
            background-color: #f7f5f0; border-right: 1px solid #e9ecef;
        }

        /* ── Layout ── */
        .main-wrapper {
            display: flex; flex-direction: column;
        }
        .content-body {
            flex: 1; margin-left: 0; margin-top: 70px;
        }

        /* ── Desktop ── */
        @media (min-width: 768px) {
            html, body, #app { height: 100vh !important; overflow: hidden !important; }
            .navbar-top { margin-left: 200px; }
            .main-wrapper {
                flex-direction: row !important; margin-top: 70px !important; 
                height: calc(100vh - 70px) !important; overflow: hidden !important;
            }
            .content-body {
                margin-left: 200px !important; margin-top: 0 !important;
                display: flex !important; flex-direction: column !important;
                height: calc(100vh - 70px) !important; width: calc(100% - 200px) !important;
                overflow-y: auto !important; overflow-x: hidden !important; background-color: #f8f9fa;
            }
        }

        /* ── Mobile ── */
        @media (max-width: 767px) {
            .sidebar-left { display: none !important; }
            .navbar-top { margin-left: 0 !important; }
            .content-body { padding-bottom: 60px; }
        }

        /* ── Sidebar共通スタイル ── */
        .sidebar-link {
            display: flex; align-items: center; padding: 10px 16px;
            color: #495057; text-decoration: none; transition: background 0.2s; font-size: 0.85rem;
        }
        .sidebar-link:hover, .sidebar-link:active {
            background-color: #edeae4 !important; color: #000;
        }
        .sidebar-link.active {
            background-color: #edeae4; color: #000; font-weight: 600;
        }
        .sidebar-link i {
            margin-right: 12px; font-size: 1.1rem; width: 20px; text-align: center;
        }

        /* ── Spot submenu ── */
        .spot-sub-link {
            display: block; text-decoration: none; color: #6c757d;
            padding: 8px 0 8px 48px; font-size: 0.82rem; transition: background 0.2s, color 0.2s;
        }
        .spot-sub-link:hover, .spot-sub-link:active {
            background-color: #edeae4; color: #000;
        }

        /* ── Premium card ── */
        .card-title {
            font-size: 0.65rem; font-style: italic; font-weight: bolder; border-bottom: darkcyan 1px solid;
        }
        .command a { font-size: 0.85rem; }

        /* ── Mobile topbar ── */
        .mobile-topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 16px; height: 70px;
        }
        .mobile-topbar .logo-img { height: 100px; width: auto; }
        .mobile-topbar-icons { display: flex; align-items: center; gap: 16px; }
        .mobile-topbar-icons > a { color: #495057; font-size: 1.1rem; position: relative; }

        /* ── Bottom Nav ── */
        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; height: 60px;
            background: #fff; border-top: 1px solid #e9ecef; z-index: 1040;
            justify-content: space-around; align-items: center; display: none;
        }
        @media (max-width: 767px) {
            .bottom-nav { display: flex !important; }
            .content-body { padding-bottom: 60px; }
        }
        .bottom-nav-item {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            flex: 1; color: #adb5bd; text-decoration: none; font-size: 0.6rem; gap: 3px;
            padding: 6px 0; transition: color 0.2s;
        }
        .bottom-nav-item i { font-size: 1.2rem; }
        .bottom-nav-item.active, .bottom-nav-item:active { color: darkcyan; }

        /* ── Spot Modal ── */
        @media (min-width: 768px) {
            .spot-modal, .spot-modal-overlay { display: none !important; }
        }
        .spot-modal-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.4); z-index: 2000;
        }
        .spot-modal-overlay.open { display: block; }
        .spot-modal {
            position: fixed; bottom: -400px; left: 0; right: 0; background: #fff;
            border-radius: 16px 16px 0 0; padding: 12px 24px 80px; z-index: 2001;
            transition: bottom 0.3s cubic-bezier(.4, 0, .2, 1);
        }
        .spot-modal.open { bottom: 0; }
        .spot-modal-handle {
            width: 40px; height: 4px; background: #dee2e6; border-radius: 2px; margin: 0 auto 16px;
        }
        .spot-modal-title {
            font-size: 0.75rem; font-weight: bold; color: #adb5bd; letter-spacing: 0.05em; margin-bottom: 8px;
        }
        .spot-modal-item {
            display: flex; align-items: center; gap: 14px; padding: 14px 0;
            font-size: 1rem; color: #495057; text-decoration: none; border-bottom: 1px solid #f1f3f5;
        }
        .spot-modal-item:last-child { border-bottom: none; }
        .spot-modal-item:active { color: darkcyan; }

        /* 🌟 Taka-san追加：観光スポット一覧用CSS */
        html { scroll-behavior: smooth; }
        .spot-card-horizontal {
            background-color: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex; border: 1px solid #eee; overflow: hidden; transition: all 0.2s ease;
            text-decoration: none; color: inherit; cursor: pointer;
        }
        .spot-card-horizontal:hover {
            transform: translateY(-3px); box-shadow: 0 8px 20px rgba(30, 139, 155, 0.15); border-color: #c9d8e4;
        }
        .spot-card-img-area {
            width: 200px; min-height: 150px; background-color: #f4f8fb; flex-shrink: 0; border-right: 1px solid #eee;
        }
        .spot-card-img-area img { width: 100%; height: 100%; object-fit: cover; }
        .spot-card-info {
            padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-width: 0;
        }
        .spot-card-horizontal:hover .spot-title { color: #1e8b9b; }
        .spot-title {
            font-size: 18px; font-weight: bold; color: #333; margin-bottom: 8px; transition: color 0.2s;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .spot-desc { font-size: 13px; color: #666; margin-bottom: 15px; line-height: 1.5; }
        .spot-tags { display: flex; gap: 10px; font-size: 12px; color: #555; font-weight: bold; flex-wrap: wrap; }
        .tag-item i { color: #1e8b9b; margin-right: 4px; }
        @media (max-width: 768px) {
            .spot-card-horizontal { flex-direction: column; }
            .spot-card-img-area { width: 100%; height: 200px; border-right: none; border-bottom: 1px solid #eee; }
        }
        .game-card{
    cursor:pointer;
    transition:all .25s ease;
}

.game-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 24px rgba(0,0,0,.2) !important;
}
    </style>
</head>

<body>
    <div id="app">
        {{-- ══════════════════════════════════
            PC用 Navbar（md以上）
        ══════════════════════════════════ --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom navbar-top shadow-sm d-none d-md-flex">
            <div class="container-fluid px-4">
                {{-- 🌟 検索バー（Taka-san追加分） --}}
                <form class="mx-auto" style="width: 40%;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input class="form-control bg-light border-0" type="search" placeholder="Search here...">
                    </div>
                </form>

                <ul class="navbar-nav ms-auto align-items-center flex-row gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home') }}"><i class="fa-solid fa-house-chimney fa-lg"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" data-bs-toggle="modal" data-bs-target="#userNotificationsModal" id="notifBellBtnPC">
                            <i class="fa-solid fa-bell fa-lg"></i>
                            @if (($unreadNotificationsCount ?? 0) > 0)
                                <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadgePC">{{ $unreadNotificationsCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-regular fa-envelope fa-lg"></i></a>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- ══════════════════════════════════
            スマホ用 Topbar（md未満）
        ══════════════════════════════════ --}}
        <nav class="navbar-top bg-white border-bottom shadow-sm d-flex d-md-none">
            <div class="mobile-topbar w-100">
                <a href="{{ url('/home') }}">
                    <img src="{{ asset('images/kredon.png') }}" alt="Kredon" class="logo-img">
                </a>
                <div class="mobile-topbar-icons">
                    <a href="#" class="position-relative" data-bs-toggle="modal" data-bs-target="#userNotificationsModal" id="notifBellBtnMobile">
                        <i class="fa-solid fa-bell"></i>
                        @if (($unreadNotificationsCount ?? 0) > 0)
                            <span class="position-absolute badge rounded-pill bg-danger" style="font-size:0.55rem;padding:2px 4px;top:-4px;right:-6px;" id="notifBadgeMobile">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <a href="#"><i class="fa-regular fa-envelope"></i></a>
                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar" style="width:30px;height:30px;border-radius:50%;object-fit:cover;">
                                @else
                                    <span style="display:inline-flex;align-items:center;justify-content:center; width:30px;height:30px;border-radius:50%;background:#212529; color:#fff;font-size:0.75rem;font-weight:bold;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear me-2"></i>Setting</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @if (Auth::user()->role === 1)
                                    <li><a class="dropdown-item fw-bold" href="{{ route('admin.dashboard') }}" style="color: darkcyan;"><i class="fa-solid fa-shield-halved me-2"></i>Admin Page</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fw-bold" href="#" style="color: darkcyan;"><i class="fa-solid fa-crown me-2" style="color:gold;"></i>Premium Member</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- ══════════════════════════════════
            スマホ用 ボトムナビ（md未満）
        ══════════════════════════════════ --}}
        <nav class="bottom-nav">
            <a href="{{ url('/home') }}" class="bottom-nav-item {{ request()->is('home') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i><span>Home</span>
            </a>
            <a href="#" class="bottom-nav-item {{ request()->routeIs('spot.*') ? 'active' : '' }}" onclick="openSpotModal(event)">
                <i class="fa-solid fa-map-location-dot"></i><span>Spot</span>
            </a>
            <a href="{{ route('event.index') }}" class="bottom-nav-item {{ request()->routeIs('event.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i><span>Event</span>
            </a>
            <a href="{{ route('marketplace.index') }}" class="bottom-nav-item {{ request()->routeIs('market.*') ? 'active' : '' }}">
                <i class="fa-solid fa-store"></i><span>Market</span>
            </a>
            <a href="{{ route('all_reviews.index') }}" class="bottom-nav-item {{ request()->routeIs('review.*') ? 'active' : '' }}">
                <i class="fa-regular fa-star"></i><span>Review</span>
            </a>
        </nav>

        {{-- ══════════════════════════════════
            スマホ用 SPOTモーダル
        ══════════════════════════════════ --}}
        <div class="spot-modal-overlay" id="spotModalOverlay" onclick="closeSpotModal()"></div>
        <div class="spot-modal" id="spotModal">
            <div class="spot-modal-handle"></div>
            <p class="spot-modal-title">SPOT</p>
            <a href="{{ route('top') }}" class="spot-modal-item"><i class="fa-solid fa-briefcase"></i> Working</a>
            <a href="{{ route('healthcare.index') }}" class="spot-modal-item"><i class="fa-solid fa-hospital"></i> Hospital</a>
            <a href="{{ route('tourist_spots.index') }}" class="spot-modal-item"><i class="fa-solid fa-camera"></i> Tourism</a>
            <a href="{{ route('mypage') }}" class="spot-modal-item"><i class="fa-regular fa-bookmark"></i> Bookmark</a>
        </div>

        {{-- ══════════════════════════════════
            PC用 左サイドバーとメインコンテンツ（md以上）
        ══════════════════════════════════ --}}
        <div class="main-wrapper">
            <aside class="sidebar-left d-none d-md-block">
                <div class="py-2">
                    <a class="d-block text-center" href="{{ url('/home') }}">
                        <img src="{{ asset('images/kredon.png') }}" alt="Logo" style="height:130px;width:auto;object-fit:contain; margin-bottom: -30px; margin-top: -20px;">
                    </a>
                    <hr class="mx-3 my-2 text-muted">

                    @auth
                        <div class="command">
                            <a href="#" class="sidebar-link {{ request()->routeIs('spot.*') ? 'active' : '' }}" onclick="toggleSpotPC(event)">
                                <i class="fa-solid fa-map-location-dot"></i> SPOT
                                <i class="fa-solid fa-chevron-down ms-auto small" id="spotChevronPC" style="transition:transform 0.2s;"></i>
                            </a>
                            <div id="spotSubmenuPC" style="display:none;">
                                <a href="{{ route('top') }}" class="spot-sub-link">Working</a>
                                <a href="{{ route('healthcare.index') }}" class="spot-sub-link">Hospital</a>
                                <a href="{{ route('tourist_spots.index') }}" class="spot-sub-link">Tourism</a>
                                <a href="{{ route('mypage') }}" class="spot-sub-link">Bookmark</a>
                            </div>

                            <a href="{{ route('event.index') }}" class="sidebar-link {{ request()->routeIs('event.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-calendar-days"></i> EVENT
                            </a>
                            <a href="{{ route('marketplace.index') }}" class="sidebar-link {{ request()->routeIs('market.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-store"></i> MARKET
                            </a>
                            <a href="{{ route('all_reviews.index') }}" class="sidebar-link {{ request()->routeIs('review.*') ? 'active' : '' }}">
                                <i class="fa-regular fa-star"></i> REVIEW
                            </a>

                            <hr class="mx-3 my-2 text-muted">

                            <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-gear"></i> SETTING
                            </a>
                            <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               <i class="fa-solid fa-arrow-right-from-bracket"></i> LOGOUT
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    @endauth

                    {{-- Kredon Premium --}}
                   <hr class="mx-3 my-2 text-muted">

<div class="px-3 mt-4">

    <div class="card shadow-sm game-card"
         style="background:#d9eef7;border-radius:15px;overflow:hidden;">

        {{-- Details以外全部クリック可能 --}}
        <a href="{{ route('game.home') }}"
           class="text-decoration-none text-dark d-block">

          <div class="card-body p-2 text-center">

    <img src="{{ asset('images/game-banner.png') }}"
         class="rounded"
         alt="KREMITI Adventure"
         style="
            width:95%;
            height:auto;
            border-radius:12px;
         ">

</div>

        </a>

        {{-- Detailsボタン --}}
        <div class="px-3 pb-3">

            <a href="{{ route('game.home') }}"
               class="btn btn-light w-100 fw-bold"
               style="color:darkcyan;">

                Begin

            </a>

        </div>

    </div>

</div>

</div>
</aside>

<main class="content-body">
    @yield('content')
    @stack('scripts')
</main>

@include('layouts.notif-modal')

</div>
</div>
    <script>
        // ── ユーザー通知モーダル：開いたら一括既読化 ──
        const userNotifModalEl = document.getElementById('userNotificationsModal');
        if (userNotifModalEl) {
            userNotifModalEl.addEventListener('shown.bs.modal', function () {
                fetch('{{ route("notifications.mark-all-read") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('notifBadgePC')?.remove();
                        document.getElementById('notifBadgeMobile')?.remove();
                        document.querySelectorAll('.notif-item.unread').forEach(el => {
                            el.classList.remove('unread');
                        });
                    }
                })
                .catch(err => console.error('Mark as read failed:', err));
            });
        }

       
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
        const spotModalEl = document.getElementById('spotModal');
        if (spotModalEl) {
            spotModalEl.addEventListener('touchstart', e => {
                touchStartY = e.touches[0].clientY;
            });
            spotModalEl.addEventListener('touchend', e => {
                if (e.changedTouches[0].clientY - touchStartY > 60) closeSpotModal();
            });
        }
    </script>

    @include('healthcare.partials._loader')
</body>
</html>
