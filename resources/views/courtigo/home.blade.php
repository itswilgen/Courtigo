@extends('layouts.courtigo', ['title' => 'Courtigo | Pickleball Court Reservations'])

@section('content')
    <section class="bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.02fr_0.98fr] lg:px-8 lg:py-16">
            <div class="flex flex-col justify-center">
                <div class="mb-5 w-fit rounded-full border border-green-100 bg-green-50 px-4 py-2 text-sm font-bold text-green-700">Pickleball court rentals made simple</div>
                <h1 class="max-w-3xl text-4xl font-black tracking-tight text-courtigo-navy sm:text-5xl lg:text-6xl">Find a court, book your slot, start playing.</h1>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Courtigo helps players discover nearby pickleball courts, compare prices, check available time slots, and reserve a court before the next rally group chat gets messy.</p>
                <div class="mt-8 grid gap-3 rounded border border-slate-200 bg-slate-50 p-3 sm:grid-cols-[1fr_1fr_1fr_auto]">
                    <input class="rounded border border-slate-200 px-4 py-3 text-sm outline-none focus:border-courtigo-blue" placeholder="City or venue">
                    <input class="rounded border border-slate-200 px-4 py-3 text-sm outline-none focus:border-courtigo-blue" placeholder="Preferred date">
                    <input class="rounded border border-slate-200 px-4 py-3 text-sm outline-none focus:border-courtigo-blue" placeholder="Morning, afternoon, evening">
                    <a href="#courts" class="rounded bg-courtigo-navy px-5 py-3 text-center text-sm font-bold text-white">Search courts</a>
                </div>
                <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <x-stat label="Courts ready" :value="$stats['courts']" />
                    <x-stat label="Venues" :value="$stats['vendors']" />
                    <x-stat label="Bookings" :value="$stats['bookings']" />
                    <x-stat label="Players" :value="$stats['players']" />
                </div>
            </div>
            <div class="relative min-h-[460px] overflow-hidden rounded bg-courtigo-navy">
                <img class="absolute inset-0 h-full w-full object-cover opacity-80" src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1400&q=80" alt="Pickleball court">
                <div class="absolute inset-x-4 bottom-4 rounded bg-white p-5 shadow-2xl">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-courtigo-green">Live slot available</p>
                            <h2 class="mt-1 text-xl font-black text-courtigo-navy">Metro Rally Court</h2>
                            <p class="mt-1 text-sm text-slate-500">Tomorrow · 8:00 AM · Taguig · Indoor</p>
                        </div>
                        <span class="rounded bg-green-50 px-3 py-1 text-sm font-bold text-green-700">₱950/hr</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="courts" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Court rentals</p>
                <h2 class="mt-2 text-3xl font-black text-courtigo-navy">Pick your next place to play</h2>
            </div>
            <div class="flex flex-wrap gap-2 text-sm font-semibold">
                <span class="rounded border border-slate-200 bg-white px-3 py-2">Location</span>
                <span class="rounded border border-slate-200 bg-white px-3 py-2">Price</span>
                <span class="rounded border border-slate-200 bg-white px-3 py-2">Availability</span>
                <span class="rounded border border-slate-200 bg-white px-3 py-2">Ratings</span>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($courts as $court)
                <a href="{{ route('courts.show', $court) }}" class="group overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="aspect-[4/3] overflow-hidden bg-slate-200">
                        <img class="h-full w-full object-cover transition duration-300 group-hover:scale-105" src="{{ $court->primaryImage() }}" alt="{{ $court->name }}">
                    </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-black text-courtigo-navy">{{ $court->name }}</h3>
                                <p class="mt-1 text-sm text-slate-500">{{ $court->location }}</p>
                            </div>
                            <span class="text-sm font-bold text-slate-700">★ {{ $court->rating_average }}</span>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="font-black text-courtigo-navy">₱{{ number_format($court->hourly_rate) }} <span class="text-sm font-medium text-slate-500">/ hour</span></p>
                            <span class="rounded bg-blue-50 px-3 py-1 text-sm font-bold text-courtigo-blue">View slots</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section id="how-it-works" class="border-y border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">How it works</p>
                <h2 class="mt-2 text-3xl font-black text-courtigo-navy">Reserve court time without the back-and-forth</h2>
            </div>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                <div class="rounded border border-slate-200 p-6">
                    <span class="grid h-11 w-11 place-items-center rounded bg-blue-50 text-xl font-black text-courtigo-blue">1</span>
                    <h3 class="mt-5 text-xl font-black text-courtigo-navy">Find your court</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Search by city, venue, court type, price, and rating so your group can choose the best place to play.</p>
                </div>
                <div class="rounded border border-slate-200 p-6">
                    <span class="grid h-11 w-11 place-items-center rounded bg-green-50 text-xl font-black text-courtigo-green">2</span>
                    <h3 class="mt-5 text-xl font-black text-courtigo-navy">Choose a live slot</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">See available times, compare hourly rates, and lock in the schedule before someone else grabs it.</p>
                </div>
                <div class="rounded border border-slate-200 p-6">
                    <span class="grid h-11 w-11 place-items-center rounded bg-amber-50 text-xl font-black text-courtigo-amber">3</span>
                    <h3 class="mt-5 text-xl font-black text-courtigo-navy">Show up and play</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Keep your reservation details handy, invite your players, and spend your energy on the match.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="why-book" class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
        <div>
            <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Why players book here</p>
            <h2 class="mt-2 text-3xl font-black text-courtigo-navy">Built for casual games, training sessions, and weekend leagues</h2>
            <p class="mt-4 text-base leading-7 text-slate-600">Whether you are trying pickleball for the first time or organizing a regular crew, Courtigo keeps court discovery, slot selection, and reservation details in one player-friendly flow.</p>
            <a href="#courts" class="mt-6 inline-flex rounded bg-courtigo-green px-5 py-3 text-sm font-bold text-white hover:bg-green-600">Browse available courts</a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded border border-slate-200 bg-white p-5">
                <h3 class="font-black text-courtigo-navy">Know the cost upfront</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Compare hourly rates before you commit, then split the cost with your group however you like.</p>
            </div>
            <div class="rounded border border-slate-200 bg-white p-5">
                <h3 class="font-black text-courtigo-navy">Book around your day</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Morning drills, after-work games, and weekend sessions are easier to plan with clear slot options.</p>
            </div>
            <div class="rounded border border-slate-200 bg-white p-5">
                <h3 class="font-black text-courtigo-navy">Choose the right court</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Use location, court surface, photos, and ratings to pick a venue that fits your game.</p>
            </div>
            <div class="rounded border border-slate-200 bg-white p-5">
                <h3 class="font-black text-courtigo-navy">Track your reservations</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">Open your player dashboard to review upcoming bookings and keep your court plans organized.</p>
            </div>
        </div>
    </section>
@endsection
