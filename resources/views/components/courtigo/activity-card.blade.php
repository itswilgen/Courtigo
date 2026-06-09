@props(['activity'])

<article class="relative rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex gap-3">
        <span class="mt-1 grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-blue-50 text-sm font-black text-courtigo-blue">{{ $activity['initials'] }}</span>
        <div class="min-w-0">
            <p class="text-sm leading-6 text-slate-700">
                <span class="font-black text-slate-900">{{ $activity['name'] }}</span>
                {{ $activity['action'] }}
            </p>
            <p class="mt-1 text-xs font-bold uppercase tracking-wide text-slate-400">{{ $activity['time'] }}</p>
        </div>
    </div>
</article>
