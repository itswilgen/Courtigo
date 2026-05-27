@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="row g-4">
    <div class="col-xl-7">
        <div class="admin-card p-4">
            <div class="admin-kicker mb-2">Admin profile</div>
            <h2 class="h4 fw-black mb-3">Workspace Settings</h2>
            <p class="text-muted mb-4">
                Manage the current admin session and keep this area ready for future facility preferences, notifications, and staff controls.
            </p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Name</div>
                        <div class="fw-bold">{{ auth()->user()?->name ?? 'Admin' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Email</div>
                        <div class="fw-bold">{{ auth()->user()?->email ?? 'Not available' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Role</div>
                        <div class="fw-bold">{{ auth()->user()?->role ?? 'admin' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded border p-3 h-100">
                        <div class="small text-muted text-uppercase fw-bold">Status</div>
                        <div class="fw-bold">{{ auth()->user()?->status ?? 'active' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="admin-card p-4">
            <div class="admin-kicker mb-2">Session</div>
            <h2 class="h5 fw-black mb-3">Account Access</h2>
            <p class="text-muted">Use logout when leaving the facility desk or sharing a device.</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger fw-bold" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
