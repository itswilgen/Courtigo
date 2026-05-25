<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfile;

class DashboardController extends Controller
{
    public function player()
    {
        return view('courtigo.dashboards.player', [
            'bookings' => Booking::with('court')->latest()->take(5)->get(),
            'favoriteCourts' => Court::with('images')->where('is_featured', true)->take(3)->get(),
        ]);
    }

    public function vendor()
    {
        $vendor = VendorProfile::with(['courts.bookings', 'activeSubscription.plan'])
            ->where('status', 'approved')
            ->first();

        return view('courtigo.dashboards.vendor', [
            'vendor' => $vendor,
            'bookings' => Booking::with(['court', 'user'])->latest()->take(6)->get(),
            'revenue' => Payment::where('type', 'booking')->where('status', 'paid')->sum('amount'),
        ]);
    }

    public function admin()
    {
        return view('courtigo.dashboards.admin', [
            'metrics' => [
                'users' => User::count(),
                'vendors' => VendorProfile::count(),
                'bookings' => Booking::count(),
                'revenue' => Payment::where('status', 'paid')->sum('amount'),
                'subscriptions' => SubscriptionPlan::count(),
            ],
            'vendors' => VendorProfile::with('user')->latest()->take(6)->get(),
            'courts' => Court::with('vendorProfile')->orderByDesc('rating_average')->take(5)->get(),
        ]);
    }
}
