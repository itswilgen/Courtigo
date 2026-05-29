@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="content-card p-4">
            <div class="admin-kicker mb-2">Account</div>
            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="admin-avatar" style="width: 48px; height: 48px;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                <div>
                    <h2 class="h5 fw-black mb-0">{{ $user->name }}</h2>
                    <span class="status-pill {{ $user->is_banned ? 'is-danger' : 'is-success' }}">
                        {{ $user->is_banned ? 'Banned' : 'Active' }}
                    </span>
                </div>
            </div>
            <p class="text-muted mb-1">{{ $user->email }}</p>
            <div class="row g-2 mt-3">
                <div class="col-6">
                    <div class="rounded border p-3">
                        <div class="small text-muted text-uppercase fw-bold">Role</div>
                        <div class="fw-bold">{{ $user->role }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="rounded border p-3">
                        <div class="small text-muted text-uppercase fw-bold">Student ID</div>
                        <div class="fw-bold">{{ $user->student_id ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="content-card overflow-hidden mb-4">
            <div class="p-4 border-bottom">
                <div class="admin-kicker">Activity</div>
                <h2 class="h5 fw-black mb-0">Bookings</h2>
            </div>
            <div class="table-responsive">
            <table class="table admin-table">
                <thead><tr><th>Court</th><th>Date</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($user->bookings as $booking)
                    <tr>
                        <td>{{ $booking->court?->name }}</td>
                        <td>{{ optional($booking->booking_date)->format('M d, Y') }}</td>
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
                    <tr><td colspan="3"><div class="admin-empty-state">No bookings.</div></td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
        <div class="content-card p-4">
            <div class="admin-kicker">Inventory</div>
            <h2 class="h5 fw-black mb-3">Owned Courts</h2>
            <ul class="list-group list-group-flush">
                @forelse ($user->courts as $court)
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <a class="fw-bold text-decoration-none" href="{{ route('admin.courts.show', $court) }}">{{ $court->name }}</a>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </li>
                @empty
                    <li class="list-group-item px-0 text-muted">No owned courts.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
