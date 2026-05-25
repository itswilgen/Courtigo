<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['court_id', 'slot_date', 'starts_at', 'ends_at', 'status', 'price'])]
class CourtTimeSlot extends Model
{
    protected function casts(): array
    {
        return ['slot_date' => 'date', 'price' => 'decimal:2'];
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
