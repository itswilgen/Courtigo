@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-kicker">Reservation control</div>
        <h2 class="h4 fw-black mb-1">Bookings</h2>
        <p class="text-muted mb-0">Filter reservations by date, court, and status for faster operations review.</p>
    </div>
</div>

<div class="content-card overflow-hidden">
    <form class="admin-filter-bar" method="GET">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Date</label>
                <input class="form-control" type="date" name="booking_date" value="{{ request('booking_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Court</label>
                <select class="form-select" name="court_id">
                    <option value="">All courts</option>
                    @foreach ($courts as $court)
                        <option value="{{ $court->id }}" @selected((string) request('court_id') === (string) $court->id)>{{ $court->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto">
                <button class="btn btn-primary">
                    <i class="bi bi-funnel me-2"></i>Filter
                </button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead><tr><th>Reference</th><th>User</th><th>Court</th><th>Date</th><th>Slot</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->reference ?? '#'.$booking->id }}</a></td>
                    <td>{{ $booking->user?->name }}</td>
                    <td>{{ $booking->court?->name }}</td>
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
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.bookings.show', $booking) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-danger">Cancel</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="admin-empty-state">No bookings found.</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $bookings->links() }}
</div>
@endsection
