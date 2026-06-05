{{-- ロゴエリア --}}
<div class="admin-logo-area">
   <img src="{{ asset('images/kredon.png') }}" alt="kredon logo" class="admin-logo">
    <span class="admin-badge">Admin</span>
</div>

{{-- ナビゲーションメニュー --}}
<div class="admin-nav">
    {{-- <div class="admin-nav-section">
        <span class="admin-nav-section-label">Main Menu</span>
    </div> --}}

    {{-- ダッシュボード --}}
    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link mt-3">
        <i class="fa-solid fa-chart-pie"></i> Dashboard
    </a>

    {{-- 今後管理する内容のメニュー（仮） --}}
    <a href="{{ route('admin.users.index') }}" class="admin-nav-link">
        <i class="fa-solid fa-users"></i> Users
    </a>

    <a href="#" class="admin-nav-link">
        <i class="fa-solid fa-location-dot"></i> Locations
    </a>

    <a href="#" class="admin-nav-link">
        <i class="fa-solid fa-calendar-days"></i> Events
    </a>

    <a href="#" class="admin-nav-link">
        <i class="fa-solid fa-shop"></i> Markets
    </a>

    <a href="#" class="admin-nav-link">
        <i class="fa-solid fa-comments"></i> Comments & Reviews
    </a>

    <a href="#" class="admin-nav-link">
        <i class="fa-solid fa-chart-line"></i> Analysis
    </a>
</div>

{{-- サイドバーフッター（管理者情報） --}}
<div class="admin-sidebar-footer">
    <div class="admin-info">
        <div class="admin-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
        <div>
            <div class="admin-name">{{ Auth::user()->name ?? 'Admin User' }}</div>
            <div class="admin-role">Administrator</div>
        </div>
    </div>
</div>