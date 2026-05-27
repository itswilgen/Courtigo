@extends('layouts.admin')

@section('title', 'Report Details')

@section('content')
<div class="bg-white content-card p-3">
    <div class="d-flex flex-wrap justify-content-between gap-3">
        <div>
            <h2 class="h4">Report #{{ $report->id }}</h2>
            <p class="mb-1">User: {{ $report->user?->name ?? $report->reporter?->name ?? 'N/A' }}</p>
            <p class="mb-1">Booking: {{ $report->booking?->reference ?? ($report->booking ? '#'.$report->booking->id : 'N/A') }}</p>
            <p class="mb-1">Court: {{ $report->booking?->court?->name ?? $report->court?->name ?? 'N/A' }}</p>
            <p class="mb-3">Status: <strong>{{ $report->status }}</strong></p>
            <p class="mb-0">{{ $report->message ?? $report->description }}</p>
        </div>
        <form method="POST" action="{{ route('admin.reports.status', $report) }}">
            @csrf @method('PATCH')
            <select class="form-select mb-2" name="status">
                <option value="pending" @selected($report->status === 'pending')>Pending</option>
                <option value="resolved" @selected($report->status === 'resolved')>Resolved</option>
            </select>
            <button class="btn btn-primary">Update Status</button>
        </form>
    </div>
</div>
@endsection
