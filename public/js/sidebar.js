(function () {
    'use strict';

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');

    if (!sidebar || !overlay || !toggle) {
        return;
    }

    const DESKTOP_BREAKPOINT = 1024;

    function isDesktop() {
        return window.innerWidth >= DESKTOP_BREAKPOINT;
    }

    function setOpen(open) {
        if (isDesktop()) {
            return;
        }

        sidebar.classList.toggle('is-open', open);
        overlay.hidden = !open;
        document.body.classList.toggle('sidebar-open', open);
        toggle.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        sidebar.setAttribute('aria-hidden', open ? 'false' : 'true');
    }

    function openSidebar() {
        setOpen(true);
    }

    function closeSidebar() {
        setOpen(false);
    }

    toggle.addEventListener('click', function () {
        if (sidebar.classList.contains('is-open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    sidebar.querySelectorAll('.sidebar-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!isDesktop()) {
                closeSidebar();
            }
        });
    });

    window.addEventListener('resize', function () {
        if (isDesktop()) {
            sidebar.classList.remove('is-open');
            overlay.hidden = true;
            document.body.classList.remove('sidebar-open');
            toggle.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            sidebar.setAttribute('aria-hidden', 'false');
        } else {
            sidebar.setAttribute('aria-hidden', sidebar.classList.contains('is-open') ? 'false' : 'true');
        }
    });

    if (isDesktop()) {
        sidebar.setAttribute('aria-hidden', 'false');
    }

    const adminNav = document.getElementById('adminNav');
    if (adminNav && !isDesktop()) {
        window.addEventListener('scroll', function () {
            adminNav.classList.toggle('scrolled', window.scrollY > 20);
        }, { passive: true });
    }
})();
