@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="content-card p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div class="admin-kicker mb-2">Reservation</div>
            <h2 class="h4 fw-black mb-3">{{ $booking->reference ?? 'Booking #'.$booking->id }}</h2>
            <span class="status-pill @class([
                'is-success' => in_array($booking->status, ['confirmed', 'completed']),
                'is-warning' => $booking->status === 'pending',
                'is-danger' => $booking->status === 'cancelled',
                'is-neutral' => ! in_array($booking->status, ['confirmed', 'completed', 'pending', 'cancelled']),
            ])">{{ $booking->status }}</span>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Customer</div>
                        <div class="fw-bold">{{ $booking->user?->name ?? 'Deleted user' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Court</div>
                        <div class="fw-bold">{{ $booking->court?->name ?? 'Deleted court' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Date</div>
                        <div class="fw-bold">{{ optional($booking->booking_date)->format('M d, Y') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Time</div>
                        <div class="fw-bold">{{ $booking->time_slot ?? trim(($booking->starts_at ?? '').' - '.($booking->ends_at ?? '')) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
            @csrf @method('PATCH')
            <button class="btn btn-danger">Cancel Booking</button>
        </form>
    </div>
</div>
@endsection
