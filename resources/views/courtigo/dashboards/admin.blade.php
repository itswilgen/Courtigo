@extends('layouts.courtigo', ['title' => 'Admin Dashboard | Courtigo'])

@section('content')
    <x-dashboard-shell title="Super Admin Dashboard" eyebrow="Platform revenue, vendors, bookings">
        <div class="grid gap-4 md:grid-cols-5">
            <x-metric-card label="Total users" :value="$metrics['users']" />
            <x-metric-card label="Vendors" :value="$metrics['vendors']" />
            <x-metric-card label="Bookings" :value="$metrics['bookings']" />
            <x-metric-card label="Revenue" value="₱{{ number_format($metrics['revenue']) }}" />
            <x-metric-card label="Plans" :value="$metrics['subscriptions']" />
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-2">
            <section class="rounded border border-slate-200 bg-white p-5">
                <h2 class="text-xl font-black text-courtigo-navy">Vendor approvals</h2>
                <div class="mt-4 space-y-3">
                    @foreach($vendors as $vendor)
                        <div class="flex items-center justify-between gap-4 rounded border border-slate-200 p-4">
                            <div>
                                <p class="font-black text-courtigo-navy">{{ $vendor->business_name }}</p>
                                <p class="text-sm text-slate-500">{{ $vendor->user->email }} · {{ $vendor->city }}</p>
                            </div>
                            <span class="rounded px-3 py-1 text-sm font-bold {{ $vendor->status === 'approved' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($vendor->status) }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
            <section class="rounded border border-slate-200 bg-white p-5">
                <h2 class="text-xl font-black text-courtigo-navy">Most booked courts</h2>
                <div class="mt-4 space-y-3">
                    @foreach($courts as $court)
                        <div class="rounded border border-slate-200 p-4">
                            <div class="flex items-center justify-between">
                                <p class="font-black text-courtigo-navy">{{ $court->name }}</p>
                                <span class="text-sm font-bold text-courtigo-amber">★ {{ $court->rating_average }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">{{ $court->vendorProfile->business_name }} · ₱{{ number_format($court->hourly_rate) }}/hr</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </x-dashboard-shell>
@endsection
