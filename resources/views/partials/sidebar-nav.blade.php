@php
    $user = auth()->user();
@endphp
<aside class="sidebar" id="sidebar" aria-label="القائمة الرئيسية" aria-hidden="true">
    <div class="sidebar-header">
        <button type="button" class="sidebar-close" id="sidebarClose" aria-label="إغلاق القائمة">&times;</button>
        <a href="{{ route('dashboard') }}" class="admin-nav-brand sidebar-brand">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" class="admin-nav-logo" onerror="this.src='https://via.placeholder.com/40?text=Logo';">
            <span>THE EAGLE ACADEMY</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}">
            <span class="sidebar-link-icon" aria-hidden="true">📊</span>
            <span>لوحة التحكم</span>
        </a>

        <a href="{{ route('players.create') }}"
           class="sidebar-link {{ request()->routeIs('players.create') ? 'sidebar-link--active' : '' }}">
            <span class="sidebar-link-icon" aria-hidden="true">➕</span>
            <span>تسجيل لاعب</span>
        </a>

        <a href="{{ route('players.list') }}"
           class="sidebar-link {{ request()->routeIs('players.list') ? 'sidebar-link--active' : '' }}">
            <span class="sidebar-link-icon" aria-hidden="true">📋</span>
            <span>سجل اللاعبين</span>
        </a>

        <a href="{{ route('subscriptions.history') }}"
           class="sidebar-link {{ request()->routeIs('subscriptions.history') ? 'sidebar-link--active' : '' }}">
            <span class="sidebar-link-icon" aria-hidden="true">📅</span>
            <span>سجل الاشتراكات</span>
        </a>

        <a href="{{ route('reminders.index') }}"
           class="sidebar-link {{ request()->routeIs('reminders.*') ? 'sidebar-link--active' : '' }}">
            <span class="sidebar-link-icon" aria-hidden="true">📲</span>
            <span>تنبيهات الاشتراكات</span>
            @if (($pendingRemindersCount ?? 0) > 0)
                <span class="sidebar-badge">{{ $pendingRemindersCount }}</span>
            @endif
        </a>

        <a href="{{ route('heroes.wall') }}"
           class="sidebar-link sidebar-link--gold {{ request()->routeIs('heroes.wall') ? 'sidebar-link--active' : '' }}">
            <span class="sidebar-link-icon" aria-hidden="true">🏆</span>
            <span>حائط الأبطال</span>
        </a>

        <a href="{{ route('reports.index') }}"
           class="sidebar-link {{ request()->routeIs('reports.index') ? 'sidebar-link--active' : '' }}">
            <span class="sidebar-link-icon" aria-hidden="true">📈</span>
            <span>التقارير</span>
        </a>
    </nav>

    <div class="sidebar-footer user-profile">
        <div class="sidebar-user-name">{{ $user->name }}</div>
        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
            @csrf
            <button type="submit" class="sidebar-logout-btn">تسجيل الخروج</button>
        </form>
    </div>
</aside>
