@extends('layouts.app-dashboard', ['title' => 'My Bookings | Courtigo'])

@php
    $statusClasses = [
        'confirmed' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'completed' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'cancelled' => 'bg-red-50 text-red-700 ring-red-100',
    ];

    $tabs = [
        'upcoming' => [
            'label' => 'Upcoming Bookings',
            'items' => $bookings
                ->whereIn('status', ['pending', 'confirmed'])
                ->filter(fn ($booking) => $booking->booking_date?->isToday() || $booking->booking_date?->isFuture())
                ->values(),
        ],
        'completed' => [
            'label' => 'Completed Bookings',
            'items' => $bookings->where('status', 'completed')->values(),
        ],
        'cancelled' => [
            'label' => 'Cancelled Bookings',
            'items' => $bookings->where('status', 'cancelled')->values(),
        ],
    ];

    $displayStatus = fn ($key, $booking) => $key === 'upcoming' ? 'Upcoming' : ucfirst($booking->status);
@endphp

@section('content')
    <section class="space-y-6" data-booking-tabs>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Reservations</p>
                    <h1 class="mt-1 text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">My Bookings</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Review upcoming reservations, completed games, and cancelled bookings.</p>
                </div>
                <a href="{{ route('courts.index') }}" class="inline-flex justify-center rounded-2xl bg-courtigo-navy px-5 py-3 text-sm font-black text-white transition hover:bg-blue-950">Book a Court</a>
            </div>

            <div class="mt-5 grid gap-2 rounded-2xl bg-slate-100 p-1 sm:inline-grid sm:grid-cols-3">
                @foreach ($tabs as $key => $tab)
                    <button class="rounded-xl px-4 py-2.5 text-sm font-black text-slate-700 transition hover:text-courtigo-navy data-[active=true]:bg-white data-[active=true]:text-courtigo-navy data-[active=true]:shadow-sm" type="button" data-tab-button="{{ $key }}" data-active="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $tab['label'] }} ({{ $tab['items']->count() }})
                    </button>
                @endforeach
            </div>
        </div>

        @foreach ($tabs as $key => $tab)
            <div class="space-y-4 {{ $loop->first ? '' : 'hidden' }}" data-tab-panel="{{ $key }}">
                @forelse($tab['items'] as $booking)
                    @php
                        $court = $booking->court;
                        $vendor = $court?->vendorProfile?->business_name ?? 'Courtigo Partner';
                        $statusLabel = $displayStatus($key, $booking);
                        $statusClass = $key === 'upcoming'
                            ? 'bg-emerald-50 text-emerald-700 ring-emerald-100'
                            : ($statusClasses[$booking->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200');
                    @endphp

                    <article class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-soft lg:grid-cols-[144px_minmax(0,1fr)_220px] lg:items-center">
                        <img class="h-36 w-full rounded-2xl object-cover lg:h-32 lg:w-36" src="{{ $court?->primaryImage() }}" alt="{{ $court?->name ?? 'Court booking' }}">

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-xl font-black text-slate-900">{{ $court?->name ?? 'Reserved court' }}</h2>
                                <span class="rounded-full px-3 py-1 text-xs font-black uppercase tracking-wide ring-1 {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>
                            <p class="mt-2 text-sm font-black text-courtigo-navy">{{ $vendor }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-600">
                                {{ $booking->booking_date?->format('M d, Y') ?? 'Date pending' }}
                                <span class="text-slate-400">/</span>
                                {{ substr($booking->starts_at ?? '00:00', 0, 5) }} to {{ substr($booking->ends_at ?? '00:00', 0, 5) }}
                            </p>
                            <p class="mt-2 text-xs font-black uppercase tracking-wide text-slate-400">{{ $booking->reference }}</p>
                        </div>

                        <div class="space-y-3 rounded-2xl bg-slate-50 p-4">
                            <div>
                                <p class="text-xs font-black uppercase tracking-wide text-slate-500">Amount</p>
                                <p class="mt-1 text-xl font-black text-courtigo-navy">PHP {{ number_format($booking->total_amount) }}</p>
                            </div>
                            <div class="grid gap-2">
                                @if ($booking->status === 'pending')
                                    <a href="{{ route('bookings.payment', $booking) }}" class="rounded-2xl bg-courtigo-navy px-4 py-2.5 text-center text-sm font-black text-white transition hover:bg-blue-950">View Details</a>
                                @else
                                    <a href="{{ $court ? route('courts.show', $court) : route('courts.index') }}" class="rounded-2xl bg-courtigo-navy px-4 py-2.5 text-center text-sm font-black text-white transition hover:bg-blue-950">View Details</a>
                                @endif

                                @if ($key === 'upcoming')
                                    <button class="rounded-2xl border border-red-200 bg-white px-4 py-2.5 text-sm font-black text-red-700 transition hover:bg-red-50" type="button">Cancel</button>
                                @elseif ($key === 'completed')
                                    <a href="{{ $court ? route('courts.show', $court) : route('courts.index') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-center text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue">Rebook</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-sm">
                        <h2 class="text-xl font-black text-courtigo-navy">No {{ strtolower($tab['label']) }}</h2>
                        <p class="mt-2 text-sm text-slate-600">Bookings in this section will appear here once available.</p>
                    </div>
                @endforelse
            </div>
        @endforeach
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/booking-tabs.js') }}" defer></script>
@endpush
