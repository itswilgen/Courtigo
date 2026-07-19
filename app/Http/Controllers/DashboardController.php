<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function player()
    {
        $user = request()->user();
        $bookings = $this->userBookings();

        $upcomingBookings = $bookings
            ->whereIn('status', ['pending', 'confirmed'])
            ->filter(fn (Booking $booking) => $booking->booking_date?->isToday() || $booking->booking_date?->isFuture())
            ->sortBy('booking_date')
            ->values();

        return view('courtigo.dashboards.player', [
            'user' => $user,
            'bookings' => $bookings->take(6),
            'nextBooking' => $upcomingBookings->first(),
            'upcomingBookings' => $upcomingBookings->take(3),
            'recommendedCourts' => Court::with('images')
                ->where('status', 'active')
                ->whereHas('timeSlots', fn ($query) => $query->where('status', 'available'))
                ->orderByDesc('rating_average')
                ->take(4)
                ->get(),
            'notifications' => $user->notifications()->latest()->take(3)->get(),
            'metrics' => [
                'bookings' => $bookings->count(),
                'confirmed' => $bookings->where('status', 'confirmed')->count(),
                'upcoming' => $upcomingBookings->count(),
                'completed' => $bookings->where('status', 'completed')->count(),
                'spent' => $bookings->sum('total_amount'),
                'favorites' => Court::where('status', 'active')->where('is_featured', true)->count(),
            ],
        ]);
    }

    public function courts()
    {
        return view('courtigo.courts.index', [
            'courts' => Court::with(['images', 'vendorProfile'])
                ->where('status', 'active')
                ->latest('is_featured')
                ->latest()
                ->take(12)
                ->get(),
        ]);
    }

    public function friends()
    {
        return view('courtigo.friends.index', $this->communityPlaceholders());
    }

    public function groups()
    {
        return view('courtigo.groups.index', $this->communityPlaceholders());
    }

    public function groupShow(string $group)
    {
        $data = $this->communityPlaceholders();
        $selected = collect($data['groups'])->firstWhere('slug', $group) ?? $data['groups'][0];

        return view('courtigo.groups.show', array_merge($data, [
            'group' => $selected,
        ]));
    }

    public function profilePreview(string $username)
    {
        $data = $this->communityPlaceholders();
        $profile = collect(array_merge($data['friends'], $data['suggestedFriends']))
            ->first(fn ($player) => ($player['slug'] ?? str($player['name'])->slug()->toString()) === $username)
            ?? $data['friends'][0];

        return view('courtigo.profile.preview', array_merge($data, [
            'profilePreview' => [
                'name' => $profile['name'],
                'avatar' => $profile['avatar'],
                'location' => $profile['location'],
                'sports' => explode(', ', $profile['sports'] ?? $profile['sport']),
                'friends' => 128,
                'groups' => 6,
                'bookings' => 34,
            ],
        ]));
    }

    public function followed()
    {
        $user = request()->user();
        
        return view('courtigo.followed.index', [
            'courts' => $user->followedCourts()
                ->with(['images', 'vendorProfile'])
                ->where('status', 'active')
                ->latest()
                ->get(),
        ]);
    }

    public function bookings()
    {
        return view('courtigo.bookings.index', [
            'bookings' => $this->userBookings(),
        ]);
    }

    public function messages(Request $request)
    {
        $data = $this->communityPlaceholders();
        $conversations = [
            ['name' => 'Friday Badminton Club', 'type' => 'group', 'slug' => 'friday-badminton-club', 'avatar' => 'FB', 'preview' => 'Two slots are still open for Saturday.', 'time' => '10:24 AM', 'unread' => 2],
            ['name' => 'Alyssa Cruz', 'type' => 'player', 'slug' => 'alyssa-cruz', 'avatar' => $data['friends'][0]['avatar'], 'preview' => 'Want to reserve a court after work?', 'time' => '9:18 AM', 'unread' => 1],
            ['name' => 'Hoop Night PH', 'type' => 'group', 'slug' => 'hoop-night-ph', 'avatar' => 'HN', 'preview' => 'Court confirmed for Friday night.', 'time' => 'Yesterday', 'unread' => 0],
            ['name' => 'Marco Reyes', 'type' => 'player', 'slug' => 'marco-reyes', 'avatar' => $data['friends'][1]['avatar'], 'preview' => 'See you at 6 PM.', 'time' => 'Yesterday', 'unread' => 0],
        ];
        $active = collect($conversations)->firstWhere('slug', $request->string('conversation')->toString()) ?? $conversations[0];

        return view('courtigo.messages.index', array_merge($data, compact('conversations', 'active')));
    }

    public function notifications()
    {
        $notifications = request()->user()->notifications()->latest()->get();

        return view('courtigo.notifications.index', compact('notifications'));
    }

    public function markNotificationsRead(Request $request): RedirectResponse
    {
        $request->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('status', 'All notifications marked as read.');
    }

    public function profile()
    {
        return view('courtigo.profile.show', [
            'user' => request()->user(),
            'bookings' => $this->userBookings(),
        ]);
    }

    public function settings()
    {
        return view('courtigo.settings.index', [
            'user' => request()->user(),
        ]);
    }

    public function vendor()
    {
        $vendor = VendorProfile::with(['courts.bookings', 'activeSubscription.plan'])
            ->where('status', 'approved')
            ->first();

        return view('courtigo.dashboards.vendor', [
            'vendor' => $vendor,
            'bookings' => Booking::with(['court', 'user'])->latest()->take(6)->get(),
            'revenue' => Payment::where('type', 'booking')->where('status', 'paid')->sum('amount'),
        ]);
    }

    public function admin()
    {
        return view('courtigo.dashboards.admin', [
            'metrics' => [
                'users' => User::count(),
                'vendors' => VendorProfile::count(),
                'bookings' => Booking::count(),
                'revenue' => Payment::where('status', 'paid')->sum('amount'),
                'subscriptions' => SubscriptionPlan::count(),
            ],
            'vendors' => VendorProfile::with('user')->latest()->take(6)->get(),
            'courts' => Court::with('vendorProfile')->orderByDesc('rating_average')->take(5)->get(),
        ]);
    }

    private function userBookings()
    {
        return Booking::with(['court.images', 'court.vendorProfile', 'payment'])
            ->where('user_id', request()->user()->id)
            ->latest('booking_date')
            ->latest()
            ->get();
    }

    private function communityPlaceholders(): array
    {
        $avatars = [
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80',
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
            'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=300&q=80',
            'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=300&q=80',
        ];

        return [
            'friends' => [
                ['name' => 'Alyssa Cruz', 'slug' => 'alyssa-cruz', 'avatar' => $avatars[0], 'sport' => 'Badminton', 'sports' => 'Badminton, Tennis', 'location' => 'Cebu City', 'status' => 'online', 'mutuals' => 12],
                ['name' => 'Marco Reyes', 'slug' => 'marco-reyes', 'avatar' => $avatars[1], 'sport' => 'Basketball', 'sports' => 'Basketball, Futsal', 'location' => 'Mandaue City', 'status' => 'away', 'mutuals' => 8],
                ['name' => 'Jem Santos', 'slug' => 'jem-santos', 'avatar' => $avatars[2], 'sport' => 'Volleyball', 'sports' => 'Volleyball, Badminton', 'location' => 'Lapu-Lapu City', 'status' => 'online', 'mutuals' => 15],
                ['name' => 'Nico Lim', 'slug' => 'nico-lim', 'avatar' => $avatars[3], 'sport' => 'Tennis', 'sports' => 'Tennis, Padel', 'location' => 'Talisay City', 'status' => 'offline', 'mutuals' => 5],
            ],
            'friendRequests' => [
                ['name' => 'Bianca Tan', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80', 'sports' => 'Badminton, Volleyball', 'mutuals' => 6],
                ['name' => 'Rafael Ong', 'avatar' => 'https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=300&q=80', 'sports' => 'Basketball, Futsal', 'mutuals' => 4],
                ['name' => 'Sam Villanueva', 'avatar' => 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=300&q=80', 'sports' => 'Tennis, Padel', 'mutuals' => 9],
            ],
            'suggestedFriends' => [
                ['name' => 'Maria Lopez', 'slug' => 'maria-lopez', 'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=300&q=80', 'sports' => 'Badminton, Pickleball', 'location' => 'Cebu City', 'mutuals' => 11],
                ['name' => 'Kevin Yu', 'slug' => 'kevin-yu', 'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=300&q=80', 'sports' => 'Basketball, Volleyball', 'location' => 'IT Park', 'mutuals' => 7],
                ['name' => 'Patricia Sy', 'slug' => 'patricia-sy', 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80', 'sports' => 'Tennis, Badminton', 'location' => 'Cebu Business Park', 'mutuals' => 13],
            ],
            'activities' => [
                ['initials' => 'DS', 'name' => 'Daniel', 'action' => 'booked Metro Rally Court for today.', 'time' => '12 minutes ago'],
                ['initials' => 'JR', 'name' => 'John', 'action' => 'joined Friday Badminton Club.', 'time' => '35 minutes ago'],
                ['initials' => 'ML', 'name' => 'Maria', 'action' => 'followed Arena Sports Center.', 'time' => '1 hour ago'],
                ['initials' => 'KY', 'name' => 'Kevin', 'action' => 'completed a booking at Baseline Hoops Arena.', 'time' => '2 hours ago'],
            ],
            'groups' => [
                ['name' => 'Friday Badminton Club', 'slug' => 'friday-badminton-club', 'sport' => 'Badminton', 'members' => 145, 'activity' => 'Active daily', 'next_event' => 'Saturday 6 PM', 'cover' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1200&q=80', 'description' => 'A Cebu-based group for weekly rallies, doubles rotation, and friendly weekend matches.'],
                ['name' => 'Hoop Night PH', 'slug' => 'hoop-night-ph', 'sport' => 'Basketball', 'members' => 218, 'activity' => 'Very active', 'next_event' => 'Friday 8 PM', 'cover' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=1200&q=80', 'description' => 'Pickup runs, team finder posts, and court reservations for players around Cebu and Mandaue.'],
                ['name' => 'Volley Weekend Crew', 'slug' => 'volley-weekend-crew', 'sport' => 'Volleyball', 'members' => 96, 'activity' => 'Active weekly', 'next_event' => 'Sunday 4 PM', 'cover' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?auto=format&fit=crop&w=1200&q=80', 'description' => 'Weekend volleyball group for mixed-skill games, training partners, and friendly tournaments.'],
                ['name' => 'Cebu Tennis Ladder', 'slug' => 'cebu-tennis-ladder', 'sport' => 'Tennis', 'members' => 74, 'activity' => 'Active weekly', 'next_event' => 'Wednesday 7 PM', 'cover' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=1200&q=80', 'description' => 'Tennis ladder matches, court sharing, and match reports for players building consistent form.'],
            ],
            'rooms' => [
                ['name' => 'Badminton Community', 'topic' => 'Daily court openings and doubles invites', 'online' => 32],
                ['name' => 'Basketball Community', 'topic' => 'Pickup games and team finder', 'online' => 21],
                ['name' => 'Volleyball Community', 'topic' => 'Open gyms, training, and weekend games', 'online' => 14],
                ['name' => 'Tennis Community', 'topic' => 'Match partners and ladder updates', 'online' => 9],
            ],
        ];
    }
}
