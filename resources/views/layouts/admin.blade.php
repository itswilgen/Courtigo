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
            --admin-bg: #f4f7fb;
            --admin-panel: #ffffff;
            --admin-border: #dde5ef;
            --admin-sidebar: #0b1220;
            --admin-sidebar-soft: #121b2d;
            --admin-text: #182230;
            --admin-muted: #667085;
            --admin-accent: #16a34a;
            --admin-blue: #2563eb;
        }

        body {
            min-height: 100vh;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-shell {
            min-height: 100vh;
            background:
                linear-gradient(180deg, rgba(37, 99, 235, .06), rgba(37, 99, 235, 0) 260px),
                var(--admin-bg);
        }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1040;
            display: flex;
            width: 280px;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, .08);
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
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .brand-mark {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--admin-accent), #22c55e);
            color: #052e16;
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
            color: #b9c6d8;
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
            background: var(--admin-sidebar-soft);
            color: #ffffff;
        }

        .admin-nav-link.active {
            box-shadow: inset 3px 0 0 var(--admin-accent);
        }

        .admin-nav-link i,
        .admin-logout-button i {
            width: 1.25rem;
            flex: 0 0 1.25rem;
            text-align: center;
        }

        .admin-sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, .08);
            padding: 1rem;
        }

        .sidebar-helper {
            background: rgba(34, 197, 94, .1);
            border: 1px solid rgba(34, 197, 94, .18);
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
            padding: 1.5rem;
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
            background: #e8f7ee;
            color: #166534;
            font-weight: 900;
        }

        .content-card,
        .admin-card {
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            background: var(--admin-panel);
            box-shadow: 0 16px 36px rgba(15, 23, 42, .06);
        }

        .metric-card {
            position: relative;
            overflow: hidden;
            min-height: 146px;
        }

        .metric-card::after {
            position: absolute;
            right: -36px;
            bottom: -44px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(37, 99, 235, .09);
            content: "";
        }

        .metric-icon {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 8px;
            background: #eef4ff;
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

        .admin-table thead th {
            color: var(--admin-muted);
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
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
