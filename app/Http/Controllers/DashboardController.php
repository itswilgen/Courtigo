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
        $bookings = $this->userBookings();

        $upcomingBookings = $bookings
            ->whereIn('status', ['pending', 'confirmed'])
            ->filter(fn (Booking $booking) => $booking->booking_date?->isToday() || $booking->booking_date?->isFuture())
            ->sortBy('booking_date')
            ->values();

        return view('courtigo.dashboards.player', [
            'user' => $user,
            'bookings' => $bookings->take(6),
            'nextBooking' => $upcomingBookings->first(),
            'upcomingBookings' => $upcomingBookings->take(3),
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
                'upcoming' => $upcomingBookings->count(),
                'completed' => $bookings->where('status', 'completed')->count(),
                'spent' => $bookings->sum('total_amount'),
                'favorites' => Court::where('status', 'active')->where('is_featured', true)->count(),
            ],
        ]);
    }

    public function courts()
    {
        return view('courtigo.courts.index', [
            'courts' => Court::with(['images', 'vendorProfile'])
                ->where('status', 'active')
                ->latest('is_featured')
                ->latest()
                ->take(12)
                ->get(),
        ]);
    }

    public function friends()
    {
        return view('courtigo.friends.index');
    }

    public function followed()
    {
        return view('courtigo.followed.index', [
            'courts' => Court::with(['images', 'vendorProfile'])
                ->where('status', 'active')
                ->where('is_featured', true)
                ->take(6)
                ->get(),
        ]);
    }

    public function bookings()
    {
        return view('courtigo.bookings.index', [
            'bookings' => $this->userBookings(),
        ]);
    }

    public function profile()
    {
        return view('courtigo.profile.show', [
            'user' => request()->user(),
            'bookings' => $this->userBookings(),
        ]);
    }

    public function settings()
    {
        return view('courtigo.settings.index', [
            'user' => request()->user(),
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

    private function userBookings()
    {
        return Booking::with(['court.images', 'payment'])
            ->where('user_id', request()->user()->id)
            ->latest('booking_date')
            ->latest()
            ->get();
    }
}
