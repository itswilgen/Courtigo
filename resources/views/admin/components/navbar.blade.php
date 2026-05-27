<header class="admin-topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="admin-icon-button" type="button" data-sidebar-toggle aria-label="Toggle admin sidebar">
            <i class="bi bi-layout-sidebar-inset"></i>
        </button>
        <div>
            <div class="admin-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
                <i class="bi bi-chevron-right"></i>
                <span>@yield('title', 'Dashboard')</span>
            </div>
            <h1 class="h4 mb-0 fw-black">@yield('title', 'Admin Dashboard')</h1>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button class="admin-icon-button position-relative" type="button" aria-label="Notifications">
            <i class="bi bi-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle"></span>
        </button>
        <div class="dropdown">
            <button class="admin-profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="admin-avatar">{{ strtoupper(substr($adminUser?->name ?? 'A', 0, 1)) }}</span>
                <span class="d-none d-sm-block text-start">
                    <span class="d-block small fw-bold lh-1">{{ $adminUser?->name ?? 'Admin' }}</span>
                    <span class="d-block small text-muted">{{ $adminUser?->role ?? 'admin' }}</span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-sm">
                <h6 class="dropdown-header">Signed in as {{ $adminUser?->email ?? 'admin' }}</h6>
                <a class="dropdown-item" href="{{ route('admin.settings') }}">
                    <i class="bi bi-sliders me-2"></i>Settings
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger" type="submit">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
