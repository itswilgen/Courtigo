@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="bg-white content-card p-3">
            <h2 class="h5">{{ $user->name }}</h2>
            <p class="text-muted mb-1">{{ $user->email }}</p>
            <p class="mb-1">Role: <strong>{{ $user->role }}</strong></p>
            <p class="mb-1">Student ID: {{ $user->student_id ?? 'N/A' }}</p>
            <p>Status: {{ $user->is_banned ? 'Banned' : 'Active' }}</p>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="bg-white content-card p-3 mb-4">
            <h2 class="h5">Bookings</h2>
            <table class="table">
                <thead><tr><th>Court</th><th>Date</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($user->bookings as $booking)
                    <tr><td>{{ $booking->court?->name }}</td><td>{{ optional($booking->booking_date)->format('M d, Y') }}</td><td>{{ $booking->status }}</td></tr>
                @empty
                    <tr><td colspan="3" class="text-muted">No bookings.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white content-card p-3">
            <h2 class="h5">Owned Courts</h2>
            <ul class="list-group list-group-flush">
                @forelse ($user->courts as $court)
                    <li class="list-group-item"><a href="{{ route('admin.courts.show', $court) }}">{{ $court->name }}</a></li>
                @empty
                    <li class="list-group-item text-muted">No owned courts.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
