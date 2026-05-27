@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex flex-column gap-4">
    <section class="admin-card overflow-hidden">
        <div class="row g-0 align-items-stretch">
            <div class="col-lg-8 p-4 p-xl-5">
                <div class="admin-kicker mb-2">Court operations</div>
                <h2 class="display-6 fw-black mb-3">Keep today&apos;s bookings, courts, and member activity on track.</h2>
                <p class="text-muted mb-4" style="max-width: 720px;">
                    Review booking flow, court availability, user activity, and open reports from one workspace built for facility management.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-success fw-bold" href="{{ route('admin.bookings.index') }}">
                        <i class="bi bi-calendar-check me-2"></i>Manage Bookings
                    </a>
                    <a class="btn btn-outline-primary fw-bold" href="{{ route('admin.courts.index') }}">
                        <i class="bi bi-grid-3x3-gap me-2"></i>Review Courts
                    </a>
                </div>
            </div>
            <div class="col-lg-4 bg-dark text-white p-4 p-xl-5">
                <div class="h-100 d-flex flex-column justify-content-between gap-4">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Today&apos;s bookings</div>
                        <div class="display-4 fw-black">{{ number_format($todayBookings) }}</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="rounded p-3" style="background: rgba(255, 255, 255, .08);">
                                <div class="small text-white-50">Pending</div>
                                <div class="h4 mb-0 fw-black">{{ number_format($pendingBookings) }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded p-3" style="background: rgba(255, 255, 255, .08);">
                                <div class="small text-white-50">Reports</div>
                                <div class="h4 mb-0 fw-black">{{ number_format($openReports) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-3">
        @foreach ([
            ['label' => 'Users', 'value' => $totalUsers, 'icon' => 'bi-people', 'hint' => 'Registered players, vendors, and admins'],
            ['label' => 'Courts', 'value' => $totalCourts, 'icon' => 'bi-grid-3x3-gap', 'hint' => number_format($activeCourts).' ready or approved'],
            ['label' => 'Bookings', 'value' => $totalBookings, 'icon' => 'bi-calendar2-week', 'hint' => 'All reservations in the system'],
            ['label' => 'Open Reports', 'value' => $openReports, 'icon' => 'bi-flag', 'hint' => 'Needs admin follow-up'],
        ] as $metric)
            <div class="col-md-6 col-xl-3">
                <div class="admin-card metric-card h-100 p-4">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">{{ $metric['label'] }}</div>
                            <div class="display-6 fw-black">{{ number_format($metric['value']) }}</div>
                        </div>
                        <span class="metric-icon"><i class="bi {{ $metric['icon'] }}"></i></span>
                    </div>
                    <p class="small text-muted mb-0 mt-3">{{ $metric['hint'] }}</p>
                </div>
            </div>
        @endforeach
    </section>

    <section class="row g-4">
        <div class="col-xl-8">
            <div class="admin-card p-3 p-lg-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <div class="admin-kicker">Booking activity</div>
                        <h2 class="h5 fw-black mb-0">Recent Bookings</h2>
                    </div>
                    <a class="btn btn-sm btn-outline-primary fw-bold" href="{{ route('admin.bookings.index') }}">View all</a>
                </div>
                <div class="table-responsive">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Court</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $booking->user?->name ?? 'Deleted user' }}</div>
                                    <div class="small text-muted">{{ $booking->reference ?? '#'.$booking->id }}</div>
                                </td>
                                <td>{{ $booking->court?->name ?? 'Deleted court' }}</td>
                                <td>{{ optional($booking->booking_date)->format('M d, Y') }}</td>
                                <td><span class="status-pill bg-light text-secondary">{{ $booking->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted py-4">No bookings yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="admin-card p-3 p-lg-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <div class="admin-kicker">Members</div>
                        <h2 class="h5 fw-black mb-0">Recent Users</h2>
                    </div>
                    <a class="btn btn-sm btn-outline-primary fw-bold" href="{{ route('admin.users.index') }}">View all</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($recentUsers as $user)
                        <a class="list-group-item list-group-item-action px-0 d-flex align-items-center justify-content-between gap-3" href="{{ route('admin.users.show', $user) }}">
                            <span class="d-flex align-items-center gap-3">
                                <span class="admin-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                <span>
                                    <span class="d-block fw-bold">{{ $user->name }}</span>
                                    <span class="d-block small text-muted">{{ $user->email }}</span>
                                </span>
                            </span>
                            <span class="badge text-bg-light">{{ $user->role }}</span>
                        </a>
                    @empty
                        <div class="text-muted">No users yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-xl-7">
            <div class="admin-card p-3 p-lg-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <div class="admin-kicker">Court readiness</div>
                        <h2 class="h5 fw-black mb-0">Court Review Queue</h2>
                    </div>
                    <a class="btn btn-sm btn-outline-primary fw-bold" href="{{ route('admin.courts.index') }}">Manage courts</a>
                </div>
                <div class="vstack gap-3">
                    @forelse ($courtQueue as $court)
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 rounded border p-3">
                            <div>
                                <div class="fw-bold">{{ $court->name }}</div>
                                <div class="small text-muted">{{ $court->location }} · {{ $court->owner?->name ?? $court->vendorProfile?->user?->name ?? 'No owner listed' }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="status-pill bg-light text-secondary">{{ $court->status }}</span>
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.courts.show', $court) }}">Open</a>
                            </div>
                        </div>
                    @empty
                        <div class="rounded border p-4 text-muted">No courts currently need review.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div id="settings" class="admin-card p-3 p-lg-4 h-100">
                <div class="admin-kicker">Workspace health</div>
                <h2 class="h5 fw-black mb-3">Operational Focus</h2>
                <div class="vstack gap-3">
                    <div class="d-flex gap-3">
                        <span class="metric-icon"><i class="bi bi-check2-circle"></i></span>
                        <div>
                            <div class="fw-bold">Booking follow-up</div>
                            <div class="small text-muted">Resolve pending bookings before facility traffic peaks.</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <span class="metric-icon"><i class="bi bi-shield-check"></i></span>
                        <div>
                            <div class="fw-bold">Court quality</div>
                            <div class="small text-muted">Keep inactive, suspended, and pending courts visible to admins.</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <span class="metric-icon"><i class="bi bi-chat-left-text"></i></span>
                        <div>
                            <div class="fw-bold">User support</div>
                            <div class="small text-muted">Monitor reports and account issues from the admin navigation.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
