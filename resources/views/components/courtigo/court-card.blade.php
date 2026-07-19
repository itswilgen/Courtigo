@props(['court'])

@php
    $slots = implode('|', $court['slots'] ?? ['8:00 AM', '10:00 AM', '1:00 PM', '4:00 PM']);
    // Check if court has an id (database model) or is placeholder data
    $courtId = $court['id'] ?? null;
    $isDbCourt = !is_null($courtId) && is_numeric($courtId);
@endphp

<a 
    href="{{ $isDbCourt ? route('courts.show', ['court' => $court['id']]) : '#' }}"
    {{ $attributes->class(['group block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-soft hover:cursor-pointer']) }}
    data-court-card
    data-court-name="{{ $court['name'] }}"
    data-court-vendor="{{ $court['vendor'] }}"
    data-court-slots="{{ $slots }}"
    data-court-search-index="{{ strtolower($court['name'].' '.$court['vendor'].' '.$court['location'].' '.$court['sport']) }}"
>
    <div class="aspect-[16/10] overflow-hidden bg-slate-100">
        <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="{{ $court['image'] }}" alt="{{ $court['name'] }}">
    </div>

    <div class="space-y-4 p-4">
        <div class="space-y-2">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h2 class="truncate text-lg font-black tracking-tight text-courtigo-navy">{{ $court['name'] }}</h2>
                    <p class="truncate text-sm font-bold text-slate-500">Vendor: {{ $court['vendor'] }}</p>
                </div>
                <span class="shrink-0 text-sm font-black text-amber-600">Rating {{ $court['rating'] }}</span>
            </div>

            <div class="grid gap-2 text-sm font-semibold text-slate-600">
                <p class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-courtigo-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                    <span class="truncate">{{ $court['location'] }}</span>
                </p>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black uppercase tracking-wide text-slate-600">{{ $court['sport'] }}</span>
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-courtigo-blue">PHP {{ $court['price'] }}/hr</span>
                </div>
            </div>
        </div>

        <x-courtigo.availability-badge :label="$court['availability']" :tone="$court['availability_tone'] ?? 'available'" />

        <div class="flex justify-end">
            <x-courtigo.follow-button :following="$court['following'] ?? false" />
        </div>
    </div>
</a>
