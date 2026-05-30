<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReserveCourtRequest;
use App\Http\Requests\StoreBookingPaymentRequest;
use App\Models\Booking;
use App\Models\Court;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfile;
use App\Services\PaymentMethodCatalog;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourtigoController extends Controller
{
    public function __construct(
        private readonly PaymentMethodCatalog $paymentMethods,
        private readonly ReservationService $reservations,
    ) {
    }

    public function index()
    {
        $courts = Court::query()
            ->with(['images', 'vendorProfile'])
            ->where('status', 'active')
            ->whereHas('timeSlots', fn ($query) => $query->where('status', 'available'))
            ->latest('is_featured')
            ->latest()
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

    public function reserve(ReserveCourtRequest $request, Court $court): RedirectResponse
    {
        $booking = $this->reservations->reserveSlot(
            $request->user(),
            $court,
            (int) $request->validated('court_time_slot_id'),
        );

        if (! $booking) {
            return back()
                ->withErrors(['court_time_slot_id' => 'That slot is no longer available. Please choose another time.'])
                ->withInput();
        }

        return redirect()
            ->route('bookings.payment', $booking)
            ->with('status', 'Reservation '.$booking->reference.' is ready. Choose how you want to pay.');
    }

    public function payment(Request $request, Booking $booking)
    {
        $this->authorizePlayerBooking($request, $booking);

        $booking->load(['court.images', 'payment']);

        return view('courtigo.bookings.payment', [
            'booking' => $booking,
            'paymentMethods' => $this->paymentMethods->all(),
        ]);
    }

    public function storePayment(StoreBookingPaymentRequest $request, Booking $booking): RedirectResponse
    {
        $this->reservations->savePaymentMethod(
            $request->user(),
            $booking,
            $request->validated('payment_method'),
        );

        return redirect()
            ->route('dashboard.player')
            ->with('status', 'Payment method saved. Your reservation '.$booking->reference.' is confirmed.');
    }

    public function vendorApply()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('courtigo.vendor-apply', compact('plans'));
    }

    private function authorizePlayerBooking(Request $request, Booking $booking): void
    {
        abort_unless(
            $request->user()?->id === $booking->user_id || $request->user()?->role === 'admin',
            403
        );
    }
}
