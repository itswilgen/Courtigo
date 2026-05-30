@php
    $user = auth()->user();
    $initials = collect(explode(' ', $user?->name ?? 'U'))->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
@endphp

<div class="relative" data-profile-menu>
    <button class="flex items-center gap-2 rounded-2xl border border-white/15 bg-white/10 p-1.5 transition hover:bg-white/15" type="button" data-profile-button aria-haspopup="true" aria-expanded="false">
        <span class="grid h-9 w-9 place-items-center rounded-2xl bg-white text-xs font-black text-[#001f3f]">{{ $initials ?: 'U' }}</span>
        <svg class="hidden h-4 w-4 text-white/70 sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
    </button>

    <div class="absolute right-0 mt-3 hidden w-72 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-950/15" data-profile-panel>
        <div class="border-b border-slate-100 p-4">
            <div class="flex items-center gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-courtigo-navy text-sm font-black text-white">{{ $initials ?: 'U' }}</span>
                <div class="min-w-0">
                    <p class="truncate font-black text-courtigo-navy">{{ $user?->name }}</p>
                    <p class="truncate text-sm font-semibold text-slate-500">{{ $user?->email }}</p>
                </div>
            </div>
        </div>

        <div class="p-2">
            @foreach ([['View Profile', 'profile.show'], ['Settings', 'settings.index'], ['My Bookings', 'bookings.index']] as [$label, $route])
                <a href="{{ route($route) }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-100 hover:text-courtigo-navy">{{ $label }}</a>
            @endforeach
            <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-slate-100 pt-1">
                @csrf
                <button class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-bold text-red-700 transition hover:bg-red-50" type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>
