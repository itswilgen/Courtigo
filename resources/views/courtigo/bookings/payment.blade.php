@extends('layouts.courtigo', ['title' => 'Payment Method | Courtigo'])

@php
    $selectedMethod = old('payment_method', $booking->payment?->provider ?? 'gcash');
    $accentClasses = [
        'blue' => 'bg-blue-50 text-blue-700 border-blue-100',
        'slate' => 'bg-slate-100 text-slate-700 border-slate-200',
        'green' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-100',
    ];
    $iconClasses = [
        'blue' => 'bg-blue-600 text-white',
        'slate' => 'bg-slate-800 text-white',
        'green' => 'bg-emerald-600 text-white',
        'amber' => 'bg-amber-500 text-white',
    ];
    $methodIcons = [
        'gcash' => 'G',
        'bank_transfer' => 'B',
        'paymaya' => 'M',
        'cash_venue' => 'C',
    ];
@endphp

@section('content')
    <style>
        .payment-shell {
            background:
                linear-gradient(180deg, #0f172a 0%, #111827 58%, #f8fafc 58%, #f8fafc 100%);
        }

        .payment-panel {
            box-shadow: 0 24px 80px rgb(15 23 42 / 0.12);
        }

        .payment-option {
            min-height: 184px;
        }

        .payment-option:has(input:checked) {
            border-color: #3B82F6;
            background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
            box-shadow: 0 18px 40px rgb(59 130 246 / 0.16);
        }

        .payment-option:has(input:checked) .payment-check {
            border-color: #3B82F6;
            background: #3B82F6;
            color: #ffffff;
        }

        .payment-option:has(input:checked) .payment-selected-label {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <section class="payment-shell">
        <div class="mx-auto max-w-7xl px-4 pt-10 sm:px-6 lg:px-8">
            <div class="grid gap-8 pb-8 text-white lg:grid-cols-[1fr_420px] lg:items-end">
                <div data-reveal>
                    <p class="text-sm font-black uppercase tracking-wide text-emerald-300">Secure your reservation</p>
                    <h1 class="mt-3 max-w-3xl text-3xl font-black tracking-tight sm:text-4xl">Choose how you want to pay.</h1>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300">
                        Your court slot is held while you select a payment method. The venue can verify payment details using your booking reference.
                    </p>
                </div>

                <div class="rounded border border-white/10 bg-white/10 p-4 backdrop-blur" data-reveal>
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-black uppercase tracking-wide text-slate-400">Booking reference</p>
                            <p class="mt-2 text-2xl font-black">{{ $booking->reference }}</p>
                        </div>
                        <span class="rounded bg-emerald-400/10 px-3 py-1 text-xs font-black uppercase tracking-wide text-emerald-200">Slot held</span>
                    </div>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-bold text-blue-800" data-reveal>
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 pb-10 lg:grid-cols-[1fr_390px]">
            <form class="payment-panel overflow-hidden rounded border border-slate-200 bg-white" method="POST" action="{{ route('bookings.payment.store', $booking) }}" data-reveal>
                @csrf
                <div class="border-b border-slate-200 p-5 sm:p-6">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Payment options</p>
                            <h2 class="mt-1 text-2xl font-black text-courtigo-navy">Select one method</h2>
                        </div>
                        <div class="flex items-center gap-2 text-xs font-black uppercase tracking-wide text-slate-500">
                            <span class="grid h-7 w-7 place-items-center rounded-full bg-courtigo-navy text-white">1</span>
                            <span class="h-px w-8 bg-slate-200"></span>
                            <span class="grid h-7 w-7 place-items-center rounded-full bg-courtigo-blue text-white">2</span>
                            <span class="h-px w-8 bg-slate-200"></span>
                            <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-100 text-slate-500">3</span>
                        </div>
                    </div>
                    @error('payment_method')
                        <p class="mt-3 rounded border border-red-100 bg-red-50 px-3 py-2 text-sm font-bold text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-6">
                    @foreach($paymentMethods as $value => $method)
                        <label class="payment-option group relative cursor-pointer overflow-hidden rounded border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-courtigo-blue hover:shadow-lg">
                            <input class="peer sr-only" type="radio" name="payment_method" value="{{ $value }}" @checked($selectedMethod === $value)>
                            <span class="flex h-full flex-col justify-between gap-5">
                                <span>
                                    <span class="flex items-start justify-between gap-4">
                                        <span class="grid h-12 w-12 place-items-center rounded text-lg font-black {{ $iconClasses[$method['accent']] ?? 'bg-slate-800 text-white' }}">
                                            {{ $methodIcons[$value] ?? 'P' }}
                                        </span>
                                        <span class="payment-check grid h-7 w-7 shrink-0 place-items-center rounded-full border border-slate-300 bg-white text-xs font-black text-white transition">✓</span>
                                    </span>
                                    <span class="mt-5 block text-xl font-black text-courtigo-navy">{{ $method['label'] }}</span>
                                    <span class="mt-2 block text-sm font-semibold leading-6 text-slate-500">{{ $method['detail'] }}</span>
                                </span>
                                <span class="flex items-center justify-between gap-3">
                                    <span class="inline-flex rounded border px-2.5 py-1 text-xs font-black uppercase tracking-wide {{ $accentClasses[$method['accent']] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                        {{ $method['hint'] }}
                                    </span>
                                    <span class="payment-selected-label translate-y-1 text-xs font-black uppercase tracking-wide text-courtigo-blue opacity-0 transition">
                                        Selected
                                    </span>
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                    <a href="{{ route('courts.show', $booking->court) }}" class="text-sm font-black text-slate-500 hover:text-courtigo-blue">Change slot</a>
                    <button class="rounded bg-courtigo-green px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-green-600 sm:min-w-56" type="submit">
                        Confirm payment method
                    </button>
                </div>
            </form>

            <aside class="space-y-5 lg:sticky lg:top-24 lg:self-start">
                <section class="payment-panel overflow-hidden rounded border border-slate-200 bg-white" data-reveal>
                    <img class="h-48 w-full object-cover" src="{{ $booking->court?->primaryImage() }}" alt="{{ $booking->court?->name ?? 'Reserved court' }}">
                    <div class="p-5">
                        <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Reservation summary</p>
                        <h2 class="mt-2 text-2xl font-black text-courtigo-navy">{{ $booking->court?->name ?? 'Reserved court' }}</h2>
                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="font-semibold text-slate-500">Date</span>
                                <span class="text-right font-black text-courtigo-navy">{{ $booking->booking_date?->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="font-semibold text-slate-500">Time</span>
                                <span class="text-right font-black text-courtigo-navy">{{ substr($booking->starts_at, 0, 5) }} - {{ substr($booking->ends_at, 0, 5) }}</span>
                            </div>
                            <div class="flex justify-between gap-4 border-t border-slate-100 pt-3">
                                <span class="font-semibold text-slate-500">Amount</span>
                                <span class="text-right text-xl font-black text-courtigo-navy">₱{{ number_format($booking->total_amount) }}</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded border border-slate-200 bg-white p-5 shadow-sm" data-reveal>
                    <h2 class="text-lg font-black text-courtigo-navy">Payment note</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Courtigo records your selected method for the venue. Online transfer details can be verified at the facility desk before play.
                    </p>
                </section>
            </aside>
            </div>
        </div>
    </section>
@endsection
