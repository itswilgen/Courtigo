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
                        @foreach($court->timeSlots->take(6) as $slot)
                            <button class="rounded border border-slate-200 bg-white px-3 py-3 text-left text-sm hover:border-courtigo-blue">
                                <span class="block font-bold text-courtigo-navy">{{ $slot->slot_date->format('M d') }}</span>
                                <span class="block text-slate-500">{{ substr($slot->starts_at, 0, 5) }} - {{ substr($slot->ends_at, 0, 5) }}</span>
                            </button>
                        @endforeach
                    </div>
                    <button class="mt-5 w-full rounded bg-courtigo-green px-5 py-3 font-bold text-white">Reserve selected slot</button>
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
@endsection
