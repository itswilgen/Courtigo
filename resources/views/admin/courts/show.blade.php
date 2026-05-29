@extends('layouts.admin')

@section('title', 'Court Details')

@section('content')
<div class="content-card p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div class="admin-kicker mb-2">Court profile</div>
            <h2 class="h4 fw-black mb-2">{{ $court->name }}</h2>
            <p class="text-muted mb-1">{{ $court->location }}</p>
            <div class="d-flex flex-wrap gap-2 mt-3">
                <span class="status-pill @class([
                    'is-success' => $court->status === 'approved',
                    'is-warning' => $court->status === 'pending',
                    'is-danger' => $court->status === 'suspended',
                    'is-neutral' => ! in_array($court->status, ['approved', 'pending', 'suspended']),
                ])">{{ $court->status }}</span>
                <span class="status-pill is-neutral">{{ number_format($court->price ?? $court->hourly_rate, 2) }} per hour</span>
            </div>
            <div class="mt-4">
                <div class="small text-muted text-uppercase fw-bold">Owner</div>
                <div class="fw-bold">{{ $court->owner?->name ?? $court->vendorProfile?->user?->name ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="d-flex align-items-start gap-2">
            <form method="POST" action="{{ route('admin.courts.approve', $court) }}">@csrf @method('PATCH')<button class="btn btn-success">Approve</button></form>
            <form method="POST" action="{{ route('admin.courts.suspend', $court) }}">@csrf @method('PATCH')<button class="btn btn-warning">Suspend</button></form>
        </div>
    </div>
</div>

<div class="content-card overflow-hidden">
    <div class="p-4 border-bottom">
        <div class="admin-kicker">Reservations</div>
        <h2 class="h5 fw-black mb-0">Recent Bookings</h2>
    </div>
    <div class="table-responsive">
    <table class="table admin-table">
        <thead><tr><th>User</th><th>Date</th><th>Slot</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($court->bookings as $booking)
            <tr>
                <td>{{ $booking->user?->name }}</td>
                <td>{{ optional($booking->booking_date)->format('M d, Y') }}</td>
                <td>{{ $booking->time_slot ?? trim(($booking->starts_at ?? '').' - '.($booking->ends_at ?? '')) }}</td>
                <td>
                    <span class="status-pill @class([
                        'is-success' => in_array($booking->status, ['confirmed', 'completed']),
                        'is-warning' => $booking->status === 'pending',
                        'is-danger' => $booking->status === 'cancelled',
                        'is-neutral' => ! in_array($booking->status, ['confirmed', 'completed', 'pending', 'cancelled']),
                    ])">{{ $booking->status }}</span>
                </td>
            </tr>
        @empty
            <tr><td colspan="4"><div class="admin-empty-state">No bookings for this court.</div></td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
