@extends('layouts.courtigo', ['title' => 'Vendor Dashboard | Courtigo'])

@section('content')
    <x-dashboard-shell title="Vendor Dashboard" eyebrow="{{ $vendor?->business_name ?? 'Approved venue workspace' }}">
        <div class="grid gap-4 md:grid-cols-4">
            <x-metric-card label="Total bookings" :value="$bookings->count()" />
            <x-metric-card label="Monthly revenue" value="₱{{ number_format($revenue) }}" />
            <x-metric-card label="Active courts" :value="$vendor?->courts->count() ?? 0" />
            <x-metric-card label="Subscription" :value="$vendor?->activeSubscription?->plan?->name ?? 'Pending'" />
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-[1fr_360px]">
            <section class="rounded border border-slate-200 bg-white p-5">
                <h2 class="text-xl font-black text-courtigo-navy">Upcoming reservations</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                            <tr><th class="py-3">Reference</th><th>Court</th><th>Customer</th><th>Schedule</th><th>Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="py-3 font-bold text-courtigo-navy">{{ $booking->reference }}</td>
                                    <td>{{ $booking->court->name }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->booking_date->format('M d') }} {{ substr($booking->starts_at, 0, 5) }}</td>
                                    <td><span class="rounded bg-green-50 px-2 py-1 text-xs font-bold text-green-700">{{ $booking->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <aside class="rounded border border-slate-200 bg-white p-5">
                <h2 class="text-xl font-black text-courtigo-navy">Court operations</h2>
                <div class="mt-4 space-y-3">
                    @foreach($vendor?->courts ?? [] as $court)
                        <div class="rounded border border-slate-200 p-4">
                            <div class="flex items-center justify-between">
                                <p class="font-black text-courtigo-navy">{{ $court->name }}</p>
                                <span class="rounded bg-blue-50 px-2 py-1 text-xs font-bold text-courtigo-blue">{{ $court->status }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">{{ $court->city }} · {{ $court->bookings->count() }} bookings</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </x-dashboard-shell>
@endsection
