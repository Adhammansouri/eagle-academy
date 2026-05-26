<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | The Eagle Academy</title>
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
    @stack('head_scripts')
</head>
<body class="dashboard-body app-shell">

    @include('partials.sidebar-nav')

    <div class="sidebar-overlay" id="sidebarOverlay" hidden></div>

    <div class="app-main">
        <header class="app-header admin-navbar" id="adminNav">
            <a href="{{ route('dashboard') }}" class="admin-nav-brand">
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="admin-nav-logo" onerror="this.src='https://via.placeholder.com/40?text=Logo';">
                <span>THE EAGLE ACADEMY</span>
            </a>
            <button type="button"
                    class="nav-hamburger sidebar-toggle"
                    id="sidebarToggle"
                    aria-expanded="false"
                    aria-controls="sidebar"
                    aria-label="فتح القائمة">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </header>

        <div class="app-content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    @stack('scripts')
</body>
</html>
