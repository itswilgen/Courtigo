<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courtigo | Find & Book Pickleball Courts</title>
    <meta name="description" content="Courtigo is the marketplace for discovering, booking, and managing pickleball courts in the Philippines.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/tailwind-welcome-config.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="overflow-x-hidden bg-slate-50 font-sans text-slate-900 antialiased">
    <header class="sticky top-0 z-50 border-b border-white/10 bg-courtigo-navy/95 text-white shadow-sm backdrop-blur">
        <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-lg bg-courtigo-green text-sm font-black text-white">CT</span>
                <span class="text-xl font-black tracking-tight">Court<span class="text-courtigo-green">igo</span></span>
            </a>

            <div class="hidden items-center gap-7 text-sm font-semibold text-white/70 md:flex">
                <a href="#courts" class="transition hover:text-white">Discover Courts</a>
                <a href="#how-it-works" class="transition hover:text-white">How It Works</a>
                <a href="#pricing" class="transition hover:text-white">Pricing</a>
                <a href="{{ route('vendor.apply') }}" class="transition hover:text-white">Become a Partner</a>
            </div>

            <div class="flex min-w-0 items-center gap-2">
                <a href="{{ route('dashboard.player') }}" class="hidden rounded-lg border border-white/20 px-4 py-2 text-sm font-bold text-white transition hover:border-white/50 sm:inline-flex">Player</a>
                <a href="{{ route('vendor.apply') }}" class="hidden rounded-lg bg-courtigo-green px-4 py-2 text-sm font-bold text-white transition hover:bg-green-600 xs:inline-flex sm:inline-flex">List courts</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="bg-courtigo-navy text-white">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 pb-10 pt-12 sm:px-6 lg:grid-cols-[1.03fr_0.97fr] lg:px-8 lg:pb-12 lg:pt-16">
                <div class="min-w-0 flex flex-col justify-center">
                    <div class="mb-5 inline-flex w-fit items-center gap-2 rounded-full border border-courtigo-green/30 bg-courtigo-green/10 px-4 py-2 text-sm font-bold text-courtigo-green">
                        <span class="h-2 w-2 rounded-full bg-courtigo-green"></span>
                        Now live in the Philippines
                    </div>

                    <h1 class="max-w-3xl break-words text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                        Find and book pickleball courts near you
                    </h1>
                    <p class="mt-5 max-w-2xl break-words text-base leading-8 text-white/65 sm:text-lg">
                        Courtigo helps players reserve live court slots while giving venue owners a clean dashboard for schedules, payments, revenue, and customer management.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#courts" class="inline-flex items-center justify-center gap-2 rounded-lg bg-courtigo-green px-5 py-3 text-sm font-black text-white shadow-lg shadow-green-950/20 transition hover:bg-green-600">
                            <i class="bi bi-search" aria-hidden="true"></i>
                            Discover courts
                        </a>
                        <a href="{{ route('vendor.apply') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/15 bg-white/10 px-5 py-3 text-sm font-black text-white transition hover:bg-white/15">
                            <i class="bi bi-building-add" aria-hidden="true"></i>
                            Become a partner
                        </a>
                    </div>

                    <div class="mt-10 grid max-w-xl grid-cols-3 gap-3 border-t border-white/10 pt-6">
                        <div>
                            <p class="text-2xl font-black">240+</p>
                            <p class="mt-1 text-xs font-semibold text-white/45">Courts listed</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black">1,800+</p>
                            <p class="mt-1 text-xs font-semibold text-white/45">Bookings made</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black">120+</p>
                            <p class="mt-1 text-xs font-semibold text-white/45">Verified vendors</p>
                        </div>
                    </div>
                </div>

                <div class="relative min-h-[420px] overflow-hidden rounded-lg border border-white/10 bg-white/5 shadow-2xl">
                    <img class="absolute inset-0 h-full w-full object-cover opacity-80" src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1400&q=80" alt="Pickleball court">
                    <div class="absolute inset-0 bg-gradient-to-t from-courtigo-navy via-courtigo-navy/25 to-transparent"></div>

                    <div class="absolute left-4 top-4 rounded-full bg-courtigo-green px-3 py-1 text-xs font-black text-white">Available now</div>

                    <div class="absolute inset-x-4 bottom-4 rounded-lg border border-white/10 bg-white p-5 text-slate-900 shadow-2xl">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-black text-courtigo-green">Live slot available</p>
                                <h2 class="mt-1 text-xl font-black text-courtigo-navy">SM City Sports Court</h2>
                                <p class="mt-1 flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                                    <span><i class="bi bi-geo-alt" aria-hidden="true"></i> Cebu City</span>
                                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                    <span>Today, 3:00 PM</span>
                                </p>
                            </div>
                            <span class="rounded-lg bg-green-50 px-3 py-2 text-sm font-black text-green-700">₱350/hr</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative z-10 -mt-7 px-4 sm:px-6 lg:px-8">
            <form action="#courts" class="mx-auto grid max-w-7xl gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-xl shadow-slate-950/10 md:grid-cols-[1fr_1fr_1fr_1fr_auto]">
                <label class="block rounded-lg border border-slate-200 px-4 py-3">
                    <span class="flex items-center gap-2 text-xs font-black uppercase tracking-wide text-slate-500"><i class="bi bi-geo-alt" aria-hidden="true"></i> Location</span>
                    <span class="mt-1 block text-sm font-bold text-slate-900">Cebu City, PH</span>
                </label>
                <label class="block rounded-lg border border-slate-200 px-4 py-3">
                    <span class="flex items-center gap-2 text-xs font-black uppercase tracking-wide text-slate-500"><i class="bi bi-calendar3" aria-hidden="true"></i> Date</span>
                    <span class="mt-1 block text-sm font-bold text-slate-400">Select date</span>
                </label>
                <label class="block rounded-lg border border-slate-200 px-4 py-3">
                    <span class="flex items-center gap-2 text-xs font-black uppercase tracking-wide text-slate-500"><i class="bi bi-clock" aria-hidden="true"></i> Time</span>
                    <span class="mt-1 block text-sm font-bold text-slate-400">Any time</span>
                </label>
                <label class="block rounded-lg border border-slate-200 px-4 py-3">
                    <span class="flex items-center gap-2 text-xs font-black uppercase tracking-wide text-slate-500"><i class="bi bi-grid" aria-hidden="true"></i> Type</span>
                    <span class="mt-1 block text-sm font-bold text-slate-400">Indoor / Outdoor</span>
                </label>
                <button class="inline-flex items-center justify-center gap-2 rounded-lg bg-courtigo-navy px-5 py-3 text-sm font-black text-white transition hover:bg-blue-950" type="submit">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    Search
                </button>
            </form>
        </section>

        <section id="courts" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Marketplace</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-courtigo-navy">Featured courts near you</h2>
                </div>
                <a href="{{ route('dashboard.player') }}" class="inline-flex items-center gap-2 text-sm font-black text-courtigo-blue hover:text-blue-700">
                    Open player dashboard
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                @foreach([
                    ['venue' => 'Ayala Sports Center', 'name' => 'Main Pickleball Court A', 'city' => 'Mandaue City', 'type' => 'Indoor', 'price' => '₱400', 'rating' => '4.8', 'badge' => 'Featured', 'tone' => 'from-blue-950 to-sky-700'],
                    ['venue' => 'GreenCourt Cebu', 'name' => 'Outdoor Court No. 2', 'city' => 'Talisay City', 'type' => 'Outdoor', 'price' => '₱280', 'rating' => '4.6', 'badge' => 'Available Now', 'tone' => 'from-emerald-950 to-green-600'],
                    ['venue' => 'PikBall Hub', 'name' => 'Premium Indoor Court', 'city' => 'Cebu City', 'type' => 'Indoor', 'price' => '₱550', 'rating' => '5.0', 'badge' => 'Trending', 'tone' => 'from-slate-950 to-indigo-700'],
                ] as $court)
                    <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br {{ $court['tone'] }}">
                            <div class="absolute inset-6 rounded border-2 border-white/40">
                                <div class="absolute left-1/2 top-0 h-full w-px -translate-x-1/2 border-l border-dashed border-white/50"></div>
                                <div class="absolute left-0 top-1/2 h-px w-full -translate-y-1/2 bg-white/50"></div>
                                <div class="absolute left-1/2 top-1/2 h-14 w-14 -translate-x-1/2 -translate-y-1/2 rounded-full border border-white/40"></div>
                            </div>
                            <span class="absolute left-3 top-3 rounded bg-white px-3 py-1 text-xs font-black text-courtigo-navy">{{ $court['badge'] }}</span>
                            <button class="absolute right-3 top-3 grid h-9 w-9 place-items-center rounded-full bg-white/95 text-slate-500 shadow transition hover:text-courtigo-red" type="button" aria-label="Add to favorites">
                                <i class="bi bi-heart" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="p-5">
                            <p class="text-sm font-bold text-slate-500">{{ $court['venue'] }}</p>
                            <h3 class="mt-1 text-lg font-black text-courtigo-navy">{{ $court['name'] }}</h3>
                            <p class="mt-2 flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                                <span><i class="bi bi-geo-alt" aria-hidden="true"></i> {{ $court['city'] }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <span>{{ $court['type'] }}</span>
                            </p>

                            <div class="mt-5 flex items-center justify-between gap-4">
                                <p class="text-lg font-black text-courtigo-navy">{{ $court['price'] }} <span class="text-sm font-semibold text-slate-500">/ hr</span></p>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-black text-slate-700"><i class="bi bi-star-fill text-courtigo-amber" aria-hidden="true"></i> {{ $court['rating'] }}</span>
                                    <a href="{{ route('dashboard.player') }}" class="rounded-lg bg-courtigo-navy px-4 py-2 text-sm font-black text-white transition hover:bg-blue-950">Book</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section id="how-it-works" class="bg-courtigo-navy py-16 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Simple process</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight">Book a court in minutes</h2>
                </div>

                <div class="mt-10 grid gap-4 md:grid-cols-4">
                    @foreach([
                        ['icon' => 'bi-search', 'title' => 'Discover', 'copy' => 'Browse verified courts near your location.'],
                        ['icon' => 'bi-calendar-check', 'title' => 'Select a Slot', 'copy' => 'Choose a date and time from live availability.'],
                        ['icon' => 'bi-credit-card', 'title' => 'Pay Securely', 'copy' => 'Complete your booking with online payment.'],
                        ['icon' => 'bi-trophy', 'title' => 'Play', 'copy' => 'Show up, scan your booking, and enjoy the game.'],
                    ] as $step)
                        <div class="rounded-lg border border-white/10 bg-white/5 p-6 text-center">
                            <div class="mx-auto grid h-14 w-14 place-items-center rounded-full border border-courtigo-green/40 bg-courtigo-green/10 text-xl text-courtigo-green">
                                <i class="bi {{ $step['icon'] }}" aria-hidden="true"></i>
                            </div>
                            <h3 class="mt-5 text-lg font-black">{{ $step['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-white/55">{{ $step['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-green-50 py-16">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_420px] lg:px-8">
                <div class="flex flex-col justify-center">
                    <p class="text-sm font-black uppercase tracking-wide text-green-700">For court owners</p>
                    <h2 class="mt-2 max-w-xl text-3xl font-black tracking-tight text-courtigo-navy sm:text-4xl">Turn your courts into reliable revenue</h2>
                    <p class="mt-4 max-w-2xl text-base leading-8 text-slate-600">
                        Join Courtigo as a verified partner and reach players looking to book courts in your area. Manage schedules, track revenue, and grow from one clean workflow.
                    </p>

                    <div class="mt-6 grid gap-3 text-sm font-bold text-slate-700 sm:grid-cols-2">
                        <p class="flex gap-2"><i class="bi bi-check-circle-fill text-courtigo-green" aria-hidden="true"></i> Player discovery</p>
                        <p class="flex gap-2"><i class="bi bi-check-circle-fill text-courtigo-green" aria-hidden="true"></i> Real-time booking tools</p>
                        <p class="flex gap-2"><i class="bi bi-check-circle-fill text-courtigo-green" aria-hidden="true"></i> Revenue analytics</p>
                        <p class="flex gap-2"><i class="bi bi-check-circle-fill text-courtigo-green" aria-hidden="true"></i> Flexible subscription plans</p>
                    </div>

                    <a href="{{ route('vendor.apply') }}" class="mt-8 inline-flex w-fit items-center gap-2 rounded-lg bg-courtigo-navy px-5 py-3 text-sm font-black text-white transition hover:bg-blue-950">
                        Become a partner
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white shadow-xl">
                    <div class="flex items-center gap-4 rounded-t-lg bg-courtigo-navy p-5 text-white">
                        <div class="grid h-12 w-12 place-items-center rounded-lg bg-courtigo-blue/30 text-lg font-black text-sky-200">GC</div>
                        <div>
                            <h3 class="font-black">GreenCourt Cebu</h3>
                            <p class="mt-1 text-xs font-bold text-courtigo-green"><i class="bi bi-circle-fill text-[8px]" aria-hidden="true"></i> Active Vendor</p>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-2xl font-black text-courtigo-navy">3</p>
                                <p class="text-xs font-bold text-slate-500">Courts</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-2xl font-black text-courtigo-navy">84</p>
                                <p class="text-xs font-bold text-slate-500">Bookings</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-2xl font-black text-courtigo-navy">4.7</p>
                                <p class="text-xs font-bold text-slate-500">Rating</p>
                            </div>
                        </div>

                        <p class="mt-5 text-sm font-bold text-slate-500">Monthly Revenue</p>
                        <p class="mt-1 text-3xl font-black text-courtigo-navy">₱24,600</p>
                        <p class="mt-1 text-sm font-black text-courtigo-green">18% from last month</p>

                        <div class="mt-5 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 p-4">
                            <div>
                                <p class="font-black text-green-800">Premium Plan</p>
                                <p class="text-sm font-medium text-slate-500">Renews in 18 days</p>
                            </div>
                            <span class="rounded bg-courtigo-green px-3 py-1 text-xs font-black text-white">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="pricing" class="bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Subscription plans</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-courtigo-navy">Simple, transparent pricing</h2>
                </div>

                <div class="mx-auto mt-10 grid max-w-5xl gap-5 md:grid-cols-3">
                    @foreach([
                        ['name' => 'Starter', 'price' => 'Free', 'copy' => 'For new vendors getting started', 'featured' => false, 'features' => ['1 court listing', 'Basic analytics', 'Booking calendar']],
                        ['name' => 'Premium', 'price' => '₱999', 'copy' => 'For serious court owners', 'featured' => true, 'features' => ['Up to 10 courts', 'Advanced analytics', 'Priority listing']],
                        ['name' => 'Enterprise', 'price' => '₱2,499', 'copy' => 'For large facilities and chains', 'featured' => false, 'features' => ['Unlimited courts', 'Full analytics suite', 'Dedicated support']],
                    ] as $plan)
                        <article class="relative rounded-lg border p-6 {{ $plan['featured'] ? 'border-courtigo-navy bg-courtigo-navy text-white shadow-xl' : 'border-slate-200 bg-white text-slate-900' }}">
                            @if($plan['featured'])
                                <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-courtigo-green px-4 py-1 text-xs font-black text-white">Most Popular</span>
                            @endif

                            <h3 class="text-sm font-black uppercase tracking-wide {{ $plan['featured'] ? 'text-white/50' : 'text-slate-500' }}">{{ $plan['name'] }}</h3>
                            <p class="mt-3 text-4xl font-black">{{ $plan['price'] }} <span class="text-sm font-semibold {{ $plan['featured'] ? 'text-white/40' : 'text-slate-500' }}">/ mo</span></p>
                            <p class="mt-2 min-h-10 text-sm leading-6 {{ $plan['featured'] ? 'text-white/50' : 'text-slate-500' }}">{{ $plan['copy'] }}</p>

                            <div class="my-6 h-px {{ $plan['featured'] ? 'bg-white/10' : 'bg-slate-100' }}"></div>

                            <div class="space-y-3">
                                @foreach($plan['features'] as $feature)
                                    <p class="flex gap-2 text-sm font-bold {{ $plan['featured'] ? 'text-white/80' : 'text-slate-700' }}">
                                        <i class="bi bi-check-circle-fill text-courtigo-green" aria-hidden="true"></i>
                                        {{ $feature }}
                                    </p>
                                @endforeach
                            </div>

                            <a href="{{ route('vendor.apply') }}" class="mt-8 inline-flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-black transition {{ $plan['featured'] ? 'bg-courtigo-green text-white hover:bg-green-600' : 'border border-slate-200 text-courtigo-navy hover:bg-slate-50' }}">
                                Get started
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-courtigo-navy text-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-[1.4fr_1fr_1fr_1fr] lg:px-8">
            <div>
                <p class="text-xl font-black">Court<span class="text-courtigo-green">igo</span></p>
                <p class="mt-3 max-w-sm text-sm leading-6 text-white/45">The marketplace for pickleball court discovery and reservations in the Philippines.</p>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wide text-white/45">Platform</p>
                <div class="mt-4 space-y-2 text-sm font-semibold text-white/55">
                    <a href="#courts" class="block hover:text-white">Discover Courts</a>
                    <a href="#how-it-works" class="block hover:text-white">How It Works</a>
                    <a href="#pricing" class="block hover:text-white">Pricing</a>
                </div>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wide text-white/45">Dashboards</p>
                <div class="mt-4 space-y-2 text-sm font-semibold text-white/55">
                    <a href="{{ route('dashboard.player') }}" class="block hover:text-white">Player</a>
                    <a href="{{ route('dashboard.vendor') }}" class="block hover:text-white">Vendor</a>
                    <a href="{{ route('dashboard.admin') }}" class="block hover:text-white">Admin</a>
                </div>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wide text-white/45">Social</p>
                <div class="mt-4 flex gap-2">
                    <a href="#" class="grid h-9 w-9 place-items-center rounded-lg border border-white/10 bg-white/5 text-white/55 hover:text-white" aria-label="Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                    <a href="#" class="grid h-9 w-9 place-items-center rounded-lg border border-white/10 bg-white/5 text-white/55 hover:text-white" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                    <a href="#" class="grid h-9 w-9 place-items-center rounded-lg border border-white/10 bg-white/5 text-white/55 hover:text-white" aria-label="Twitter"><i class="bi bi-twitter-x" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 px-4 py-5 text-center text-xs font-semibold text-white/35">
            &copy; {{ date('Y') }} Courtigo. All rights reserved.
        </div>
    </footer>
</body>
</html>
