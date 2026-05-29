@php
    $items = [
        ['label' => 'Home Feed', 'route' => 'dashboard.player', 'icon' => 'home'],
        ['label' => 'Courts', 'route' => 'courts.index', 'icon' => 'map'],
        ['label' => 'Friends', 'route' => 'friends.index', 'icon' => 'users'],
        ['label' => 'Followed Courts', 'route' => 'followed.index', 'icon' => 'star'],
        ['label' => 'My Bookings', 'route' => 'bookings.index', 'icon' => 'calendar'],
        ['label' => 'Messages', 'url' => '#', 'icon' => 'chat'],
        ['label' => 'Notifications', 'url' => '#', 'icon' => 'bell'],
        ['label' => 'Settings', 'route' => 'settings.index', 'icon' => 'settings'],
    ];

    $icon = function (string $name) {
        return match ($name) {
            'home' => '<path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.592 0L21.75 12M4.5 9.75v9a.75.75 0 0 0 .75.75H9v-5.25h6v5.25h3.75a.75.75 0 0 0 .75-.75v-9" />',
            'map' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75 3.75 4.5v14.25L9 21m0-14.25 6-2.25m-6 2.25V21m6-16.5 5.25 2.25V21L15 18.75m0-14.25v14.25" />',
            'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.625 21a12.318 12.318 0 0 1-6.375-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 7.5a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm7.5 1.125a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />',
            'star' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />',
            'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5-2.25v2.25M3.75 8.25h16.5M5.25 5.25h13.5c.828 0 1.5.672 1.5 1.5v12c0 .828-.672 1.5-1.5 1.5H5.25c-.828 0-1.5-.672-1.5-1.5v-12c0-.828.672-1.5 1.5-1.5Z" />',
            'chat' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm3.75 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm3.75 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM21 12c0 4.142-4.03 7.5-9 7.5a9.77 9.77 0 0 1-3.295-.56L3 21l1.94-4.311A6.88 6.88 0 0 1 3 12c0-4.142 4.03-7.5 9-7.5s9 3.358 9 7.5Z" />',
            'bell' => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022 23.848 23.848 0 0 0 5.455 1.31m5.714 0a3 3 0 0 1-5.714 0" />',
            default => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.867-.542.958 0l.149.894a1.125 1.125 0 0 0 1.636.781l.797-.459c.476-.274.988.238.714.714l-.459.797a1.125 1.125 0 0 0 .781 1.636l.894.149c.542.09.542.867 0 .958l-.894.149a1.125 1.125 0 0 0-.781 1.636l.459.797c.274.476-.238.988-.714.714l-.797-.459a1.125 1.125 0 0 0-1.636.781l-.149.894c-.09.542-.867.542-.958 0l-.149-.894a1.125 1.125 0 0 0-1.636-.781l-.797.459c-.476.274-.988-.238-.714-.714l.459-.797a1.125 1.125 0 0 0-.781-1.636l-.894-.149c-.542-.09-.542-.867 0-.958l.894-.149a1.125 1.125 0 0 0 .781-1.636l-.459-.797c-.274-.476.238-.988.714-.714l.797.459a1.125 1.125 0 0 0 1.636-.781l.149-.894Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />',
        };
    };
@endphp

<div class="fixed inset-0 z-40 hidden bg-slate-950/40 backdrop-blur-sm lg:hidden" data-sidebar-overlay></div>

<aside class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white shadow-2xl shadow-slate-950/10 transition duration-300 lg:translate-x-0 lg:shadow-none" data-dashboard-sidebar>
    <div class="flex h-16 items-center justify-between border-b border-slate-100 px-5">
        <a href="{{ route('dashboard.player') }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-2xl bg-courtigo-navy text-sm font-black text-white">CT</span>
            <span>
                <span class="block text-lg font-black tracking-tight text-courtigo-navy">Courtigo</span>
                <span class="block text-xs font-bold text-slate-500">Social courts</span>
            </span>
        </a>
        <button class="grid h-10 w-10 place-items-center rounded-xl text-slate-500 hover:bg-slate-100 lg:hidden" type="button" data-sidebar-close aria-label="Close menu">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5">
        @foreach ($items as $item)
            @php
                $active = isset($item['route']) && request()->routeIs($item['route']);
                $href = isset($item['route']) ? route($item['route']) : $item['url'];
            @endphp
            <a href="{{ $href }}" class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold transition hover:-translate-y-0.5 hover:bg-slate-100 {{ $active ? 'bg-blue-50 text-courtigo-blue shadow-sm ring-1 ring-blue-100' : 'text-slate-600 hover:text-courtigo-navy' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">{!! $icon($item['icon']) !!}</svg>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="border-t border-slate-100 p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold text-slate-600 transition hover:bg-red-50 hover:text-red-700" type="submit">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
