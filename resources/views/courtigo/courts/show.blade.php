@extends('layouts.courtigo', ['title' => $court->name.' | Courtigo'])

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div>
                    <div class="overflow-hidden rounded bg-slate-200">
                        <img class="h-[420px] w-full object-cover" src="{{ $court->primaryImage() }}" alt="{{ $court->name }}">
                    </div>
                    <div class="mt-6">
                        <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">{{ $court->city }} · {{ $court->surface_type }}</p>
                        <h1 class="mt-2 text-4xl font-black text-courtigo-navy">{{ $court->name }}</h1>
                        <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-600">{{ $court->description }}</p>
                    </div>
                </div>

                <aside class="h-fit rounded border border-slate-200 bg-slate-50 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Hosted by</p>
                            <p class="font-black text-courtigo-navy">{{ $court->vendorProfile->business_name }}</p>
                        </div>
                        <span class="rounded bg-green-50 px-3 py-1 text-sm font-bold text-green-700">★ {{ $court->rating_average }}</span>
                    </div>
                    <div class="mt-5 rounded bg-white p-4">
                        <p class="text-3xl font-black text-courtigo-navy">₱{{ number_format($court->hourly_rate) }} <span class="text-sm font-semibold text-slate-500">per hour</span></p>
                    </div>
                    <h2 class="mt-6 text-lg font-black text-courtigo-navy">Live availability</h2>
                    <div class="mt-3 grid grid-cols-2 gap-3">
                        @forelse($court->timeSlots->take(6) as $slot)
                            <button class="rounded border border-slate-200 bg-white px-3 py-3 text-left text-sm transition hover:border-courtigo-blue hover:bg-blue-50 data-[selected=true]:border-courtigo-blue data-[selected=true]:bg-blue-50 data-[selected=true]:ring-2 data-[selected=true]:ring-blue-100" type="button" data-slot-option data-slot-id="{{ $slot->id }}" data-slot-label="{{ $slot->slot_date->format('M d') }} · {{ substr($slot->starts_at, 0, 5) }} - {{ substr($slot->ends_at, 0, 5) }}" aria-pressed="false">
                                <span class="block font-bold text-courtigo-navy">{{ $slot->slot_date->format('M d') }}</span>
                                <span class="block text-slate-500">{{ substr($slot->starts_at, 0, 5) }} - {{ substr($slot->ends_at, 0, 5) }}</span>
                            </button>
                        @empty
                            <div class="col-span-2 rounded border border-slate-200 bg-white p-4 text-sm text-slate-500">
                                No open slots right now.
                            </div>
                        @endforelse
                    </div>
                    <p class="mt-3 hidden rounded bg-white px-3 py-2 text-sm font-semibold text-courtigo-navy" data-selected-slot-summary></p>
                    @auth
                        <button class="mt-5 w-full rounded bg-courtigo-green px-5 py-3 font-bold text-white transition hover:bg-green-600 disabled:cursor-not-allowed disabled:bg-slate-300" type="button" data-reserve-button disabled>Choose a slot to reserve</button>
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

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-black text-courtigo-navy">Player reviews</h2>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @forelse($court->reviews as $review)
                <div class="rounded border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <p class="font-black text-courtigo-navy">{{ $review->user->name }}</p>
                        <p class="text-sm font-bold text-courtigo-amber">★ {{ $review->rating }}</p>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $review->comment }}</p>
                </div>
            @empty
                <p class="text-slate-500">No reviews yet.</p>
            @endforelse
        </div>
    </section>

    @push('scripts')
        <script>
            (() => {
                const slotButtons = [...document.querySelectorAll('[data-slot-option]')];
                const reserveButton = document.querySelector('[data-reserve-button]');
                const loginReserveLink = document.querySelector('[data-login-reserve-link]');
                const summary = document.querySelector('[data-selected-slot-summary]');
                const loginUrl = loginReserveLink ? new URL(loginReserveLink.href) : null;

                slotButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        slotButtons.forEach((slotButton) => {
                            slotButton.dataset.selected = 'false';
                            slotButton.setAttribute('aria-pressed', 'false');
                        });

                        button.dataset.selected = 'true';
                        button.setAttribute('aria-pressed', 'true');

                        if (summary) {
                            summary.textContent = `Selected slot: ${button.dataset.slotLabel}`;
                            summary.classList.remove('hidden');
                        }

                        if (reserveButton) {
                            reserveButton.disabled = false;
                            reserveButton.textContent = `Reserve ${button.dataset.slotLabel}`;
                        }

                        if (loginReserveLink && loginUrl) {
                            const redirectUrl = new URL(loginUrl.searchParams.get('redirect'));
                            redirectUrl.searchParams.set('slot', button.dataset.slotId);
                            loginUrl.searchParams.set('redirect', redirectUrl.toString());
                            loginReserveLink.href = loginUrl.toString();
                            loginReserveLink.textContent = `Log in to reserve ${button.dataset.slotLabel}`;
                        }
                    });
                });
            })();
        </script>
    @endpush
@endsection
