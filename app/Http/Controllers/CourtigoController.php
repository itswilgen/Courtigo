<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfile;

class CourtigoController extends Controller
{
    public function index()
    {
        $courts = Court::query()
            ->with(['images', 'vendorProfile'])
            ->where('status', 'active')
            ->latest('is_featured')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'courts' => Court::count(),
            'vendors' => VendorProfile::where('status', 'approved')->count(),
            'bookings' => Booking::count(),
            'players' => User::where('role', 'player')->count(),
        ];

        return view('courtigo.home', [
            'courts' => $courts,
            'plans' => SubscriptionPlan::where('is_active', true)->get(),
            'stats' => $stats,
        ]);
    }

    public function show(Court $court)
    {
        $court->load(['images', 'vendorProfile', 'timeSlots' => fn ($query) => $query->where('status', 'available')->orderBy('slot_date')->orderBy('starts_at'), 'reviews.user']);

        return view('courtigo.courts.show', compact('court'));
    }

    public function vendorApply()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('courtigo.vendor-apply', compact('plans'));
    }
}
