@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="bg-white content-card p-3">
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-4">
            <select class="form-select" name="role">
                <option value="">All roles</option>
                @foreach (['admin', 'owner', 'customer'] as $role)
                    <option value="{{ $role }}" @selected(request('role') === $role)>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge text-bg-light">{{ $user->role }}</span></td>
                    <td>{{ $user->is_banned ? 'Banned' : 'Active' }}</td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.users.show', $user) }}">View</a>
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
                <tr><td colspan="5" class="text-muted">No users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection
