@extends('layouts.courtigo', ['title' => $court->name.' | Courtigo'])

@section('content')
    <section class="hero-visual hero-bg-court bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <!-- Image Gallery -->
            <div class="mb-8">
                <div class="grid gap-4 lg:grid-cols-[3fr_1fr]">
                    <!-- Main Image -->
                    <div class="overflow-hidden rounded bg-slate-200" data-gallery-main>
                        <img class="h-[500px] w-full object-cover cursor-pointer transition hover:scale-105" src="{{ $court->primaryImage() }}" alt="{{ $court->name }}" data-main-image>
                    </div>
                    <!-- Thumbnail Images -->
                    <div class="grid gap-3" data-gallery-thumbnails>
                        @foreach($court->images->take(4) as $image)
                            <div class="overflow-hidden rounded bg-slate-200 cursor-pointer border-2 border-transparent transition hover:border-courtigo-blue" data-thumbnail data-image-src="{{ $image->image_path }}">
                                <img class="h-[120px] w-full object-cover" src="{{ $image->image_path }}" alt="{{ $court->name }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <!-- Court Info -->
                <div>
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">{{ $court->city }} · {{ $court->surface_type }}</p>
                            <h1 class="mt-2 text-4xl font-black text-courtigo-navy">{{ $court->name }}</h1>
                        </div>
                        <!-- Follow Button -->
                        <div class="flex-shrink-0">
                            @auth
                                <button 
                                    class="flex items-center gap-2 rounded bg-white px-4 py-3 font-bold text-courtigo-red transition hover:bg-red-50 border border-slate-200" 
                                    type="button" 
                                    data-follow-button 
                                    data-court-id="{{ $court->id }}"
                                    data-is-following="{{ auth()->check() && auth()->user()->isFollowing($court) ? 'true' : 'false' }}"
                                    aria-label="Follow court">
                                    <span class="text-xl" data-follow-icon>
                                        {{ auth()->check() && auth()->user()->isFollowing($court) ? '♥' : '♡' }}
                                    </span>
                                    <span data-follow-text>
                                        {{ auth()->check() && auth()->user()->isFollowing($court) ? 'Following' : 'Follow' }}
                                    </span>
                                </button>
                            @else
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="flex items-center gap-2 rounded bg-white px-4 py-3 font-bold text-courtigo-red transition hover:bg-red-50 border border-slate-200">
                                    <span class="text-xl">♡</span>
                                    <span>Follow</span>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Rating and Review Count -->
                    <div class="mt-6 flex items-center gap-4">
                        <div class="rounded bg-blue-50 px-4 py-3">
                            <p class="text-sm text-slate-600">Rating</p>
                            <p class="text-2xl font-black text-courtigo-navy">★ {{ number_format($court->rating_average, 1) }}</p>
                            <p class="text-xs text-slate-500">{{ $court->reviews->count() }} reviews</p>
                        </div>
                        <div class="rounded bg-green-50 px-4 py-3">
                            <p class="text-sm text-slate-600">Price</p>
                            <p class="text-2xl font-black text-courtigo-navy">₱{{ number_format($court->hourly_rate) }}<span class="text-sm font-medium text-slate-500">/hr</span></p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-black text-courtigo-navy">About this court</h3>
                        <p class="mt-3 text-base leading-8 text-slate-600">{{ $court->description }}</p>
                    </div>

                    <div class="mt-6">
                        <p class="text-sm font-bold text-slate-500">Hosted by</p>
                        <p class="mt-1 text-lg font-black text-courtigo-navy">{{ $court->vendorProfile->business_name }}</p>
                    </div>
                </div>

                <!-- Reservation Sidebar -->
                <aside class="h-fit rounded border border-slate-200 bg-slate-50 p-5" data-reservation-root data-initial-slot="{{ old('court_time_slot_id', request('slot')) }}">
                    <h2 class="text-lg font-black text-courtigo-navy">Reserve your slot</h2>
                    
                    @error('court_time_slot_id')
                        <div class="mt-4 rounded border border-red-100 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Date Picker -->
                    <div class="mt-4">
                        <label for="date-picker" class="block text-sm font-bold text-slate-700">Select Date</label>
                        <input 
                            type="date" 
                            id="date-picker" 
                            class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none focus:border-courtigo-blue" 
                            data-date-picker
                            min="{{ now()->format('Y-m-d') }}">
                    </div>

                    <!-- Time Slots -->
                    <div class="mt-4">
                        <label class="block text-sm font-bold text-slate-700 mb-3">Available Times</label>
                        <div class="grid grid-cols-2 gap-2">
                            @forelse($court->timeSlots->take(6) as $slot)
                                <button class="rounded border border-slate-200 bg-white px-3 py-3 text-left text-sm transition hover:border-courtigo-blue hover:bg-blue-50 data-[selected=true]:border-courtigo-blue data-[selected=true]:bg-blue-50 data-[selected=true]:ring-2 data-[selected=true]:ring-blue-100" type="button" data-slot-option data-slot-id="{{ $slot->id }}" data-slot-label="{{ $slot->slot_date->format('M d') }} · {{ substr($slot->starts_at, 0, 5) }} - {{ substr($slot->ends_at, 0, 5) }}" aria-pressed="false">
                                    <span class="block font-bold text-courtigo-navy">{{ $slot->slot_date->format('M d') }}</span>
                                    <span class="block text-slate-500">{{ substr($slot->starts_at, 0, 5) }} - {{ substr($slot->ends_at, 0, 5) }}</span>
                                </button>
                            @empty
                                <div class="col-span-2 rounded border border-slate-200 bg-white p-4 text-sm text-slate-500">
                                    No open slots available.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <p class="mt-3 hidden rounded bg-white px-3 py-2 text-sm font-semibold text-courtigo-navy" data-selected-slot-summary></p>

                    @auth
                        <form class="mt-5" method="POST" action="{{ route('courts.reserve', $court) }}">
                            @csrf
                            <input type="hidden" name="court_time_slot_id" value="{{ old('court_time_slot_id') }}" data-selected-slot-input>
                            <button class="w-full rounded bg-courtigo-green px-5 py-3 font-bold text-white transition hover:bg-green-600 disabled:cursor-not-allowed disabled:bg-slate-300" type="submit" data-reserve-button disabled>Book Now</button>
                        </form>
                    @else
                        <div class="mt-5 rounded border border-blue-100 bg-blue-50 p-4">
                            <p class="text-sm font-bold text-courtigo-navy">Login required to reserve</p>
                            <p class="mt-1 text-sm leading-6 text-slate-600">Create or access your Courtigo session first so we can attach the booking to your player account.</p>
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="mt-4 inline-flex w-full justify-center rounded bg-courtigo-green px-5 py-3 text-sm font-bold text-white hover:bg-green-600" data-login-reserve-link>Log in to reserve</a>
                        </div>
                    @endauth
                </aside>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Existing Reviews -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-black text-courtigo-navy">Player reviews</h2>
                <div class="mt-6 grid gap-4">
                    @forelse($court->reviews->where('is_visible', true) as $review)
                        <div class="rounded border border-slate-200 bg-white p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-bold text-courtigo-navy">{{ $review->user->name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="text-lg font-bold text-courtigo-amber">★ {{ $review->rating }}</p>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500">No reviews yet. Be the first to share your experience!</p>
                    @endforelse
                </div>
            </div>

            <!-- Leave Review Form -->
            <div class="lg:col-span-1">
                @auth
                    <div class="rounded border border-slate-200 bg-slate-50 p-5 h-fit">
                        <h3 class="text-lg font-black text-courtigo-navy">Share your experience</h3>
                        
                        @if(auth()->user()->bookings()->where('court_id', $court->id)->exists())
                            <form method="POST" action="{{ route('reviews.store', $court) }}" class="mt-4">
                                @csrf
                                
                                <!-- Rating -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700">Rating</label>
                                    <div class="mt-3 flex gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button
                                                type="button"
                                                class="text-2xl transition hover:scale-110"
                                                data-rating-star
                                                data-rating="{{ $i }}"
                                                aria-label="Rate {{ $i }} stars">
                                                ☆
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" value="" data-rating-input>
                                </div>

                                <!-- Comment -->
                                <div class="mt-4">
                                    <label for="comment" class="block text-sm font-bold text-slate-700">Your comment</label>
                                    <textarea
                                        name="comment"
                                        id="comment"
                                        class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none focus:border-courtigo-blue"
                                        placeholder="Share your experience..."
                                        rows="4"></textarea>
                                </div>

                                <button
                                    type="submit"
                                    class="mt-4 w-full rounded bg-courtigo-green px-4 py-3 font-bold text-white transition hover:bg-green-600 disabled:bg-slate-300 disabled:cursor-not-allowed"
                                    data-submit-review
                                    disabled>
                                    Post Review
                                </button>
                            </form>
                        @else
                            <p class="mt-4 text-sm text-slate-600">You must book this court to leave a review.</p>
                        @endif
                    </div>
                @else
                    <div class="rounded border border-blue-100 bg-blue-50 p-5">
                        <p class="text-sm font-bold text-courtigo-navy">Login to leave a review</p>
                        <p class="mt-2 text-sm text-slate-600">Share your experience after booking a court.</p>
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="mt-4 inline-flex w-full justify-center rounded bg-courtigo-blue px-4 py-3 text-sm font-bold text-white hover:bg-blue-600">
                            Log in
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="{{ asset('js/court-reservation.js') }}" defer></script>
        <script>
            // Gallery functionality
            document.addEventListener('DOMContentLoaded', function() {
                const mainImage = document.querySelector('[data-main-image]');
                const thumbnails = document.querySelectorAll('[data-thumbnail]');

                thumbnails.forEach(thumb => {
                    thumb.addEventListener('click', function() {
                        const imageSrc = this.dataset.imageSrc;
                        mainImage.src = imageSrc;
                        
                        thumbnails.forEach(t => t.classList.remove('border-courtigo-blue'));
                        this.classList.add('border-courtigo-blue');
                    });
                });

                // Set first thumbnail as active
                if (thumbnails.length > 0) {
                    thumbnails[0].classList.add('border-courtigo-blue');
                }

                // Rating functionality
                const ratingStars = document.querySelectorAll('[data-rating-star]');
                const ratingInput = document.querySelector('[data-rating-input]');
                const submitButton = document.querySelector('[data-submit-review]');

                ratingStars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = this.dataset.rating;
                        ratingInput.value = rating;

                        ratingStars.forEach((s, idx) => {
                            s.textContent = idx < rating ? '★' : '☆';
                        });

                        submitButton.disabled = false;
                    });
                });

                // Follow button functionality
                const followButton = document.querySelector('[data-follow-button]');
                if (followButton) {
                    followButton.addEventListener('click', async function(e) {
                        e.preventDefault();
                        
                        const courtId = this.dataset.courtId;
                        const isFollowing = this.dataset.isFollowing === 'true';
                        
                        try {
                            const response = await fetch(`/courts/${courtId}/follow`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                            });

                            if (!response.ok) throw new Error('Network response was not ok');
                            
                            const data = await response.json();
                            
                            // Update button appearance
                            const followIcon = this.querySelector('[data-follow-icon]');
                            const followText = this.querySelector('[data-follow-text]');
                            
                            if (data.isFollowing) {
                                followIcon.textContent = '♥';
                                followText.textContent = 'Following';
                                this.dataset.isFollowing = 'true';
                                this.classList.remove('text-courtigo-red', 'hover:bg-red-50');
                                this.classList.add('text-red-600', 'bg-red-50');
                            } else {
                                followIcon.textContent = '♡';
                                followText.textContent = 'Follow';
                                this.dataset.isFollowing = 'false';
                                this.classList.remove('text-red-600', 'bg-red-50');
                                this.classList.add('text-courtigo-red', 'hover:bg-red-50');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
