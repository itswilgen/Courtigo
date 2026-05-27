@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="bg-white content-card p-3">
    <div class="d-flex flex-wrap justify-content-between gap-3">
        <div>
            <h2 class="h4">{{ $booking->reference ?? 'Booking #'.$booking->id }}</h2>
            <p class="mb-1">Customer: {{ $booking->user?->name ?? 'Deleted user' }}</p>
            <p class="mb-1">Court: {{ $booking->court?->name ?? 'Deleted court' }}</p>
            <p class="mb-1">Date: {{ optional($booking->booking_date)->format('M d, Y') }}</p>
            <p class="mb-1">Time: {{ $booking->time_slot ?? trim(($booking->starts_at ?? '').' - '.($booking->ends_at ?? '')) }}</p>
            <p class="mb-0">Status: <strong>{{ $booking->status }}</strong></p>
        </div>
        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">
            @csrf @method('PATCH')
            <button class="btn btn-danger">Cancel Booking</button>
        </form>
    </div>
</div>
@endsection
