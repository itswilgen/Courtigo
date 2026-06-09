@props(['friend'])

<article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
    <div class="flex items-start gap-3">
        <img class="h-14 w-14 rounded-2xl object-cover" src="{{ $friend['avatar'] }}" alt="{{ $friend['name'] }}">
        <div class="min-w-0 flex-1">
            <h3 class="truncate text-lg font-black text-slate-900">{{ $friend['name'] }}</h3>
            <p class="mt-1 text-sm font-semibold text-slate-600">{{ $friend['sports'] }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ $friend['location'] }}</p>
            <p class="mt-3 text-sm font-bold text-slate-500">{{ $friend['mutuals'] }} mutual friends</p>
        </div>
    </div>
    <button class="mt-4 w-full rounded-2xl bg-courtigo-navy px-3 py-2.5 text-sm font-black text-white transition hover:bg-blue-950" type="button">Add Friend</button>
</article>
