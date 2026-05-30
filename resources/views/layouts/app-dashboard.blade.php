<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard | Courtigo' }}</title>
    <script src="{{ asset('js/tailwind-dashboard-config.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dashboard-hero {
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        .dashboard-hero > * {
            position: relative;
            z-index: 1;
        }

        .dashboard-hero::before {
            position: absolute;
            inset: 0;
            z-index: -2;
            background-image: url("https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1600&q=80");
            background-position: center;
            background-size: cover;
            content: "";
        }

        .dashboard-hero::after {
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(90deg, rgb(255 255 255 / .97), rgb(255 255 255 / .9) 58%, rgb(255 255 255 / .72)),
                radial-gradient(circle at 8% 18%, rgb(37 99 235 / .12), transparent 28%),
                radial-gradient(circle at 88% 16%, rgb(22 163 74 / .13), transparent 26%);
            content: "";
        }

        .dashboard-hero.alt::before {
            background-image: url("https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1600&q=80");
        }
    </style>
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
    <script src="{{ asset('js/dashboard-layout.js') }}" defer></script>
</body>
</html>
