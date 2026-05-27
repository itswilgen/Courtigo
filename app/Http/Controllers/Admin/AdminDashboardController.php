<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use App\Models\Report;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalCourts' => Court::count(),
            'totalBookings' => Booking::count(),
            'activeCourts' => Court::whereIn('status', ['active', 'approved'])->count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'todayBookings' => Booking::whereDate('booking_date', $today)->count(),
            'openReports' => Report::whereIn('status', ['pending', 'open'])->count(),
            'recentBookings' => Booking::with(['user', 'court'])->latest()->take(10)->get(),
            'recentUsers' => User::latest()->take(10)->get(),
            'courtQueue' => Court::with(['owner', 'vendorProfile.user'])
                ->whereIn('status', ['pending', 'suspended'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
