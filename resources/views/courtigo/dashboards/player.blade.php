@extends('layouts.courtigo', ['title' => 'Player Dashboard | Courtigo'])

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="rounded border border-slate-200 bg-white p-6 shadow-sm" data-reveal>
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Player dashboard</p>
                    <h1 class="mt-2 text-3xl font-black text-courtigo-navy">Welcome back, {{ $user->name }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Track your court reservations, find your next place to play, and keep your pickleball schedule tidy.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('home') }}#courts" class="rounded bg-courtigo-green px-4 py-3 text-sm font-black text-white hover:bg-green-600">Find courts</a>
                    <a href="{{ route('home') }}#how-it-works" class="rounded border border-slate-200 bg-white px-4 py-3 text-sm font-black text-courtigo-navy hover:border-courtigo-blue hover:text-courtigo-blue">How booking works</a>
                </div>
            </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-metric-card label="Total bookings" :value="$metrics['bookings']" />
            <x-metric-card label="Confirmed" :value="$metrics['confirmed']" />
            <x-metric-card label="Total spent" :value="'₱'.number_format($metrics['spent'])" />
            <x-metric-card label="Featured courts" :value="$metrics['favorites']" />
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-[1fr_360px]">
            <section class="rounded border border-slate-200 bg-white p-5 shadow-sm" data-reveal>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Reservations</p>
                        <h2 class="mt-1 text-2xl font-black text-courtigo-navy">My bookings</h2>
                    </div>
                    <span class="text-sm font-semibold text-slate-500">{{ $bookings->count() }} shown</span>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($bookings as $booking)
                        <article class="flex flex-col gap-4 rounded border border-slate-200 p-4 transition hover:-translate-y-1 hover:shadow-lg sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex gap-4">
                                <img class="h-20 w-24 rounded object-cover" src="{{ $booking->court->primaryImage() }}" alt="{{ $booking->court->name }}">
                                <div>
                                    <p class="font-black text-courtigo-navy">{{ $booking->court->name }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $booking->booking_date->format('M d, Y') }} · {{ substr($booking->starts_at, 0, 5) }} - {{ substr($booking->ends_at, 0, 5) }}</p>
                                    <p class="mt-1 text-xs font-bold uppercase tracking-wide text-slate-400">{{ $booking->reference }}</p>
                                </div>
                            </div>
                            <div class="flex flex-row items-center justify-between gap-3 sm:flex-col sm:items-end">
                                <span class="w-fit rounded bg-green-50 px-3 py-1 text-sm font-bold text-green-700">{{ ucfirst($booking->status) }}</span>
                                <p class="font-black text-courtigo-navy">₱{{ number_format($booking->total_amount) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="rounded border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                            <h3 class="text-xl font-black text-courtigo-navy">No bookings yet</h3>
                            <p class="mt-2 text-sm text-slate-500">Choose a court and reserve your first pickleball slot.</p>
                            <a href="{{ route('home') }}#courts" class="mt-5 inline-flex rounded bg-courtigo-green px-5 py-3 text-sm font-black text-white hover:bg-green-600">Browse courts</a>
                        </div>
                    @endforelse
                </div>
            </section>

            <aside class="space-y-5">
                <section class="rounded border border-slate-200 bg-white p-5 shadow-sm" data-reveal>
                    <h2 class="text-xl font-black text-courtigo-navy">Account</h2>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="font-semibold text-slate-500">Email</span>
                            <span class="text-right font-bold text-courtigo-navy">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="font-semibold text-slate-500">Role</span>
                            <span class="rounded bg-blue-50 px-2 py-1 text-xs font-black uppercase tracking-wide text-courtigo-blue">{{ $user->role }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="font-semibold text-slate-500">Status</span>
                            <span class="rounded bg-green-50 px-2 py-1 text-xs font-black uppercase tracking-wide text-green-700">{{ $user->status }}</span>
                        </div>
                    </div>
                </section>

                <section class="rounded border border-slate-200 bg-white p-5 shadow-sm" data-reveal>
                    <h2 class="text-xl font-black text-courtigo-navy">Notifications</h2>
                    <div class="mt-4 space-y-3">
                        @forelse($notifications as $notification)
                            <div class="rounded bg-slate-50 p-3">
                                <p class="text-sm font-black text-courtigo-navy">{{ $notification->title }}</p>
                                <p class="mt-1 text-sm leading-5 text-slate-500">{{ $notification->message }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No notifications yet.</p>
                        @endforelse
                    </div>
                </section>
            </aside>
        </div>

        <section class="mt-6 rounded border border-slate-200 bg-white p-5 shadow-sm" data-reveal>
            <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Recommended</p>
                    <h2 class="mt-1 text-2xl font-black text-courtigo-navy">Available courts to try next</h2>
                </div>
                <a href="{{ route('home') }}#courts" class="text-sm font-black text-courtigo-blue hover:text-blue-700">View all courts</a>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($recommendedCourts as $court)
                    <a href="{{ route('courts.show', $court) }}" class="group overflow-hidden rounded border border-slate-200 transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="aspect-[4/3] overflow-hidden bg-slate-200">
                            <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="{{ $court->primaryImage() }}" alt="{{ $court->name }}">
                        </div>
                        <div class="p-4">
                            <p class="font-black text-courtigo-navy">{{ $court->name }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $court->city }} · ₱{{ number_format($court->hourly_rate) }}/hr</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </section>
@endsection
