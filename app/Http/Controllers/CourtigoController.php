<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\CourtTimeSlot;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourtigoController extends Controller
{
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

    public function reserve(Request $request, Court $court): RedirectResponse
    {
        $attributes = $request->validate([
            'court_time_slot_id' => ['required', 'integer'],
        ]);

        $booking = DB::transaction(function () use ($attributes, $court, $request) {
            $slot = CourtTimeSlot::query()
                ->whereKey($attributes['court_time_slot_id'])
                ->where('court_id', $court->id)
                ->lockForUpdate()
                ->first();

            if (! $slot || $slot->status !== 'available') {
                return null;
            }

            $slot->update(['status' => 'reserved']);

            $booking = Booking::create([
                'user_id' => $request->user()->id,
                'court_id' => $court->id,
                'court_time_slot_id' => $slot->id,
                'reference' => $this->bookingReference(),
                'booking_date' => $slot->slot_date,
                'starts_at' => $slot->starts_at,
                'ends_at' => $slot->ends_at,
                'total_amount' => $slot->price,
                'status' => 'pending',
            ]);

            Notification::create([
                'user_id' => $request->user()->id,
                'audience' => 'user',
                'title' => 'Reservation created',
                'message' => 'Your '.$court->name.' reservation on '.$slot->slot_date->format('M d, Y').' is waiting for payment method selection.',
            ]);

            return $booking;
        });

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
            'paymentMethods' => $this->paymentMethods(),
        ]);
    }

    public function storePayment(Request $request, Booking $booking): RedirectResponse
    {
        $this->authorizePlayerBooking($request, $booking);

        $attributes = $request->validate([
            'payment_method' => ['required', 'string', 'in:gcash,bank_transfer,paymaya,cash_venue'],
        ]);

        DB::transaction(function () use ($booking, $attributes, $request) {
            $booking->loadMissing('court', 'payment');

            if ($booking->payment) {
                $booking->payment->update([
                    'provider' => $attributes['payment_method'],
                    'amount' => $booking->total_amount,
                    'status' => 'pending',
                    'paid_at' => null,
                ]);
            } else {
                Payment::create([
                    'booking_id' => $booking->id,
                    'type' => 'booking',
                    'provider' => $attributes['payment_method'],
                    'transaction_reference' => $this->paymentReference(),
                    'amount' => $booking->total_amount,
                    'status' => 'pending',
                ]);
            }

            $booking->update(['status' => 'confirmed']);

            Notification::create([
                'user_id' => $request->user()->id,
                'audience' => 'user',
                'title' => 'Payment method selected',
                'message' => 'Your '.$booking->court?->name.' reservation is confirmed with '.$this->paymentMethodLabel($attributes['payment_method']).'.',
            ]);
        });

        return redirect()
            ->route('dashboard.player')
            ->with('status', 'Payment method saved. Your reservation '.$booking->reference.' is confirmed.');
    }

    public function vendorApply()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('courtigo.vendor-apply', compact('plans'));
    }

    private function bookingReference(): string
    {
        do {
            $reference = 'CTG-'.now()->format('ymd').'-'.Str::upper(Str::random(6));
        } while (Booking::where('reference', $reference)->exists());

        return $reference;
    }

    private function paymentReference(): string
    {
        do {
            $reference = 'PAY-'.now()->format('ymd').'-'.Str::upper(Str::random(6));
        } while (Payment::where('transaction_reference', $reference)->exists());

        return $reference;
    }

    private function paymentMethods(): array
    {
        return [
            'gcash' => [
                'label' => 'GCash',
                'hint' => 'Fast mobile wallet payment',
                'detail' => 'Use your GCash app and keep the reference for venue verification.',
                'accent' => 'blue',
            ],
            'bank_transfer' => [
                'label' => 'Bank Transfer',
                'hint' => 'Pay from your bank app',
                'detail' => 'Transfer from your preferred bank and present the confirmation receipt.',
                'accent' => 'slate',
            ],
            'paymaya' => [
                'label' => 'PayMaya',
                'hint' => 'Maya wallet payment',
                'detail' => 'Pay with Maya and keep your transaction receipt handy.',
                'accent' => 'green',
            ],
            'cash_venue' => [
                'label' => 'Pay Cash at Venue',
                'hint' => 'Settle at the front desk',
                'detail' => 'Your slot is reserved. Pay in person before court time.',
                'accent' => 'amber',
            ],
        ];
    }

    private function paymentMethodLabel(string $method): string
    {
        return match ($method) {
            'gcash' => 'GCash',
            'bank_transfer' => 'Bank Transfer',
            'paymaya' => 'PayMaya',
            'cash_venue' => 'Pay Cash at Venue',
            default => 'Payment',
        };
    }

    private function authorizePlayerBooking(Request $request, Booking $booking): void
    {
        abort_unless(
            $request->user()?->id === $booking->user_id || $request->user()?->role === 'admin',
            403
        );
    }
}
