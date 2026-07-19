@extends('layouts.app-dashboard', ['title' => 'Courts | Courtigo'])

@php
    $placeholderCourts = [
        [
            'name' => 'Metro Rally Court',
            'vendor' => 'Metro Sports',
            'location' => 'Cebu City',
            'sport' => 'Badminton',
            'rating' => '4.8',
            'price' => '350',
            'availability' => 'Available Today',
            'availability_tone' => 'available',
            'image' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['8:00 AM', '10:00 AM', '1:00 PM', '4:00 PM'],
            'following' => true,
        ],
        [
            'name' => 'Baseline Hoops Arena',
            'vendor' => 'Baseline Club',
            'location' => 'Mandaue City',
            'sport' => 'Basketball',
            'rating' => '4.7',
            'price' => '500',
            'availability' => '4 Slots Left',
            'availability_tone' => 'limited',
            'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['9:00 AM', '11:00 AM', '2:00 PM', '6:00 PM'],
        ],
        [
            'name' => 'Cebu Smash Hub',
            'vendor' => 'Smash House',
            'location' => 'Lapu-Lapu City',
            'sport' => 'Badminton',
            'rating' => '4.9',
            'price' => '420',
            'availability' => 'Available Today',
            'availability_tone' => 'available',
            'image' => 'https://images.unsplash.com/photo-1613918431703-aa50889e3be2?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['7:00 AM', '12:00 PM', '3:00 PM', '5:00 PM'],
        ],
        [
            'name' => 'Northside Volley Court',
            'vendor' => 'Northside Sports',
            'location' => 'Consolacion',
            'sport' => 'Volleyball',
            'rating' => '4.6',
            'price' => '380',
            'availability' => 'Available Today',
            'availability_tone' => 'available',
            'image' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['8:30 AM', '10:30 AM', '1:30 PM', '7:00 PM'],
        ],
        [
            'name' => 'Clayline Tennis Club',
            'vendor' => 'Clayline',
            'location' => 'Cebu Business Park',
            'sport' => 'Tennis',
            'rating' => '4.8',
            'price' => '650',
            'availability' => '2 Slots Left',
            'availability_tone' => 'limited',
            'image' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['6:00 AM', '9:00 AM', '4:00 PM', '8:00 PM'],
        ],
        [
            'name' => 'South Town Futsal',
            'vendor' => 'South Town Courts',
            'location' => 'Talisay City',
            'sport' => 'Futsal',
            'rating' => '4.5',
            'price' => '700',
            'availability' => 'Available Today',
            'availability_tone' => 'available',
            'image' => 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['10:00 AM', '1:00 PM', '5:00 PM', '9:00 PM'],
        ],
        [
            'name' => 'Riverside Pickleball',
            'vendor' => 'Riverside Rec',
            'location' => 'Cebu City',
            'sport' => 'Pickleball',
            'rating' => '4.7',
            'price' => '300',
            'availability' => 'Available Today',
            'availability_tone' => 'available',
            'image' => 'https://images.unsplash.com/photo-1629305623450-37e52f9d6d56?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['7:30 AM', '11:30 AM', '2:30 PM', '4:30 PM'],
        ],
        [
            'name' => 'Peak Padel Studio',
            'vendor' => 'Peak Athletics',
            'location' => 'IT Park',
            'sport' => 'Padel',
            'rating' => '4.9',
            'price' => '720',
            'availability' => '3 Slots Left',
            'availability_tone' => 'limited',
            'image' => 'https://images.unsplash.com/photo-1656019448960-3bb9df43f0c3?auto=format&fit=crop&w=1200&q=80',
            'slots' => ['8:00 AM', '12:00 PM', '6:00 PM', '8:00 PM'],
        ],
    ];

    $realCourtCards = $courts->map(fn ($court) => [
        'id' => $court->id,
        'name' => $court->name,
        'vendor' => $court->vendorProfile?->business_name ?? 'Courtigo Partner',
        'location' => $court->city ?? $court->location ?? 'Metro Cebu',
        'sport' => $court->surface_type ?? 'Multi-sport',
        'rating' => number_format((float) ($court->rating_average ?: 4.8), 1),
        'price' => number_format((float) ($court->hourly_rate ?? $court->price ?? 350), 0),
        'availability' => $court->is_featured ? 'Featured Today' : 'Available Today',
        'availability_tone' => $court->is_featured ? 'limited' : 'available',
        'image' => $court->primaryImage(),
        'slots' => ['8:00 AM', '10:00 AM', '1:00 PM', '4:00 PM'],
        'following' => false,
    ])->all();

    $courtCards = array_slice(array_merge($realCourtCards, $placeholderCourts), 0, 16);
@endphp

@section('content')
    <div class="space-y-5" data-courts-discovery>
        <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
                <div>
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Courts marketplace</p>
                    <h1 class="mt-1 text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">Discover courts built for your next game.</h1>
                </div>
                <div class="lg:w-96">
                    <x-courtigo.search-bar />
                </div>
            </div>

            <div class="mt-4">
                <x-courtigo.filter-chips />
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
            <section class="min-w-0">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
                    @foreach ($courtCards as $court)
                        <x-courtigo.court-card :court="$court" class="{{ $loop->index >= 8 ? 'hidden' : '' }}" data-discovery-extra="{{ $loop->index >= 8 ? 'true' : 'false' }}" />
                    @endforeach
                </div>

                <div class="mt-6 flex justify-center">
                    <div class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-black text-slate-500 shadow-sm" data-discovery-loader>
                        <span class="h-2 w-2 animate-pulse rounded-full bg-courtigo-blue"></span>
                        Loading more courts
                    </div>
                </div>
            </section>

            <aside class="hidden space-y-5 xl:sticky xl:top-20 xl:block xl:self-start">
                <x-courtigo.reservation-widget />
                <x-courtigo.notification-widget />
                <x-courtigo.community-widget />
            </aside>
        </div>

        <div class="hidden" data-mobile-widget-content="reservation">
            <x-courtigo.reservation-widget class="border-0 shadow-none" />
        </div>
        <div class="hidden" data-mobile-widget-content="notifications">
            <x-courtigo.notification-widget class="border-0 shadow-none" />
        </div>
        <div class="hidden" data-mobile-widget-content="community">
            <x-courtigo.community-widget class="border-0 shadow-none" />
        </div>
    </div>

    <x-courtigo.view-slots-modal />

    <div class="fixed inset-0 z-50 hidden xl:hidden" data-mobile-widget-modal aria-hidden="true">
        <div class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm" data-mobile-widget-close></div>
        <div class="absolute inset-x-3 bottom-3 max-h-[82vh] overflow-y-auto rounded-2xl bg-white p-3 shadow-2xl">
            <div class="mb-2 flex justify-end">
                <button class="grid h-10 w-10 place-items-center rounded-2xl text-slate-500 transition hover:bg-slate-100 hover:text-courtigo-navy" type="button" data-mobile-widget-close aria-label="Close panel">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div data-mobile-widget-panel></div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/courts-discovery.js') }}" defer></script>
    @endpush
@endsection
