@extends('layouts.admin')

@section('title', 'Report Details')

@section('content')
<div class="content-card p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-4">
        <div class="flex-grow-1">
            <div class="admin-kicker mb-2">Support issue</div>
            <h2 class="h4 fw-black mb-3">Report #{{ $report->id }}</h2>
            <span class="status-pill {{ $report->status === 'resolved' ? 'is-success' : 'is-warning' }}">
                {{ $report->status }}
            </span>
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">User</div>
                        <div class="fw-bold">{{ $report->user?->name ?? $report->reporter?->name ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Booking</div>
                        <div class="fw-bold">{{ $report->booking?->reference ?? ($report->booking ? '#'.$report->booking->id : 'N/A') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Court</div>
                        <div class="fw-bold">{{ $report->booking?->court?->name ?? $report->court?->name ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="rounded border p-3 mt-4">
                <div class="small text-muted text-uppercase fw-bold mb-2">Message</div>
                <p class="mb-0">{{ $report->message ?? $report->description }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.reports.status', $report) }}">
            @csrf @method('PATCH')
            <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
            <select class="form-select mb-2" name="status">
                <option value="pending" @selected($report->status === 'pending')>Pending</option>
                <option value="resolved" @selected($report->status === 'resolved')>Resolved</option>
            </select>
            <button class="btn btn-primary">Update Status</button>
        </form>
    </div>
</div>
@endsection
