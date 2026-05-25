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
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
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
                <a href="{{ route('dashboard.player') }}" class="hover:text-courtigo-blue">My bookings</a>
            </div>
            <a href="{{ route('home') }}#courts" class="rounded bg-courtigo-green px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-green-600">Find a court</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-8 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
            <p>© {{ date('Y') }} Courtigo. Pickleball court reservations for players.</p>
            <div class="flex gap-4">
                <span>GCash</span>
                <span>Maya</span>
                <span>Live court availability</span>
            </div>
        </div>
    </footer>
</body>
</html>
