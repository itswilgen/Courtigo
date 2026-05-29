@extends('layouts.app-dashboard', ['title' => 'My Bookings | Courtigo'])

@php
    $statusClasses = [
        'confirmed' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'completed' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'cancelled' => 'bg-red-50 text-red-700 ring-red-100',
    ];

    $tabs = [
        'upcoming' => $bookings
            ->whereIn('status', ['pending', 'confirmed'])
            ->filter(fn ($booking) => $booking->booking_date?->isToday() || $booking->booking_date?->isFuture())
            ->values(),
        'completed' => $bookings->where('status', 'completed')->values(),
        'cancelled' => $bookings->where('status', 'cancelled')->values(),
    ];
@endphp

@section('content')
    <section class="space-y-6" data-booking-tabs>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Reservations</p>
                    <h1 class="mt-1 text-3xl font-black tracking-tight text-courtigo-navy">My Bookings</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Your court reservations remain powered by the existing booking flow.</p>
                </div>
                <a href="{{ route('courts.index') }}" class="rounded-2xl bg-courtigo-navy px-5 py-3 text-center text-sm font-black text-white transition hover:bg-blue-950">Book a court</a>
            </div>

            <div class="mt-5 grid gap-2 rounded-2xl bg-slate-100 p-1 sm:inline-grid sm:grid-cols-3">
                @foreach ($tabs as $key => $items)
                    <button class="rounded-xl px-4 py-2.5 text-sm font-black capitalize text-slate-600 transition data-[active=true]:bg-white data-[active=true]:text-courtigo-navy data-[active=true]:shadow-sm" type="button" data-tab-button="{{ $key }}" data-active="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $key }} ({{ $items->count() }})
                    </button>
                @endforeach
            </div>
        </div>

        @foreach ($tabs as $key => $items)
            <div class="space-y-4 {{ $loop->first ? '' : 'hidden' }}" data-tab-panel="{{ $key }}">
                @forelse($items as $booking)
                    <article class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-soft transition hover:-translate-y-0.5 hover:shadow-xl sm:grid-cols-[128px_1fr_auto] sm:items-center">
                        <img class="h-32 w-full rounded-2xl object-cover sm:w-32" src="{{ $booking->court?->primaryImage() }}" alt="{{ $booking->court?->name ?? 'Court booking' }}">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-xl font-black text-courtigo-navy">{{ $booking->court?->name ?? 'Reserved court' }}</h2>
                                <span class="rounded-full px-3 py-1 text-xs font-black uppercase tracking-wide ring-1 {{ $statusClasses[$booking->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">{{ ucfirst($booking->status) }}</span>
                            </div>
                            <p class="mt-2 text-sm font-semibold text-slate-600">{{ $booking->booking_date?->format('M d, Y') }} - {{ substr($booking->starts_at, 0, 5) }} to {{ substr($booking->ends_at, 0, 5) }}</p>
                            <p class="mt-1 text-xs font-black uppercase tracking-wide text-slate-400">{{ $booking->reference }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4 sm:text-right">
                            <p class="text-xs font-black uppercase tracking-wide text-slate-500">Amount</p>
                            <p class="mt-1 text-xl font-black text-courtigo-navy">PHP {{ number_format($booking->total_amount) }}</p>
                            @if ($booking->payment)
                                <p class="mt-1 text-xs font-bold uppercase text-slate-400">{{ str_replace('_', ' ', $booking->payment->provider) }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-sm">
                        <h2 class="text-xl font-black text-courtigo-navy">No {{ $key }} bookings</h2>
                        <p class="mt-2 text-sm text-slate-500">Reservations in this status will show up here.</p>
                    </div>
                @endforelse
            </div>
        @endforeach
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const root = document.querySelector('[data-booking-tabs]');
            if (!root) return;

            const buttons = root.querySelectorAll('[data-tab-button]');
            const panels = root.querySelectorAll('[data-tab-panel]');

            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    const key = button.dataset.tabButton;
                    buttons.forEach((item) => item.dataset.active = String(item === button));
                    panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.tabPanel !== key));
                });
            });
        })();
    </script>
@endpush
