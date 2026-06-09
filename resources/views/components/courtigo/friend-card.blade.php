@props(['friend'])

<article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
    <div class="flex items-start gap-3">
        <img class="h-14 w-14 rounded-2xl object-cover" src="{{ $friend['avatar'] }}" alt="{{ $friend['name'] }}">
        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h3 class="truncate text-lg font-black text-slate-900">{{ $friend['name'] }}</h3>
                <x-courtigo.online-status-badge :status="$friend['status']" />
            </div>
            <p class="mt-1 text-sm font-semibold text-slate-600">{{ $friend['sport'] }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ $friend['location'] }}</p>
            <p class="mt-3 text-sm font-bold text-slate-500">{{ $friend['mutuals'] }} mutual friends</p>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-2">
        <a href="{{ route('profiles.preview', ['username' => $friend['slug'] ?? str($friend['name'])->slug()]) }}" class="rounded-2xl bg-courtigo-navy px-3 py-2.5 text-center text-sm font-black text-white transition hover:bg-blue-950">View Profile</a>
        <button class="rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue" type="button">Message</button>
    </div>
    <button class="mt-2 w-full rounded-2xl px-3 py-2 text-sm font-black text-slate-500 transition hover:bg-slate-100 hover:text-red-700" type="button">Remove Friend</button>
</article>
