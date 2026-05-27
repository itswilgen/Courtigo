@extends('layouts.admin')

@section('title', 'Court Details')

@section('content')
<div class="bg-white content-card p-3 mb-4">
    <div class="d-flex flex-wrap justify-content-between gap-3">
        <div>
            <h2 class="h4">{{ $court->name }}</h2>
            <p class="text-muted mb-1">{{ $court->location }}</p>
            <p class="mb-1">Owner: {{ $court->owner?->name ?? $court->vendorProfile?->user?->name ?? 'N/A' }}</p>
            <p class="mb-0">Price: {{ number_format($court->price ?? $court->hourly_rate, 2) }}</p>
        </div>
        <div class="d-flex align-items-start gap-2">
            <form method="POST" action="{{ route('admin.courts.approve', $court) }}">@csrf @method('PATCH')<button class="btn btn-success">Approve</button></form>
            <form method="POST" action="{{ route('admin.courts.suspend', $court) }}">@csrf @method('PATCH')<button class="btn btn-warning">Suspend</button></form>
        </div>
    </div>
</div>

<div class="bg-white content-card p-3">
    <h2 class="h5">Recent Bookings</h2>
    <table class="table">
        <thead><tr><th>User</th><th>Date</th><th>Slot</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($court->bookings as $booking)
            <tr>
                <td>{{ $booking->user?->name }}</td>
                <td>{{ optional($booking->booking_date)->format('M d, Y') }}</td>
                <td>{{ $booking->time_slot ?? trim(($booking->starts_at ?? '').' - '.($booking->ends_at ?? '')) }}</td>
                <td>{{ $booking->status }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-muted">No bookings for this court.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
