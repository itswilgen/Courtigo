@props(['group'])

<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
    <div class="aspect-[16/7] bg-slate-100">
        <img class="h-full w-full object-cover" src="{{ $group['cover'] }}" alt="{{ $group['name'] }}">
    </div>
    <div class="space-y-4 p-4">
        <div>
            <div class="flex items-start justify-between gap-3">
                <h3 class="text-lg font-black text-slate-900">{{ $group['name'] }}</h3>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-courtigo-blue">{{ $group['sport'] }}</span>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2 text-sm font-semibold text-slate-600">
                <p>{{ $group['members'] }} members</p>
                <p>{{ $group['activity'] }}</p>
            </div>
            <div class="mt-3 rounded-2xl bg-slate-50 p-3">
                <p class="text-xs font-black uppercase tracking-wide text-slate-400">Next event</p>
                <p class="mt-1 text-sm font-black text-courtigo-navy">{{ $group['next_event'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <button class="rounded-2xl bg-blue-950 px-3 py-2.5 text-sm text-white font-black transition hover:bg-blue-850" type="button">Join Group</button>
            <a href="{{ route('groups.show', ['group' => $group['slug']]) }}" class="rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-center text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue">View Group</a>
        </div>
    </div>
</article>
