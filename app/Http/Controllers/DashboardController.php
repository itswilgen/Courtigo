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
        $user = request()->user();
        $bookings = Booking::with(['court.images', 'payment'])
            ->where('user_id', $user->id)
            ->latest('booking_date')
            ->latest()
            ->get();

        return view('courtigo.dashboards.player', [
            'user' => $user,
            'bookings' => $bookings->take(6),
            'recommendedCourts' => Court::with('images')
                ->where('status', 'active')
                ->whereHas('timeSlots', fn ($query) => $query->where('status', 'available'))
                ->orderByDesc('rating_average')
                ->take(4)
                ->get(),
            'notifications' => $user->notifications()->latest()->take(3)->get(),
            'metrics' => [
                'bookings' => $bookings->count(),
                'confirmed' => $bookings->where('status', 'confirmed')->count(),
                'spent' => $bookings->sum('total_amount'),
                'favorites' => Court::where('status', 'active')->where('is_featured', true)->count(),
            ],
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
