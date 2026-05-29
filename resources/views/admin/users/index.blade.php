@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-kicker">Identity management</div>
        <h2 class="h4 fw-black mb-1">Users</h2>
        <p class="text-muted mb-0">Review accounts, roles, and access status across Courtigo.</p>
    </div>
</div>

<div class="content-card overflow-hidden">
    <form class="admin-filter-bar" method="GET">
        <div class="row g-2 align-items-end">
            <div class="col-md-4 col-xl-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Role</label>
                <select class="form-select" name="role">
                    <option value="">All roles</option>
                    @foreach (['admin', 'owner', 'customer'] as $role)
                        <option value="{{ $role }}" @selected(request('role') === $role)>{{ ucfirst($role) }}</option>
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
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td><span class="status-pill is-neutral">{{ $user->role }}</span></td>
                    <td>
                        <span class="status-pill {{ $user->is_banned ? 'is-danger' : 'is-success' }}">
                            {{ $user->is_banned ? 'Banned' : 'Active' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.users.show', $user) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ $user->is_banned ? route('admin.users.unban', $user) : route('admin.users.ban', $user) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning">{{ $user->is_banned ? 'Unban' : 'Ban' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="admin-empty-state">No users found.</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection
