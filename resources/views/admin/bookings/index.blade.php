@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<div class="bg-white content-card p-3">
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><input class="form-control" type="date" name="booking_date" value="{{ request('booking_date') }}"></div>
        <div class="col-md-3">
            <select class="form-select" name="court_id">
                <option value="">All courts</option>
                @foreach ($courts as $court)
                    <option value="{{ $court->id }}" @selected((string) request('court_id') === (string) $court->id)>{{ $court->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">All statuses</option>
                @foreach (['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto"><button class="btn btn-primary">Filter</button></div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Reference</th><th>User</th><th>Court</th><th>Date</th><th>Slot</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->reference ?? '#'.$booking->id }}</a></td>
                    <td>{{ $booking->user?->name }}</td>
                    <td>{{ $booking->court?->name }}</td>
                    <td>{{ optional($booking->booking_date)->format('M d, Y') }}</td>
                    <td>{{ $booking->time_slot ?? trim(($booking->starts_at ?? '').' - '.($booking->ends_at ?? '')) }}</td>
                    <td><span class="badge text-bg-secondary">{{ $booking->status }}</span></td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.bookings.show', $booking) }}">View</a>
                            <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-danger">Cancel</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-muted">No bookings found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $bookings->links() }}
</div>
@endsection
