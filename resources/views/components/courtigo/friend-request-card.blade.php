@props(['request'])

<article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
    <div class="flex gap-3">
        <img class="h-14 w-14 rounded-2xl object-cover" src="{{ $request['avatar'] }}" alt="{{ $request['name'] }}">
        <div class="min-w-0">
            <h3 class="truncate text-lg font-black text-slate-900">{{ $request['name'] }}</h3>
            <p class="mt-1 text-sm font-semibold text-slate-600">{{ $request['sports'] }}</p>
            <p class="mt-2 text-sm font-bold text-slate-500">{{ $request['mutuals'] }} mutual friends</p>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-2">
        <button class="rounded-2xl bg-courtigo-green px-3 py-2.5 text-sm font-black text-white transition hover:bg-green-600" type="button">Accept</button>
        <button class="rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-black text-slate-700 transition hover:bg-slate-100 hover:text-courtigo-navy" type="button">Decline</button>
    </div>
</article>
