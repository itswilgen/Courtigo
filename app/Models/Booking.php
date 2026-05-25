<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'court_id', 'court_time_slot_id', 'reference', 'booking_date', 'starts_at', 'ends_at', 'total_amount', 'status'])]
class Booking extends Model
{
    protected function casts(): array
    {
        return ['booking_date' => 'date', 'total_amount' => 'decimal:2'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(CourtTimeSlot::class, 'court_time_slot_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
