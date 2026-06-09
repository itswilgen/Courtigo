@extends('layouts.app-dashboard', ['title' => 'Followed | Courtigo'])

@php
    $followedCourts = $courts->map(fn ($court) => [
        'name' => $court->name,
        'location' => $court->city ?? $court->location ?? 'Metro Cebu',
        'availability' => $court->is_featured ? 'Featured Today' : 'Available Today',
        'image' => $court->primaryImage(),
        'url' => route('courts.show', $court),
    ])->values()->all();

    if (empty($followedCourts)) {
        $followedCourts = [
            ['name' => 'Metro Rally Court', 'location' => 'Cebu City', 'availability' => 'Available Today', 'image' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=900&q=80', 'url' => route('courts.index')],
            ['name' => 'Baseline Hoops Arena', 'location' => 'Mandaue City', 'availability' => '4 Slots Left', 'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=900&q=80', 'url' => route('courts.index')],
            ['name' => 'Clayline Tennis Club', 'location' => 'Cebu Business Park', 'availability' => 'Available Today', 'image' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=900&q=80', 'url' => route('courts.index')],
        ];
    }

    $vendors = [
        ['name' => 'Metro Sports', 'rating' => '4.8', 'logo' => 'https://images.unsplash.com/photo-1531891437562-4301cf35b7e4?auto=format&fit=crop&w=300&q=80'],
        ['name' => 'Baseline Club', 'rating' => '4.7', 'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80'],
        ['name' => 'Smash House', 'rating' => '4.9', 'logo' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=300&q=80'],
        ['name' => 'Peak Athletics', 'rating' => '4.6', 'logo' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=300&q=80'],
    ];

    $updates = [
        ['title' => 'Weekend slots released', 'description' => 'Metro Sports opened extra Saturday badminton and tennis slots for followed players.', 'date' => 'June 2, 2026'],
        ['title' => 'Member promo announced', 'description' => 'Baseline Club is offering 10 percent off selected afternoon basketball reservations.', 'date' => 'June 1, 2026'],
        ['title' => 'Court maintenance notice', 'description' => 'Clayline Tennis Club will close Court 2 for resurfacing on Wednesday morning.', 'date' => 'May 31, 2026'],
        ['title' => 'New group rally', 'description' => 'Smash House invited followed players to a beginner-friendly doubles session.', 'date' => 'May 30, 2026'],
    ];
@endphp

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Followed</p>
            <h1 class="mt-1 text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">Courts, vendors, and updates you follow.</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Keep the venues you care about close, with availability and announcements grouped in one clean place.</p>
        </section>

        <section class="space-y-4">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-black text-courtigo-navy">Followed Courts</h2>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-courtigo-blue">{{ count($followedCourts) }} courts</span>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($followedCourts as $court)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
                        <img class="h-36 w-full object-cover" src="{{ $court['image'] }}" alt="{{ $court['name'] }}">
                        <div class="space-y-4 p-4">
                            <div>
                                <h3 class="text-lg font-black text-slate-900">{{ $court['name'] }}</h3>
                                <p class="mt-1 text-sm font-semibold text-slate-600">{{ $court['location'] }}</p>
                            </div>
                            <x-courtigo.availability-badge :label="$court['availability']" :tone="str_contains($court['availability'], 'Left') ? 'limited' : 'available'" />
                            <a href="{{ $court['url'] }}" class="inline-flex w-full justify-center rounded-2xl bg-courtigo-navy px-4 py-3 text-sm font-black text-white transition hover:bg-blue-950">View Court</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">
            <section class="space-y-4">
                <h2 class="text-xl font-black text-courtigo-navy">Updates / Promos</h2>
                <div class="space-y-3">
                    @foreach ($updates as $update)
                        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <h3 class="text-lg font-black text-slate-900">{{ $update['title'] }}</h3>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black uppercase tracking-wide text-slate-600">{{ $update['date'] }}</span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $update['description'] }}</p>
                        </article>
                    @endforeach
                </div>
            </section>

            <aside class="space-y-4 xl:sticky xl:top-20 xl:self-start">
                <h2 class="text-xl font-black text-courtigo-navy">Followed Vendors</h2>
                <div class="space-y-3">
                    @foreach ($vendors as $vendor)
                        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft">
                            <div class="flex items-center gap-3">
                                <img class="h-14 w-14 rounded-2xl object-cover" src="{{ $vendor['logo'] }}" alt="{{ $vendor['name'] }}">
                                <div class="min-w-0 flex-1">
                                    <h3 class="truncate font-black text-slate-900">{{ $vendor['name'] }}</h3>
                                    <p class="mt-1 text-sm font-bold text-amber-600">Rating {{ $vendor['rating'] }}</p>
                                </div>
                            </div>
                            <button class="mt-4 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue" type="button">View Vendor</button>
                        </article>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
@endsection
