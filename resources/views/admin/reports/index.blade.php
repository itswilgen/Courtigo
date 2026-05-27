@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="bg-white content-card p-3">
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-4">
            <select class="form-select" name="status">
                <option value="">All statuses</option>
                @foreach (['pending', 'resolved'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto"><button class="btn btn-primary">Filter</button></div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>User</th><th>Booking</th><th>Message</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $report->user?->name ?? $report->reporter?->name ?? 'N/A' }}</td>
                    <td>{{ $report->booking?->reference ?? ($report->booking ? '#'.$report->booking->id : 'N/A') }}</td>
                    <td>{{ str($report->message ?? $report->description)->limit(80) }}</td>
                    <td><span class="badge text-bg-secondary">{{ $report->status }}</span></td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.reports.show', $report) }}">View</a>
                            <form method="POST" action="{{ route('admin.reports.status', $report) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $report->status === 'resolved' ? 'pending' : 'resolved' }}">
                                <button class="btn btn-sm btn-outline-primary">{{ $report->status === 'resolved' ? 'Mark Pending' : 'Resolve' }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-muted">No reports found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $reports->links() }}
</div>
@endsection
