<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'court_id', 'booking_id', 'rating', 'comment', 'is_visible'])]
class Review extends Model
{
    protected function casts(): array
    {
        return ['is_visible' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
