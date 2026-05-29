@php
    $adminUser = auth()->user();
    $adminNavItems = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'bi-speedometer2'],
        ['label' => 'Users', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'bi-people'],
        ['label' => 'Courts', 'route' => 'admin.courts.index', 'active' => 'admin.courts.*', 'icon' => 'bi-grid-3x3-gap'],
        ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'active' => 'admin.bookings.*', 'icon' => 'bi-calendar-check'],
        ['label' => 'Reports', 'route' => 'admin.reports.index', 'active' => 'admin.reports.*', 'icon' => 'bi-flag'],
        ['label' => 'Settings', 'route' => 'admin.settings', 'active' => 'admin.settings', 'icon' => 'bi-sliders'],
    ];
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - COURTIGO Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-bg: #f6f8fb;
            --admin-panel: #ffffff;
            --admin-border: #e3e8ef;
            --admin-border-strong: #cbd5e1;
            --admin-sidebar: #101828;
            --admin-sidebar-soft: #1d2939;
            --admin-sidebar-active: #263244;
            --admin-text: #101828;
            --admin-muted: #667085;
            --admin-accent: #0f766e;
            --admin-accent-soft: #e6f4f1;
            --admin-blue: #1d4ed8;
            --admin-warning: #b45309;
            --admin-danger: #b42318;
            --admin-radius: 8px;
            --admin-shadow: 0 12px 28px rgba(16, 24, 40, .06);
        }

        body {
            min-height: 100vh;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-shell {
            min-height: 100vh;
            background: var(--admin-bg);
        }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1040;
            display: flex;
            width: 280px;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, .1);
            background: var(--admin-sidebar);
            color: #e5edf7;
            transition: width .2s ease, transform .2s ease;
        }

        .admin-sidebar-brand {
            display: flex;
            min-height: 74px;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .brand-mark {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 8px;
            background: #ffffff;
            color: var(--admin-sidebar);
            font-weight: 900;
            letter-spacing: .02em;
        }

        .admin-nav {
            display: grid;
            gap: .35rem;
            padding: 1rem;
        }

        .admin-nav-link,
        .admin-logout-button {
            display: flex;
            width: 100%;
            align-items: center;
            gap: .8rem;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #cbd5e1;
            padding: .78rem .9rem;
            font-size: .94rem;
            font-weight: 700;
            text-align: left;
            text-decoration: none;
            transition: background .15s ease, color .15s ease;
        }

        .admin-nav-link:hover,
        .admin-logout-button:hover,
        .admin-nav-link.active {
            background: var(--admin-sidebar-active);
            color: #ffffff;
        }

        .admin-nav-link.active {
            box-shadow: inset 3px 0 0 #14b8a6;
        }

        .admin-nav-link i,
        .admin-logout-button i {
            width: 1.25rem;
            flex: 0 0 1.25rem;
            text-align: center;
        }

        .admin-sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, .1);
            padding: 1rem;
        }

        .sidebar-helper {
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
        }

        .admin-main {
            min-height: 100vh;
            padding-left: 280px;
            transition: padding-left .2s ease;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            min-height: 74px;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border-bottom: 1px solid var(--admin-border);
            background: rgba(255, 255, 255, .94);
            padding: .9rem 1.5rem;
            backdrop-filter: blur(16px);
        }

        .admin-content {
            padding: 1.5rem 1.5rem 2rem;
        }

        .admin-breadcrumb {
            display: flex;
            align-items: center;
            gap: .45rem;
            color: var(--admin-muted);
            font-size: .76rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .admin-breadcrumb a {
            color: var(--admin-blue);
            text-decoration: none;
        }

        .admin-kicker {
            color: var(--admin-muted);
            font-size: .76rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .fw-black {
            font-weight: 900;
        }

        .admin-icon-button {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            background: #fff;
            color: #344054;
            transition: border-color .15s ease, box-shadow .15s ease, color .15s ease;
        }

        .admin-icon-button:hover {
            border-color: var(--admin-border-strong);
            box-shadow: 0 8px 18px rgba(16, 24, 40, .08);
            color: var(--admin-text);
        }

        .admin-profile-button {
            display: flex;
            align-items: center;
            gap: .7rem;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            background: #fff;
            padding: .45rem .55rem .45rem .45rem;
            color: var(--admin-text);
        }

        .admin-avatar {
            display: grid;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            place-items: center;
            border-radius: 8px;
            background: var(--admin-accent-soft);
            color: var(--admin-accent);
            font-weight: 900;
        }

        .content-card,
        .admin-card {
            border: 1px solid var(--admin-border);
            border-radius: var(--admin-radius);
            background: var(--admin-panel);
            box-shadow: var(--admin-shadow);
        }

        .metric-card {
            position: relative;
            overflow: hidden;
            min-height: 146px;
        }

        .metric-icon {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 8px;
            background: #eff6ff;
            color: var(--admin-blue);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: .28rem .65rem;
            font-size: .74rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .status-pill.is-success {
            background: #ecfdf3;
            color: #067647;
        }

        .status-pill.is-warning {
            background: #fffaeb;
            color: var(--admin-warning);
        }

        .status-pill.is-danger {
            background: #fef3f2;
            color: var(--admin-danger);
        }

        .status-pill.is-neutral {
            background: #f2f4f7;
            color: #475467;
        }

        .admin-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .admin-filter-bar {
            border-bottom: 1px solid var(--admin-border);
            background: #fbfcfe;
            padding: 1rem;
        }

        .admin-table {
            margin-bottom: 0;
        }

        .admin-table > :not(caption) > * > * {
            padding: 1rem;
            border-bottom-color: var(--admin-border);
        }

        .admin-table thead th {
            color: var(--admin-muted);
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            background: #f8fafc;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table tbody tr:hover {
            background: #fbfcfe;
        }

        .admin-table a {
            color: var(--admin-text);
            font-weight: 800;
            text-decoration: none;
        }

        .admin-table a:hover {
            color: var(--admin-blue);
        }

        .admin-empty-state {
            display: grid;
            place-items: center;
            min-height: 180px;
            color: var(--admin-muted);
            text-align: center;
        }

        .btn {
            border-radius: 8px;
            font-weight: 700;
        }

        .btn-primary {
            --bs-btn-bg: #1d4ed8;
            --bs-btn-border-color: #1d4ed8;
            --bs-btn-hover-bg: #1e40af;
            --bs-btn-hover-border-color: #1e40af;
        }

        .btn-success {
            --bs-btn-bg: var(--admin-accent);
            --bs-btn-border-color: var(--admin-accent);
            --bs-btn-hover-bg: #115e59;
            --bs-btn-hover-border-color: #115e59;
        }

        .form-control,
        .form-select {
            border-color: var(--admin-border);
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #94a3b8;
            box-shadow: 0 0 0 .2rem rgba(15, 118, 110, .12);
        }

        .pagination {
            margin: 1rem;
            margin-bottom: 0;
        }

        .admin-shell.is-collapsed .admin-sidebar {
            width: 88px;
        }

        .admin-shell.is-collapsed .admin-main {
            padding-left: 88px;
        }

        .admin-shell.is-collapsed .admin-sidebar .nav-label,
        .admin-shell.is-collapsed .admin-sidebar .brand-copy,
        .admin-shell.is-collapsed .admin-sidebar .sidebar-helper {
            display: none;
        }

        .admin-shell.is-collapsed .admin-nav-link,
        .admin-shell.is-collapsed .admin-logout-button {
            justify-content: center;
        }

        .admin-overlay {
            display: none;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-shell.is-mobile-open .admin-sidebar {
                transform: translateX(0);
            }

            .admin-main,
            .admin-shell.is-collapsed .admin-main {
                padding-left: 0;
            }

            .admin-overlay {
                position: fixed;
                inset: 0;
                z-index: 1030;
                display: none;
                background: rgba(15, 23, 42, .48);
            }

            .admin-shell.is-mobile-open .admin-overlay {
                display: block;
            }

            .admin-content,
            .admin-topbar {
                padding-inline: 1rem;
            }

            .admin-page-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="admin-shell" data-admin-shell>
    <div class="admin-overlay" data-admin-overlay></div>

    @include('admin.components.sidebar')

    <main class="admin-main">
        @include('admin.components.navbar')

        <div class="admin-content">
            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        const shell = document.querySelector('[data-admin-shell]');
        const toggle = document.querySelector('[data-sidebar-toggle]');
        const overlay = document.querySelector('[data-admin-overlay]');

        if (!shell || !toggle) {
            return;
        }

        const isDesktop = () => window.matchMedia('(min-width: 992px)').matches;
        const closeMobile = () => shell.classList.remove('is-mobile-open');

        toggle.addEventListener('click', () => {
            if (isDesktop()) {
                shell.classList.toggle('is-collapsed');
                return;
            }

            shell.classList.toggle('is-mobile-open');
        });

        overlay?.addEventListener('click', closeMobile);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMobile();
            }
        });

        window.addEventListener('resize', () => {
            if (isDesktop()) {
                closeMobile();
            }
        });
    })();
</script>
@stack('scripts')
</body>
</html>
