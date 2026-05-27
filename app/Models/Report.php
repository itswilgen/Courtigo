<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'reported_by',
        'booking_id',
        'court_id',
        'message',
        'category',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
