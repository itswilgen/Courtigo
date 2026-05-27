<aside class="admin-sidebar" aria-label="Admin navigation">
    <div class="admin-sidebar-brand">
        <span class="brand-mark">CT</span>
        <span class="brand-copy">
            <span class="d-block fw-black text-white">COURTIGO</span>
            <span class="d-block small text-white-50">Admin operations</span>
        </span>
    </div>

    <nav class="admin-nav">
        @foreach ($adminNavItems as $item)
            <a class="admin-nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}"
               href="{{ route($item['route']) }}"
               title="{{ $item['label'] }}">
                <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>
                <span class="nav-label">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="admin-sidebar-footer">
        <div class="sidebar-helper mb-3 rounded p-3">
            <div class="small fw-bold text-white">Facility desk</div>
            <div class="small text-white-50">Keep bookings, courts, and reports moving.</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="admin-logout-button" type="submit" title="Logout">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <span class="nav-label">Logout</span>
            </button>
        </form>
    </div>
</aside>
