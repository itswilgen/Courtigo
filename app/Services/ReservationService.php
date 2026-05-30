<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Court;
use App\Models\CourtTimeSlot;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationService
{
    public function __construct(private readonly PaymentMethodCatalog $paymentMethods)
    {
    }

    public function reserveSlot(User $user, Court $court, int $slotId): ?Booking
    {
        return DB::transaction(function () use ($user, $court, $slotId) {
            $slot = CourtTimeSlot::query()
                ->whereKey($slotId)
                ->where('court_id', $court->id)
                ->lockForUpdate()
                ->first();

            if (! $slot || $slot->status !== 'available') {
                return null;
            }

            $slot->update(['status' => 'reserved']);

            $booking = Booking::create([
                'user_id' => $user->id,
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
                'user_id' => $user->id,
                'audience' => 'user',
                'title' => 'Reservation created',
                'message' => 'Your '.$court->name.' reservation on '.$slot->slot_date->format('M d, Y').' is waiting for payment method selection.',
            ]);

            return $booking;
        });
    }

    public function savePaymentMethod(User $user, Booking $booking, string $method): void
    {
        DB::transaction(function () use ($user, $booking, $method) {
            $booking->loadMissing('court', 'payment');

            if ($booking->payment) {
                $booking->payment->update([
                    'provider' => $method,
                    'amount' => $booking->total_amount,
                    'status' => 'pending',
                    'paid_at' => null,
                ]);
            } else {
                Payment::create([
                    'booking_id' => $booking->id,
                    'type' => 'booking',
                    'provider' => $method,
                    'transaction_reference' => $this->paymentReference(),
                    'amount' => $booking->total_amount,
                    'status' => 'pending',
                ]);
            }

            $booking->update(['status' => 'confirmed']);

            Notification::create([
                'user_id' => $user->id,
                'audience' => 'user',
                'title' => 'Payment method selected',
                'message' => 'Your '.$booking->court?->name.' reservation is confirmed with '.$this->paymentMethods->label($method).'.',
            ]);
        });
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
}
