@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex flex-column gap-4">
    <section class="admin-card p-4 p-xl-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="admin-kicker mb-2">Operations overview</div>
                <h2 class="display-6 fw-black mb-3">Manage Courtigo bookings, courts, vendors, and member activity.</h2>
                <p class="text-muted mb-0" style="max-width: 720px;">
                    This workspace is separated from the player experience and is built for daily sports facility operations.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="rounded border bg-light p-4">
                    <div class="small text-muted text-uppercase fw-bold">Total bookings</div>
                    <div class="display-5 fw-black">{{ number_format($metrics['bookings']) }}</div>
                    <a class="btn btn-sm btn-success fw-bold mt-2" href="{{ route('admin.bookings.index') }}">Open booking desk</a>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-3">
        @foreach ([
            ['label' => 'Total Users', 'value' => $metrics['users'], 'icon' => 'bi-people'],
            ['label' => 'Vendors', 'value' => $metrics['vendors'], 'icon' => 'bi-shop'],
            ['label' => 'Bookings', 'value' => $metrics['bookings'], 'icon' => 'bi-calendar-check'],
            ['label' => 'Revenue', 'value' => 'PHP '.number_format($metrics['revenue']), 'icon' => 'bi-cash-stack'],
            ['label' => 'Plans', 'value' => $metrics['subscriptions'], 'icon' => 'bi-card-checklist'],
        ] as $metric)
            <div class="col-md-6 col-xl">
                <div class="admin-card metric-card h-100 p-4">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">{{ $metric['label'] }}</div>
                            <div class="h2 fw-black mb-0">{{ is_numeric($metric['value']) ? number_format($metric['value']) : $metric['value'] }}</div>
                        </div>
                        <span class="metric-icon"><i class="bi {{ $metric['icon'] }}"></i></span>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    <section class="row g-4">
        <div class="col-xl-6">
            <div class="admin-card p-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <div class="admin-kicker">Vendors</div>
                        <h2 class="h5 fw-black mb-0">Vendor Status</h2>
                    </div>
                    <a class="btn btn-sm btn-outline-primary fw-bold" href="{{ route('admin.users.index', ['role' => 'vendor']) }}">View vendors</a>
                </div>
                <div class="vstack gap-3">
                    @forelse($vendors as $vendor)
                        <div class="d-flex align-items-center justify-content-between gap-3 rounded border p-3">
                            <div>
                                <div class="fw-bold">{{ $vendor->business_name }}</div>
                                <div class="small text-muted">{{ $vendor->user?->email }} &middot; {{ $vendor->city }}</div>
                            </div>
                            <span class="status-pill {{ $vendor->status === 'approved' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                {{ ucfirst($vendor->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="rounded border p-4 text-muted">No vendors found.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="admin-card p-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <div class="admin-kicker">Courts</div>
                        <h2 class="h5 fw-black mb-0">Most Booked Courts</h2>
                    </div>
                    <a class="btn btn-sm btn-outline-primary fw-bold" href="{{ route('admin.courts.index') }}">Manage courts</a>
                </div>
                <div class="vstack gap-3">
                    @forelse($courts as $court)
                        <div class="rounded border p-3">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="fw-bold">{{ $court->name }}</div>
                                <span class="badge text-bg-light">{{ $court->rating_average }} rating</span>
                            </div>
                            <div class="small text-muted mt-2">
                                {{ $court->vendorProfile?->business_name ?? 'No vendor listed' }} &middot; PHP {{ number_format($court->hourly_rate) }}/hr
                            </div>
                        </div>
                    @empty
                        <div class="rounded border p-4 text-muted">No courts found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
