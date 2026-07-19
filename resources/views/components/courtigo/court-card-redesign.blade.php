@props(['court'])

@php
    $slots = implode('|', $court['slots'] ?? ['8:00 AM', '10:00 AM', '1:00 PM', '4:00 PM']);
    $courtId = $court['id'] ?? null;
    $isDbCourt = !is_null($courtId) && is_numeric($courtId);
@endphp

<a 
    href="{{ $isDbCourt ? route('courts.show', ['court' => $court['id']]) : '#' }}"
    {{ $attributes->class(['group block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300']) }}
    data-court-card
    data-court-name="{{ $court['name'] }}"
    data-court-vendor="{{ $court['vendor'] }}"
>
    <!-- Image Container with Overlay -->
    <div class="relative aspect-video bg-slate-100 overflow-hidden">
        <!-- Vendor Badge (Bottom-Left) -->
        <div class="absolute bottom-3 left-3 z-10">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-900/90 backdrop-blur-sm px-3 py-1.5 text-xs font-bold text-white ring-1 ring-white/10">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                {{ substr($court['vendor'], 0, 20) }}
            </span>
        </div>

        <!-- Rating Badge (Top-Right) -->
        <div class="absolute top-3 right-3 z-10">
            <div class="flex items-center gap-1 rounded-lg bg-white/95 backdrop-blur-sm px-2.5 py-1.5 shadow-sm ring-1 ring-slate-200/50">
                <span class="text-sm font-black text-slate-900">
                    ⭐ {{ $court['rating'] }}
                </span>
            </div>
        </div>

        <!-- Hero Image -->
        <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" 
             src="{{ $court['image'] }}" 
             alt="{{ $court['name'] }}"
             loading="lazy">
    </div>

    <!-- Content Section -->
    <div class="p-4 space-y-3">
        
        <!-- Header -->
        <div>
            <h2 class="text-lg font-black tracking-tight text-slate-900 truncate">
                {{ $court['name'] }}
            </h2>
            <p class="text-sm font-semibold text-slate-500 truncate">
                {{ $court['vendor'] }}
            </p>
        </div>

        <!-- Location -->
        <div class="flex items-center gap-2 text-sm font-medium text-slate-600 truncate">
            <svg class="h-4 w-4 shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
            <span class="truncate">{{ $court['location'] }}</span>
        </div>

        <!-- Metadata Badges -->
        <div class="flex items-center gap-2 flex-wrap">
            <!-- Availability Status -->
            <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide
                        @if($court['availability'] === 'available')
                            bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100
                        @elseif($court['availability'] === 'limited')
                            bg-amber-50 text-amber-700 ring-1 ring-amber-100
                        @else
                            bg-slate-100 text-slate-600 ring-1 ring-slate-200
                        @endif">
                <span class="h-1.5 w-1.5 rounded-full 
                            @if($court['availability'] === 'available') bg-emerald-500
                            @elseif($court['availability'] === 'limited') bg-amber-500
                            @else bg-slate-400 @endif"></span>
                {{ ucfirst($court['availability']) }}
            </span>

            <!-- Price Badge -->
            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 ring-1 ring-blue-100">
                ₱{{ number_format($court['price']) }}/hr
            </span>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2 pt-1">
            <!-- Primary CTA -->
            <button class="flex-1 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-black text-white transition-colors hover:bg-slate-950 active:bg-slate-950">
                View Slots
            </button>

            <!-- Follow Button -->
            <button type="button" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-black text-slate-700 transition-colors hover:bg-slate-50 active:bg-slate-100">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/>
                </svg>
            </button>
        </div>
    </div>
</a>
