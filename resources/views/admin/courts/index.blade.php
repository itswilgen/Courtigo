@extends('layouts.admin')

@section('title', 'Courts')

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-kicker">Facility inventory</div>
        <h2 class="h4 fw-black mb-1">Courts</h2>
        <p class="text-muted mb-0">Approve listings, watch suspended courts, and keep venues ready for booking.</p>
    </div>
</div>

<div class="content-card overflow-hidden">
    <form class="admin-filter-bar" method="GET">
        <div class="row g-2 align-items-end">
            <div class="col-md-4 col-xl-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'approved', 'suspended'] as $status)
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
            <thead><tr><th>Court</th><th>Owner</th><th>Location</th><th>Price</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($courts as $court)
                <tr>
                    <td><a href="{{ route('admin.courts.show', $court) }}">{{ $court->name }}</a></td>
                    <td>{{ $court->owner?->name ?? $court->vendorProfile?->user?->name ?? 'N/A' }}</td>
                    <td>{{ $court->location }}</td>
                    <td>{{ number_format($court->price ?? $court->hourly_rate, 2) }}</td>
                    <td>
                        <span class="status-pill @class([
                            'is-success' => $court->status === 'approved',
                            'is-warning' => $court->status === 'pending',
                            'is-danger' => $court->status === 'suspended',
                            'is-neutral' => ! in_array($court->status, ['approved', 'pending', 'suspended']),
                        ])">{{ $court->status }}</span>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.courts.show', $court) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.courts.approve', $court) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success">Approve</button></form>
                            <form method="POST" action="{{ route('admin.courts.suspend', $court) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning">Suspend</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="admin-empty-state">No courts found.</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $courts->links() }}
</div>
@endsection
