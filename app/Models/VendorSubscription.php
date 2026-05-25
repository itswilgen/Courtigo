<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['vendor_profile_id', 'subscription_plan_id', 'status', 'starts_at', 'expires_at', 'amount_paid', 'payment_provider'])]
class VendorSubscription extends Model
{
    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'expires_at' => 'date',
        ];
    }

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
