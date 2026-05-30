<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Courtigo' }}</title>
    <script src="{{ asset('js/tailwind-courtigo-config.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .page-progress {
            transform-origin: left;
            transform: scaleX(0);
        }

        .nav-link {
            border-radius: 8px;
            padding: .55rem .75rem;
            transition: background-color 180ms ease, color 180ms ease;
        }

        .nav-link.is-active {
            background: rgb(255 255 255 / .14);
            color: #ffffff;
        }

        .account-menu[open] summary {
            border-color: rgb(255 255 255 / .32);
            box-shadow: 0 10px 24px rgb(15 23 42 / .08);
        }

        .quick-top {
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px);
            transition: opacity 180ms ease, transform 180ms ease;
        }

        .quick-top.is-visible {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .hero-visual {
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        .hero-visual > * {
            position: relative;
            z-index: 1;
        }

        .hero-visual::before {
            position: absolute;
            inset: 0;
            z-index: -2;
            background-position: center;
            background-size: cover;
            content: "";
        }

        .hero-visual::after {
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(90deg, rgb(255 255 255 / .96), rgb(255 255 255 / .82) 48%, rgb(255 255 255 / .6)),
                radial-gradient(circle at 18% 18%, rgb(34 197 94 / .14), transparent 28%),
                radial-gradient(circle at 82% 12%, rgb(59 130 246 / .14), transparent 24%);
            content: "";
        }

        .hero-bg-rally::before {
            background-image: url("https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1800&q=80");
        }

        .hero-bg-court::before {
            background-image: url("https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1800&q=80");
        }

        .hero-bg-auth::before {
            background-image: url("https://images.unsplash.com/photo-1595435742656-5272d0b3fa82?auto=format&fit=crop&w=1800&q=80");
        }

        .hero-bg-vendor::before {
            background-image: url("https://images.unsplash.com/photo-1526232761682-d26e03ac148e?auto=format&fit=crop&w=1800&q=80");
        }

        .hero-bg-payment::before {
            background-image: url("https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1800&q=80");
        }

        .hero-bg-payment::after {
            background:
                linear-gradient(180deg, rgb(15 23 42 / .94), rgb(17 24 39 / .9) 58%, #f8fafc 58%, #f8fafc 100%),
                radial-gradient(circle at 20% 10%, rgb(34 197 94 / .24), transparent 30%),
                radial-gradient(circle at 88% 8%, rgb(59 130 246 / .18), transparent 28%);
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
    <div class="fixed inset-x-0 top-0 z-50 h-1 bg-transparent">
        <div class="page-progress h-full bg-courtigo-green" data-page-progress></div>
    </div>

    <header class="sticky top-0 z-40 border-b border-white/10 bg-[#001f3f] text-white backdrop-blur transition-shadow" data-mobile-nav-root data-site-header>
        <nav class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded bg-white text-sm font-black text-[#001f3f]">CT</span>
                    <span>
                        <span class="block text-lg font-black tracking-tight text-white">Courtigo</span>
                        <span class="block text-xs font-medium text-white/60">Pickleball courts for every rally</span>
                    </span>
                </a>
                <div class="hidden items-center gap-6 text-sm font-semibold text-white md:flex">
                    <a href="{{ route('home') }}#courts" class="nav-link text-white hover:bg-white/10 hover:text-white" data-nav-link="courts">Courts</a>
                    <a href="{{ route('home') }}#how-it-works" class="nav-link text-white hover:bg-white/10 hover:text-white" data-nav-link="how-it-works">How it works</a>
                    <a href="{{ route('home') }}#why-book" class="nav-link text-white hover:bg-white/10 hover:text-white" data-nav-link="why-book">Why Courtigo</a>
                    @auth
                        <a href="{{ route('dashboard.player') }}" class="nav-link text-white {{ request()->routeIs('dashboard.player') ? 'is-active' : '' }} hover:bg-white/10 hover:text-white">My bookings</a>
                    @else
                        <a href="{{ route('home') }}#courts" class="nav-link text-white hover:bg-white/10 hover:text-white">Find courts</a>
                    @endauth
                </div>
                <div class="hidden md:block">
                    @auth
                        <details class="account-menu relative">
                            <summary class="flex cursor-pointer list-none items-center gap-3 rounded border border-white/15 bg-white/10 px-3 py-2 shadow-sm transition">
                                <span class="grid h-9 w-9 place-items-center rounded bg-white text-sm font-black text-[#001f3f]">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                <span class="text-left">
                                    <span class="block text-sm font-black text-white">{{ auth()->user()->name }}</span>
                                    <span class="block text-xs font-semibold text-white/60">{{ auth()->user()->role }}</span>
                                </span>
                                <span class="text-white/50">⌄</span>
                            </summary>
                            <div class="absolute right-0 mt-2 w-64 overflow-hidden rounded border border-slate-200 bg-white shadow-2xl shadow-slate-950/10">
                                <div class="border-b border-slate-100 p-4">
                                    <p class="text-sm font-black text-courtigo-navy">{{ auth()->user()->email }}</p>
                                    <p class="mt-1 text-xs font-semibold text-slate-500">Signed in to Courtigo</p>
                                </div>
                                <a href="{{ route('dashboard.player') }}" class="flex items-center justify-between px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-courtigo-blue">
                                    My dashboard
                                    <span class="text-slate-300">›</span>
                                </a>
                                <a href="{{ route('home') }}#courts" class="flex items-center justify-between px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-courtigo-blue">
                                    Find courts
                                    <span class="text-slate-300">›</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100">
                                    @csrf
                                    <button class="w-full px-4 py-3 text-left text-sm font-black text-red-600 hover:bg-red-50" type="submit">Logout</button>
                                </form>
                            </div>
                        </details>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="rounded border border-white/20 bg-white/10 px-4 py-2 text-sm font-bold text-white shadow-sm">Login</a>
                            <a href="{{ route('register') }}" class="rounded bg-courtigo-green px-4 py-2 text-sm font-bold text-white shadow-sm">Create account</a>
                        </div>
                    @endauth
                </div>
                <button class="grid h-11 w-11 place-items-center rounded border border-white/20 bg-white/10 text-white shadow-sm md:hidden" type="button" data-mobile-nav-toggle aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu">
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
                            <a href="{{ route('home') }}#courts" class="block rounded bg-courtigo-green px-4 py-3 text-center text-sm font-black text-white shadow-sm">Find courts</a>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <a href="{{ route('login') }}" class="rounded border border-slate-200 px-4 py-2.5 text-center text-sm font-black text-courtigo-navy">Login</a>
                                <a href="{{ route('register') }}" class="rounded border border-slate-200 px-4 py-2.5 text-center text-sm font-black text-courtigo-navy">Create account</a>
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

    <button class="quick-top fixed bottom-5 right-5 z-30 grid h-11 w-11 place-items-center rounded border border-slate-200 bg-white text-courtigo-navy shadow-xl shadow-slate-950/10 hover:border-courtigo-blue hover:text-courtigo-blue" type="button" data-back-to-top aria-label="Back to top">
        ↑
    </button>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-[1.3fr_1fr_1fr] lg:px-8">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded bg-courtigo-navy text-sm font-black text-white">CT</span>
                    <span>
                        <span class="block text-lg font-black tracking-tight text-courtigo-navy">Courtigo</span>
                        <span class="block text-xs font-medium text-slate-500">Pickleball courts for every rally</span>
                    </span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-6 text-slate-500">Find courts, reserve live slots, and keep your game plans in one polished dashboard.</p>
            </div>
            <div>
                <h2 class="text-sm font-black uppercase tracking-wide text-courtigo-navy">Explore</h2>
                <div class="mt-4 grid gap-2 text-sm font-semibold text-slate-500">
                    <a href="{{ route('home') }}#courts" class="hover:text-courtigo-blue">Courts</a>
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-courtigo-blue">How it works</a>
                    <a href="{{ route('vendor.apply') }}" class="hover:text-courtigo-blue">List your venue</a>
                </div>
            </div>
            <div>
                <h2 class="text-sm font-black uppercase tracking-wide text-courtigo-navy">Player tools</h2>
                <div class="mt-4 grid gap-2 text-sm font-semibold text-slate-500">
                    <a href="{{ route('dashboard.player') }}" class="hover:text-courtigo-blue">My bookings</a>
                    <a href="{{ route('home') }}#courts" class="hover:text-courtigo-blue">Reserve a court</a>
                    <a href="{{ route('login') }}" class="hover:text-courtigo-blue">Account access</a>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-100">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 text-xs font-semibold text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© {{ date('Y') }} Courtigo. Pickleball court reservations for players.</p>
                <p>Built for faster booking, cleaner schedules, and easier match days.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script src="{{ asset('js/courtigo-layout.js') }}" defer></script>
</body>
</html>
