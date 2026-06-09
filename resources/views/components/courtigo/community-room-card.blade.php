@props(['room'])

<article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="font-black text-slate-900">{{ $room['name'] }}</h3>
            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $room['topic'] }}</p>
        </div>
        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">{{ $room['online'] }} online</span>
    </div>
    <div class="mt-4 grid grid-cols-2 gap-2">
        <button class="rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue" type="button">View Room</button>  
        <button class="rounded-2xl bg-courtigo-navy px-3 py-2.5 text-sm text-white font-black" type="button">Join Room</button>
    </div>
</article>
