<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'vendor_profile_id',
        'name',
        'slug',
        'location',
        'city',
        'description',
        'price',
        'hourly_rate',
        'surface_type',
        'capacity',
        'status',
        'is_featured',
        'rating_average',
        'rating_count',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'price' => 'decimal:2',
            'hourly_rate' => 'decimal:2',
            'rating_average' => 'decimal:2',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class);
    }

    public function images()
    {
        return $this->hasMany(CourtImage::class);
    }

    public function schedules()
    {
        return $this->hasMany(CourtSchedule::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(CourtTimeSlot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function primaryImage(): string
    {
        return $this->images->firstWhere('is_primary', true)?->image_path
            ?? 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1200&q=80';
    }
}
