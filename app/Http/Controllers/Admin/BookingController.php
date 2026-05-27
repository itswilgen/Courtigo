<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'booking_date' => ['nullable', 'date'],
            'court_id' => ['nullable', 'exists:courts,id'],
            'status' => ['nullable', 'in:pending,confirmed,cancelled,completed'],
        ]);

        $bookings = Booking::query()
            ->with(['user', 'court'])
            ->when($filters['booking_date'] ?? null, fn ($query, $date) => $query->whereDate('booking_date', $date))
            ->when($filters['court_id'] ?? null, fn ($query, $courtId) => $query->where('court_id', $courtId))
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest('booking_date')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'courts' => Court::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'court.owner', 'court.vendorProfile.user', 'reports']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        return back()->with('status', 'Booking cancelled by admin override.');
    }
}
