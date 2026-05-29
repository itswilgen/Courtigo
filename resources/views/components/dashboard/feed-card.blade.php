@props(['court'])

<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft transition duration-300 hover:-translate-y-1 hover:shadow-xl">
    <div class="flex items-center justify-between gap-3 p-4">
        <div class="flex min-w-0 items-center gap-3">
            <span class="grid h-11 w-11 place-items-center rounded-2xl bg-blue-50 text-sm font-black text-courtigo-blue">CV</span>
            <div class="min-w-0">
                <h2 class="truncate font-black text-courtigo-navy">{{ $court->vendorProfile?->business_name ?? $court->name }}</h2>
                <p class="truncate text-sm font-semibold text-slate-500">{{ $court->city ?? $court->location ?? 'Metro venue' }}</p>
            </div>
        </div>
        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-emerald-700 ring-1 ring-emerald-100">Available</span>
    </div>

    <div class="aspect-[16/10] overflow-hidden bg-slate-200">
        <img class="h-full w-full object-cover transition duration-500 hover:scale-105" src="{{ $court->primaryImage() }}" alt="{{ $court->name }}">
    </div>

    <div class="space-y-4 p-4">
        <div>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h3 class="text-xl font-black text-courtigo-navy">{{ $court->name }}</h3>
                <span class="text-sm font-black text-amber-600">★ {{ number_format((float) $court->rating_average ?: 4.8, 1) }}</span>
            </div>
            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">{{ $court->description ?: 'Fresh slots are open for casual rallies, league practice, and weekend games.' }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2 text-xs font-black uppercase tracking-wide text-slate-500">
            <span class="rounded-full bg-slate-100 px-3 py-1">{{ $court->surface_type ?? 'Outdoor' }}</span>
            <span class="rounded-full bg-slate-100 px-3 py-1">₱{{ number_format($court->hourly_rate ?? $court->price ?? 0) }}/hr</span>
            <span class="rounded-full bg-slate-100 px-3 py-1">{{ $court->rating_count ?: 24 }} reviews</span>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('courts.show', $court) }}" class="rounded-2xl bg-courtigo-navy px-4 py-3 text-center text-sm font-black text-white transition hover:bg-blue-950">View Slots</a>
            <button class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue" type="button">Follow</button>
        </div>
    </div>
</article>
