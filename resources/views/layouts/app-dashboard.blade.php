<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard | Courtigo' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        courtigo: {
                            navy: '#001f3f',
                            blue: '#2563eb',
                            green: '#16a34a',
                            ink: '#0f172a',
                        }
                    },
                    boxShadow: {
                        soft: '0 18px 55px rgb(15 23 42 / 0.08)'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="min-h-screen" data-dashboard-shell>
        <x-dashboard.sidebar />

        <div class="min-h-screen lg:pl-72">
            <x-dashboard.navbar />

            <main class="mx-auto w-full max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800 shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        (() => {
            const shell = document.querySelector('[data-dashboard-shell]');
            if (!shell) return;

            const sidebar = shell.querySelector('[data-dashboard-sidebar]');
            const overlay = shell.querySelector('[data-sidebar-overlay]');
            const openButtons = shell.querySelectorAll('[data-sidebar-open]');
            const closeButtons = shell.querySelectorAll('[data-sidebar-close]');
            const profileRoot = shell.querySelector('[data-profile-menu]');
            const profileButton = shell.querySelector('[data-profile-button]');
            const profilePanel = shell.querySelector('[data-profile-panel]');

            const setSidebarOpen = (isOpen) => {
                sidebar?.classList.toggle('-translate-x-full', !isOpen);
                overlay?.classList.toggle('hidden', !isOpen);
                document.body.classList.toggle('overflow-hidden', isOpen);
            };

            openButtons.forEach((button) => button.addEventListener('click', () => setSidebarOpen(true)));
            closeButtons.forEach((button) => button.addEventListener('click', () => setSidebarOpen(false)));
            overlay?.addEventListener('click', () => setSidebarOpen(false));

            const setProfileOpen = (isOpen) => {
                profileButton?.setAttribute('aria-expanded', String(isOpen));
                profilePanel?.classList.toggle('hidden', !isOpen);
            };

            profileButton?.addEventListener('click', (event) => {
                event.stopPropagation();
                setProfileOpen(profileButton.getAttribute('aria-expanded') !== 'true');
            });

            document.addEventListener('click', (event) => {
                if (profileRoot && !profileRoot.contains(event.target)) {
                    setProfileOpen(false);
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    setSidebarOpen(false);
                    setProfileOpen(false);
                }
            });
        })();
    </script>
</body>
</html>
