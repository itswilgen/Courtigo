<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Court;
use App\Models\CourtImage;
use App\Models\CourtSchedule;
use App\Models\CourtTimeSlot;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Review;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfile;
use App\Models\VendorSubscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Courtigo Admin',
            'email' => 'admin@courtigo.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $player = User::create([
            'name' => 'Mika Santos',
            'email' => 'player@courtigo.test',
            'password' => Hash::make('password'),
            'role' => 'player',
            'phone' => '+63 917 555 2100',
            'status' => 'active',
        ]);

        $vendorUser = User::create([
            'name' => 'Rafael Cruz',
            'email' => 'vendor@courtigo.test',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'phone' => '+63 917 555 7300',
            'status' => 'active',
        ]);

        $starter = SubscriptionPlan::create([
            'name' => 'Starter Court',
            'description' => 'For independent court owners validating online reservations.',
            'price' => 1499,
            'duration_days' => 30,
            'court_limit' => 2,
            'features' => ['2 courts', 'Booking calendar', 'GCash and Maya records'],
        ]);

        $growth = SubscriptionPlan::create([
            'name' => 'Growth Club',
            'description' => 'For growing pickleball venues with analytics and customer tools.',
            'price' => 3999,
            'duration_days' => 30,
            'court_limit' => 8,
            'features' => ['8 courts', 'Revenue analytics', 'Customer management', 'Priority support'],
        ]);

        SubscriptionPlan::create([
            'name' => 'Venue Pro',
            'description' => 'For multi-branch operators preparing for sports expansion.',
            'price' => 8999,
            'duration_days' => 30,
            'court_limit' => null,
            'features' => ['Unlimited courts', 'Advanced reports', 'Multi-sport ready', 'Dedicated onboarding'],
        ]);

        $vendor = VendorProfile::create([
            'user_id' => $vendorUser->id,
            'business_name' => 'Metro Pickle Club',
            'business_email' => 'hello@metropickle.test',
            'business_phone' => '+63 2 8555 0188',
            'business_address' => 'BGC High Street, Taguig',
            'city' => 'Taguig',
            'description' => 'Premium indoor pickleball courts with coaching, lockers, and late-night play.',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $subscription = VendorSubscription::create([
            'vendor_profile_id' => $vendor->id,
            'subscription_plan_id' => $growth->id,
            'status' => 'active',
            'starts_at' => now()->startOfMonth(),
            'expires_at' => now()->addMonth(),
            'amount_paid' => $growth->price,
            'payment_provider' => 'maya',
        ]);

        $courts = collect([
            [
                'name' => 'Metro Rally Court',
                'location' => 'BGC High Street, Taguig',
                'city' => 'Taguig',
                'description' => 'A bright indoor court built for social games, weekly leagues, and corporate bookings.',
                'hourly_rate' => 950,
                'surface_type' => 'cushioned acrylic',
                'rating_average' => 4.9,
                'rating_count' => 86,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Northside Dink Arena',
                'location' => 'Vertis North, Quezon City',
                'city' => 'Quezon City',
                'description' => 'Outdoor evening play with competition-grade lighting and flexible weekend packages.',
                'hourly_rate' => 780,
                'surface_type' => 'hard court',
                'rating_average' => 4.7,
                'rating_count' => 54,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Alabang Smash Yard',
                'location' => 'Filinvest City, Muntinlupa',
                'city' => 'Muntinlupa',
                'description' => 'Family-friendly venue with beginner slots, rental paddles, and refreshment partners.',
                'hourly_rate' => 690,
                'surface_type' => 'acrylic',
                'rating_average' => 4.6,
                'rating_count' => 38,
                'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1595435742656-5272d0b3fa82?auto=format&fit=crop&w=1200&q=80',
            ],
        ])->map(function (array $courtData) use ($vendor) {
            $court = Court::create([
                ...collect($courtData)->except('image')->all(),
                'vendor_profile_id' => $vendor->id,
                'slug' => Str::slug($courtData['name']),
                'capacity' => 4,
                'status' => 'active',
            ]);

            CourtImage::create([
                'court_id' => $court->id,
                'image_path' => $courtData['image'],
                'alt_text' => $courtData['name'],
                'is_primary' => true,
            ]);

            foreach (range(1, 6) as $day) {
                CourtSchedule::create([
                    'court_id' => $court->id,
                    'day_of_week' => $day,
                    'opens_at' => '07:00',
                    'closes_at' => '22:00',
                ]);
            }

            foreach ([8, 10, 16, 18] as $hour) {
                CourtTimeSlot::create([
                    'court_id' => $court->id,
                    'slot_date' => Carbon::tomorrow(),
                    'starts_at' => sprintf('%02d:00', $hour),
                    'ends_at' => sprintf('%02d:00', $hour + 1),
                    'status' => $hour === 10 ? 'reserved' : 'available',
                    'price' => $court->hourly_rate,
                ]);
            }

            return $court;
        });

        $booking = Booking::create([
            'user_id' => $player->id,
            'court_id' => $courts->first()->id,
            'court_time_slot_id' => $courts->first()->timeSlots()->where('status', 'reserved')->first()?->id,
            'reference' => 'CTG-'.now()->format('ymd').'-1001',
            'booking_date' => Carbon::tomorrow(),
            'starts_at' => '10:00',
            'ends_at' => '11:00',
            'total_amount' => 950,
            'status' => 'confirmed',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'type' => 'booking',
            'provider' => 'gcash',
            'transaction_reference' => 'GCASH-CTG-1001',
            'amount' => 950,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        Payment::create([
            'vendor_subscription_id' => $subscription->id,
            'type' => 'subscription',
            'provider' => 'maya',
            'transaction_reference' => 'MAYA-SUB-1001',
            'amount' => $growth->price,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        Review::create([
            'user_id' => $player->id,
            'court_id' => $courts->first()->id,
            'booking_id' => $booking->id,
            'rating' => 5,
            'comment' => 'Fast confirmation, clean court, and the lighting was excellent for evening rallies.',
        ]);

        Notification::create([
            'user_id' => $player->id,
            'audience' => 'user',
            'title' => 'Booking confirmed',
            'message' => 'Your Metro Rally Court reservation for tomorrow at 10:00 AM is confirmed.',
        ]);

        Notification::create([
            'user_id' => $admin->id,
            'audience' => 'admin',
            'title' => 'Vendor subscription paid',
            'message' => 'Metro Pickle Club renewed the Growth Club plan via Maya.',
        ]);
    }
}
