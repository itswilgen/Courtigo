@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-kicker">Support queue</div>
        <h2 class="h4 fw-black mb-1">Reports</h2>
        <p class="text-muted mb-0">Track submitted issues and keep unresolved items visible.</p>
    </div>
</div>

<div class="content-card overflow-hidden">
    <form class="admin-filter-bar" method="GET">
        <div class="row g-2 align-items-end">
            <div class="col-md-4 col-xl-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'resolved'] as $status)
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
            <thead><tr><th>User</th><th>Booking</th><th>Message</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $report->user?->name ?? $report->reporter?->name ?? 'N/A' }}</td>
                    <td>{{ $report->booking?->reference ?? ($report->booking ? '#'.$report->booking->id : 'N/A') }}</td>
                    <td>{{ str($report->message ?? $report->description)->limit(80) }}</td>
                    <td>
                        <span class="status-pill {{ $report->status === 'resolved' ? 'is-success' : 'is-warning' }}">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.reports.show', $report) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.reports.status', $report) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $report->status === 'resolved' ? 'pending' : 'resolved' }}">
                                <button class="btn btn-sm btn-outline-primary">{{ $report->status === 'resolved' ? 'Mark Pending' : 'Resolve' }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="admin-empty-state">No reports found.</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $reports->links() }}
</div>
@endsection
