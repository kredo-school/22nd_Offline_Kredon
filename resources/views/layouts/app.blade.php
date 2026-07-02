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
        /* レイアウト固定用 */
        html, body, #app { background-color: #f8f9fa; min-height: 100vh; }
        .navbar-top { position: fixed; top: 0; left: 0; right: 0; z-index: 1060; height: 70px; margin-left: 0px; }
        .main-wrapper { display: flex; flex-direction: column; margin-top: 70px; padding-top: 0; min-height: calc(100vh - 70px); }
        .sidebar-left { width: 200px; position: fixed; top: 0; bottom: 0; left: 0; z-index: 1030; overflow-y: auto; overflow-x: hidden; background-color: #f7f5f0; border-right: 1px solid #e9ecef; }
        .content-body { flex: 1; margin-left: 0; }

        /* Desktop */
        @media (min-width: 768px) {
            html, body, #app { height: 100vh; overflow: hidden; }
            .navbar-top { margin-left: 200px; }
            .main-wrapper { flex-direction: row; height: calc(100vh - 70px); margin-top: 70px; }
            .content-body { margin-left: 200px; height: calc(100vh - 70px); overflow-y: auto; background-color: #f8f9fa; padding-bottom: 50px; }
        }

        /* サイドバー内のメニュー装飾 */
        .sidebar-link { display: flex; align-items: center; padding: 10px 16px; color: #495057; text-decoration: none; transition: background 0.2s; }
        .sidebar-left .accordion-item { background-color: #f7f5f0 !important; font-size: 0.85rem; padding: 10px 16px; }
        .sidebar-link:hover, .sidebar-left .accordion-button:not(.collapsed) { background-color: #edeae4 !important; color: #000; }
        #spotSubmenu a:hover { background-color: #edeae4; color: #000 !important; }
        .sidebar-link i { margin-right: 12px; font-size: 1.2rem; }
        .card-title { font-size: 0.65rem; font-style: italic; font-weight: bolder; border-bottom: darkcyan 1px solid; }
        .command a { font-size: 0.8rem; }
        html { scroll-behavior: smooth; }
        .spot-card-horizontal { background-color: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); display: flex; border: 1px solid #eee; overflow: hidden; transition: all 0.2s ease; text-decoration: none; color: inherit; cursor: pointer; }
        .spot-card-horizontal:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(30, 139, 155, 0.15); border-color: #c9d8e4; }
        .spot-card-img-area { width: 200px; min-height: 150px; background-color: #f4f8fb; flex-shrink: 0; border-right: 1px solid #eee; }
        .spot-card-img-area img { width: 100%; height: 100%; object-fit: cover; }
        .spot-card-info { padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-width: 0; }
        .spot-card-horizontal:hover .spot-title { color: #1e8b9b; }
        .spot-title { font-size: 18px; font-weight: bold; color: #333; margin-bottom: 8px; transition: color 0.2s; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .spot-desc { font-size: 13px; color: #666; margin-bottom: 15px; line-height: 1.5; }
        .spot-tags { display: flex; gap: 10px; font-size: 12px; color: #555; font-weight: bold; flex-wrap: wrap; }
        .tag-item i { color: #1e8b9b; margin-right: 4px; }

        @media (max-width: 768px) {
            .spot-card-horizontal { flex-direction: column; }
            .spot-card-img-area { width: 100%; height: 200px; border-right: none; border-bottom: 1px solid #eee; }
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- Desktop Topbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom navbar-top sticky-top shadow-sm d-none d-md-flex">
            <div class="container-fluid px-4">
                {{-- 検索 --}}
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
                    <div class="vr mx-3"></div>
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar" style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                                @else
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: #212529; color: #fff; font-size: 0.8rem; font-weight: bold; flex-shrink: 0;">
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

        {{-- スマホ用 Topbar --}}
        <nav class="navbar-top bg-white border-bottom shadow-sm d-flex d-md-none align-items-center px-3 justify-content-between">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('images/kredon.png') }}" alt="Kredon" style="height: 40px;">
            </a>
            <div class="d-flex align-items-center gap-3">
                 <a href="#" class="position-relative text-dark" data-bs-toggle="modal" data-bs-target="#userNotificationsModal" id="notifBellBtnMobile">
                    <i class="fa-solid fa-bell fa-lg"></i>
                    @if (($unreadNotificationsCount ?? 0) > 0)
                        <span class="position-absolute badge rounded-pill bg-danger" style="font-size:0.55rem;padding:2px 4px;top:-4px;right:-6px;" id="notifBadgeMobile">{{ $unreadNotificationsCount }}</span>
                    @endif
                </a>
                <a href="#" class="text-dark"><i class="fa-regular fa-envelope fa-lg"></i></a>
                @auth
                    <a href="#" class="d-flex align-items-center text-dark" data-bs-toggle="dropdown">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar" style="width:30px;height:30px;border-radius:50%;object-fit:cover;">
                        @else
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:50%;background:#212529;color:#fff;font-size:0.75rem;font-weight:bold;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif
                    </a>
                @endauth
            </div>
        </nav>

        <div class="main-wrapper">
            <aside class="sidebar-left d-none d-md-block">
                <div class="py-2">
                    <a class="d-block text-center" href="{{ url('/') }}">
                        <img src="{{ asset('images/kredon.png') }}" alt="Logo" style="height:130px;width:auto;object-fit:contain; margin-bottom: -30px; margin-top: -20px;">
                    </a>

                    <div class="command mt-3">
                        <a href="#" class="sidebar-link" id="spotToggle" onclick="toggleSpot(event)">
                            <i class="fa-solid fa-map-location-dot"></i> SPOT
                            <i class="fa-solid fa-chevron-down ms-auto small" id="spotChevron" style="transition: transform 0.2s;"></i>
                        </a>
                        <div id="spotSubmenu" style="display:none;" class="accordion-item">
                            <a href="{{ url('/') }}" class="d-block text-decoration-none text-muted py-2 ps-5" style="font-size:0.82rem; color: #6c757d;">Working</a>
<a href="#" class="d-block text-decoration-none text-muted py-2 ps-5" style="font-size:0.82rem; color: #6c757d;">Hospital</a>
<a href="{{ url('/tourist') }}" class="d-block text-decoration-none text-muted py-2 ps-5" style="font-size:0.82rem; color: #6c757d;">Tourism</a>
                        </div>

                        <script>
                            function toggleSpot(e) {
                                e.preventDefault();
                                const menu = document.getElementById('spotSubmenu');
                                const chevron = document.getElementById('spotChevron');
                                const isOpen = menu.style.display === 'block';
                                menu.style.display = isOpen ? 'none' : 'block';
                                chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                            }
                        </script>

                        <a href="#" class="sidebar-link"><i class="fa-solid fa-calendar-days"></i> EVENT</a>
                        <a href="#" class="sidebar-link"><i class="fa-solid fa-store"></i> MARKET</a>
                        @auth
                            <a href="{{ route('mypage') }}" class="sidebar-link"><i class="fa-regular fa-bookmark"></i> BOOKMARK</a>
                            <a href="{{ route('mypage') }}" class="sidebar-link"><i class="fa-regular fa-star"></i> REVIEW</a>
                            <hr class="mx-3 my-2 text-muted">
                            <a href="{{ route('mypage') }}" class="sidebar-link"><i class="fa-regular fa-user"></i> MY PAGE</a>
                            <a href="#" class="sidebar-link"><i class="fa-solid fa-gear"></i> SETTING</a>
                            <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> LOGOUT
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endauth
                    </div>

                    <hr class="mx-3 my-2 text-muted">
                    
                    <div class="px-3 mt-4">
                        <div class="card shadow-sm" style="background-color: rgb(218, 238, 246); border-radius: 12px;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-crown" style="color: gold;"></i>
                                    <h6 class="card-title fw-bold m-0" style="color: darkcyan; font-size: 1.4;">KREDON PREMIUM</h6>
                                </div>
                                <p class="card-text text-muted mb-3" style="font-size: 0.8rem; line-height: 1.4;">
                                    Update to Premium to enjoy exclusive events, advanced filters, and unlimited gameplay!
                                </p>
                                <a href="#" class="btn btn-light btn-sm w-100" style="color: darkcyan;">Details</a>
                            </div>
                        </div>
                    </div>

                </div>
            </aside>

            <main class="content-body">
                @yield('content')
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
    </script>
</body>
</html>