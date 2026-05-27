@extends('layouts.admin')

@section('title', 'Courts')

@section('content')
<div class="bg-white content-card p-3">
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-4">
            <select class="form-select" name="status">
                <option value="">All statuses</option>
                @foreach (['pending', 'approved', 'suspended'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto"><button class="btn btn-primary">Filter</button></div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Court</th><th>Owner</th><th>Location</th><th>Price</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($courts as $court)
                <tr>
                    <td><a href="{{ route('admin.courts.show', $court) }}">{{ $court->name }}</a></td>
                    <td>{{ $court->owner?->name ?? $court->vendorProfile?->user?->name ?? 'N/A' }}</td>
                    <td>{{ $court->location }}</td>
                    <td>{{ number_format($court->price ?? $court->hourly_rate, 2) }}</td>
                    <td><span class="badge text-bg-secondary">{{ $court->status }}</span></td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.courts.show', $court) }}">View</a>
                            <form method="POST" action="{{ route('admin.courts.approve', $court) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success">Approve</button></form>
                            <form method="POST" action="{{ route('admin.courts.suspend', $court) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning">Suspend</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">No courts found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $courts->links() }}
</div>
@endsection
