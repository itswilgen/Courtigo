<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['court_id', 'day_of_week', 'opens_at', 'closes_at', 'is_closed'])]
class CourtSchedule extends Model
{
    protected function casts(): array
    {
        return ['is_closed' => 'boolean'];
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
