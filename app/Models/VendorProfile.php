<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'business_name', 'business_email', 'business_phone', 'business_address', 'city', 'requirements_file', 'description', 'status', 'approved_at'])]
class VendorProfile extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courts()
    {
        return $this->hasMany(Court::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(VendorSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(VendorSubscription::class)->where('status', 'active')->latestOfMany();
    }
}
