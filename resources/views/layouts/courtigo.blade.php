<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Courtigo' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        courtigo: {
                            navy: '#001f3f',
                            blue: '#3B82F6',
                            green: '#22C55E',
                            amber: '#F59E0B',
                            red: '#EF4444'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes soft-float {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes gentle-pulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgb(34 197 94 / 0.28);
            }

            50% {
                box-shadow: 0 0 0 12px rgb(34 197 94 / 0);
            }
        }

        [data-reveal] {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 700ms ease, transform 700ms ease;
        }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-fade-up {
            animation: fade-up 700ms ease both;
        }

        .animate-soft-float {
            animation: soft-float 5s ease-in-out infinite;
        }

        .animate-gentle-pulse {
            animation: gentle-pulse 2.8s ease-in-out infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 1ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: 1ms !important;
            }

            [data-reveal] {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>
<body class="animate-fade-up bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur" data-mobile-nav-root>
        <nav class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded bg-courtigo-navy text-sm font-black text-white">CT</span>
                    <span>
                        <span class="block text-lg font-black tracking-tight text-courtigo-navy">Courtigo</span>
                        <span class="block text-xs font-medium text-slate-500">Pickleball courts for every rally</span>
                    </span>
                </a>
                <div class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
                    <a href="{{ route('home') }}#courts" class="hover:text-courtigo-blue">Courts</a>
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-courtigo-blue">How it works</a>
                    <a href="{{ route('home') }}#why-book" class="hover:text-courtigo-blue">Why Courtigo</a>
                    @auth
                        <a href="{{ route('dashboard.player') }}" class="hover:text-courtigo-blue">My bookings</a>
                    @else
                        <a href="{{ route('home') }}#courts" class="hover:text-courtigo-blue">Find courts</a>
                    @endauth
                </div>
                <div class="hidden md:block">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded bg-courtigo-navy px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-blue-950" type="submit">Logout</button>
                        </form>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="rounded border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-courtigo-navy shadow-sm hover:border-courtigo-blue hover:text-courtigo-blue">Login</a>
                            <a href="{{ route('register') }}" class="rounded bg-courtigo-green px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-green-600">Create account</a>
                        </div>
                    @endauth
                </div>
                <button class="grid h-11 w-11 place-items-center rounded border border-slate-200 bg-white text-courtigo-navy shadow-sm md:hidden" type="button" data-mobile-nav-toggle aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu">
                    <span class="relative h-4 w-5" aria-hidden="true">
                        <span class="absolute left-0 top-0 h-0.5 w-5 rounded bg-current transition duration-200" data-mobile-nav-line-top></span>
                        <span class="absolute left-0 top-1/2 h-0.5 w-5 -translate-y-1/2 rounded bg-current transition duration-200" data-mobile-nav-line-middle></span>
                        <span class="absolute bottom-0 left-0 h-0.5 w-5 rounded bg-current transition duration-200" data-mobile-nav-line-bottom></span>
                    </span>
                </button>
            </div>

            <div id="mobile-menu" class="grid max-h-0 overflow-hidden opacity-0 transition-all duration-300 ease-out md:hidden" data-mobile-nav-menu>
                <div class="mt-3 rounded border border-slate-200 bg-white p-3 shadow-xl shadow-slate-950/10">
                    <div class="space-y-1">
                        <a href="{{ route('home') }}#courts" class="flex items-center justify-between rounded px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-courtigo-blue">
                            Courts
                            <span class="text-slate-300">›</span>
                        </a>
                        <a href="{{ route('home') }}#how-it-works" class="flex items-center justify-between rounded px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-courtigo-blue">
                            How it works
                            <span class="text-slate-300">›</span>
                        </a>
                        <a href="{{ route('home') }}#why-book" class="flex items-center justify-between rounded px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-courtigo-blue">
                            Why Courtigo
                            <span class="text-slate-300">›</span>
                        </a>
                    </div>
                    @auth
                        <div class="mt-2 border-t border-slate-100 pt-2">
                            <a href="{{ route('dashboard.player') }}" class="flex items-center justify-between rounded px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-courtigo-blue">
                                My bookings
                                <span class="text-slate-300">›</span>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button class="w-full rounded bg-courtigo-navy px-4 py-3 text-sm font-black text-white shadow-sm hover:bg-blue-950" type="submit">Logout</button>
                        </form>
                    @else
                        <div class="mt-3 border-t border-slate-100 pt-3">
                            <a href="{{ route('home') }}#courts" class="block rounded bg-courtigo-green px-4 py-3 text-center text-sm font-black text-white shadow-sm hover:bg-green-600">Find courts</a>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <a href="{{ route('login') }}" class="rounded border border-slate-200 px-4 py-2.5 text-center text-sm font-black text-courtigo-navy hover:border-courtigo-blue hover:text-courtigo-blue">Login</a>
                                <a href="{{ route('register') }}" class="rounded border border-slate-200 px-4 py-2.5 text-center text-sm font-black text-courtigo-navy hover:border-courtigo-blue hover:text-courtigo-blue">Create account</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-8 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
            <p>© {{ date('Y') }} Courtigo. Pickleball court reservations for players.</p>
        </div>
    </footer>

    @stack('scripts')
    <script>
        (() => {
            const root = document.querySelector('[data-mobile-nav-root]');
            const toggle = document.querySelector('[data-mobile-nav-toggle]');
            const menu = document.querySelector('[data-mobile-nav-menu]');
            const topLine = document.querySelector('[data-mobile-nav-line-top]');
            const middleLine = document.querySelector('[data-mobile-nav-line-middle]');
            const bottomLine = document.querySelector('[data-mobile-nav-line-bottom]');

            if (!root || !toggle || !menu) {
                return;
            }

            const setOpen = (isOpen) => {
                toggle.setAttribute('aria-expanded', String(isOpen));
                menu.classList.toggle('max-h-0', !isOpen);
                menu.classList.toggle('opacity-0', !isOpen);
                menu.classList.toggle('max-h-[420px]', isOpen);
                menu.classList.toggle('opacity-100', isOpen);
                topLine?.classList.toggle('translate-y-[7px]', isOpen);
                topLine?.classList.toggle('rotate-45', isOpen);
                middleLine?.classList.toggle('opacity-0', isOpen);
                bottomLine?.classList.toggle('-translate-y-[7px]', isOpen);
                bottomLine?.classList.toggle('-rotate-45', isOpen);
            };

            toggle.addEventListener('click', () => {
                setOpen(toggle.getAttribute('aria-expanded') !== 'true');
            });

            menu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => setOpen(false));
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    setOpen(false);
                }
            });
        })();
    </script>
    <script>
        (() => {
            const revealItems = document.querySelectorAll('[data-reveal]');

            if (!revealItems.length || !('IntersectionObserver' in window)) {
                revealItems.forEach((item) => item.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.14,
            });

            revealItems.forEach((item, index) => {
                item.style.transitionDelay = `${Math.min(index * 80, 320)}ms`;
                observer.observe(item);
            });
        })();
    </script>
</body>
</html>
