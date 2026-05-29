@extends('layouts.courtigo', ['title' => 'Player Dashboard | Courtigo'])

@php
    $statusClasses = [
        'confirmed' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'completed' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'cancelled' => 'bg-red-50 text-red-700 ring-red-100',
    ];
@endphp

@section('content')
    <section class="bg-slate-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1fr_380px] lg:px-8 lg:py-12">
            <div class="flex flex-col justify-between gap-8">
                <div data-reveal>
                    <p class="text-sm font-black uppercase tracking-wide text-emerald-300">Player dashboard</p>
                    <h1 class="mt-3 max-w-3xl text-3xl font-black tracking-tight sm:text-4xl">Ready for your next rally, {{ $user->name }}.</h1>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300">Your reservations, court details, and updates are organized in one clean workspace.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                    @foreach ([
                        ['label' => 'Upcoming', 'value' => $metrics['upcoming']],
                        ['label' => 'Confirmed', 'value' => $metrics['confirmed']],
                        ['label' => 'Completed', 'value' => $metrics['completed']],
                        ['label' => 'Total spent', 'value' => '₱'.number_format($metrics['spent'])],
                    ] as $metric)
                        <div class="rounded border border-white/10 bg-white/5 p-4">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ $metric['label'] }}</p>
                            <p class="mt-2 text-2xl font-black">{{ $metric['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <aside class="rounded border border-white/10 bg-white p-5 text-slate-900 shadow-2xl shadow-slate-950/30" data-reveal>
                <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Next reservation</p>
                @if ($nextBooking)
                    <div class="mt-4 overflow-hidden rounded bg-slate-100">
                        <img class="h-44 w-full object-cover" src="{{ $nextBooking->court?->primaryImage() }}" alt="{{ $nextBooking->court?->name ?? 'Reserved court' }}">
                    </div>
                    <h2 class="mt-4 text-2xl font-black text-courtigo-navy">{{ $nextBooking->court?->name ?? 'Reserved court' }}</h2>
                    <p class="mt-2 text-sm font-semibold text-slate-600">
                        {{ $nextBooking->booking_date?->format('M d, Y') }} · {{ substr($nextBooking->starts_at, 0, 5) }} - {{ substr($nextBooking->ends_at, 0, 5) }}
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <span class="rounded px-3 py-1 text-xs font-black uppercase tracking-wide ring-1 {{ $statusClasses[$nextBooking->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                            {{ ucfirst($nextBooking->status) }}
                        </span>
                        <span class="rounded bg-slate-100 px-3 py-1 text-xs font-black uppercase tracking-wide text-slate-600">{{ $nextBooking->reference }}</span>
                    </div>
                @else
                    <div class="mt-5 rounded border border-dashed border-slate-300 bg-slate-50 p-6">
                        <h2 class="text-xl font-black text-courtigo-navy">No upcoming reservation</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Pick a live slot and it will appear here after booking.</p>
                    </div>
                @endif
                <a href="{{ route('home') }}#courts" class="mt-5 inline-flex w-full justify-center rounded bg-courtigo-green px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-green-600">Find courts</a>
            </aside>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800" data-reveal>
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <section class="rounded border border-slate-200 bg-white shadow-sm" data-reveal>
                <div class="border-b border-slate-200 p-5">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Reservations</p>
                            <h2 class="mt-1 text-2xl font-black text-courtigo-navy">Booking timeline</h2>
                        </div>
                        <span class="text-sm font-bold text-slate-500">{{ $bookings->count() }} recent</span>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <article class="grid gap-4 p-5 sm:grid-cols-[104px_1fr_auto] sm:items-center">
                            <img class="h-24 w-full rounded object-cover sm:w-24" src="{{ $booking->court?->primaryImage() }}" alt="{{ $booking->court?->name ?? 'Court booking' }}">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-black text-courtigo-navy">{{ $booking->court?->name ?? 'Reserved court' }}</h3>
                                    <span class="rounded px-2.5 py-1 text-xs font-black uppercase tracking-wide ring-1 {{ $statusClasses[$booking->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm font-semibold text-slate-600">
                                    {{ $booking->booking_date?->format('M d, Y') }} · {{ substr($booking->starts_at, 0, 5) }} - {{ substr($booking->ends_at, 0, 5) }}
                                </p>
                                <p class="mt-1 text-xs font-black uppercase tracking-wide text-slate-400">{{ $booking->reference }}</p>
                            </div>
                            <div class="flex items-center justify-between gap-4 sm:block sm:text-right">
                                <p class="text-sm font-semibold text-slate-500">Amount</p>
                                <p class="text-lg font-black text-courtigo-navy">₱{{ number_format($booking->total_amount) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="p-8 text-center">
                            <h3 class="text-xl font-black text-courtigo-navy">No bookings yet</h3>
                            <p class="mt-2 text-sm text-slate-500">Choose a court and reserve your first pickleball slot.</p>
                            <a href="{{ route('home') }}#courts" class="mt-5 inline-flex rounded bg-courtigo-green px-5 py-3 text-sm font-black text-white hover:bg-green-600">Browse courts</a>
                        </div>
                    @endforelse
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded border border-slate-200 bg-white p-5 shadow-sm" data-reveal>
                    <div class="flex items-center gap-3">
                        <span class="grid h-12 w-12 place-items-center rounded bg-courtigo-navy text-lg font-black text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <div>
                            <h2 class="font-black text-courtigo-navy">{{ $user->name }}</h2>
                            <p class="text-sm font-semibold text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded border border-slate-200 p-3">
                            <p class="font-bold text-slate-500">Role</p>
                            <p class="mt-1 font-black uppercase text-courtigo-navy">{{ $user->role }}</p>
                        </div>
                        <div class="rounded border border-slate-200 p-3">
                            <p class="font-bold text-slate-500">Status</p>
                            <p class="mt-1 font-black uppercase text-emerald-700">{{ $user->status }}</p>
                        </div>
                    </div>
                </section>

                <section class="rounded border border-slate-200 bg-white p-5 shadow-sm" data-reveal>
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-xl font-black text-courtigo-navy">Updates</h2>
                        <span class="rounded bg-slate-100 px-2.5 py-1 text-xs font-black text-slate-500">{{ $notifications->count() }}</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($notifications as $notification)
                            <div class="rounded border border-slate-100 bg-slate-50 p-3">
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
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Recommended</p>
                    <h2 class="mt-1 text-2xl font-black text-courtigo-navy">Available courts to try next</h2>
                </div>
                <a href="{{ route('home') }}#courts" class="text-sm font-black text-courtigo-blue hover:text-blue-700">View all courts</a>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($recommendedCourts as $court)
                    <a href="{{ route('courts.show', $court) }}" class="group overflow-hidden rounded border border-slate-200 transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="aspect-[4/3] overflow-hidden bg-slate-200">
                            <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="{{ $court->primaryImage() }}" alt="{{ $court->name }}">
                        </div>
                        <div class="p-4">
                            <p class="font-black text-courtigo-navy">{{ $court->name }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $court->city }} · ₱{{ number_format($court->hourly_rate) }}/hr</p>
                        </div>
                    </a>
                @empty
                    <div class="rounded border border-dashed border-slate-300 bg-slate-50 p-6 text-sm font-semibold text-slate-500 sm:col-span-2 lg:col-span-4">
                        No courts are available right now.
                    </div>
                @endforelse
            </div>
        </section>
    </section>
@endsection
