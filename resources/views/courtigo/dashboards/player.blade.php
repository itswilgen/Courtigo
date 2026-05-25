@extends('layouts.courtigo', ['title' => 'Player Dashboard | Courtigo'])

@section('content')
    <x-dashboard-shell title="Player Dashboard" eyebrow="Discover, book, favorite">
        <div class="grid gap-5 lg:grid-cols-[1fr_360px]">
            <section class="rounded border border-slate-200 bg-white p-5">
                <h2 class="text-xl font-black text-courtigo-navy">My bookings</h2>
                <div class="mt-4 space-y-3">
                    @foreach($bookings as $booking)
                        <div class="flex flex-col gap-3 rounded border border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-black text-courtigo-navy">{{ $booking->court->name }}</p>
                                <p class="text-sm text-slate-500">{{ $booking->booking_date->format('M d, Y') }} · {{ substr($booking->starts_at, 0, 5) }} · {{ $booking->reference }}</p>
                            </div>
                            <span class="w-fit rounded bg-green-50 px-3 py-1 text-sm font-bold text-green-700">{{ ucfirst($booking->status) }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
            <aside class="rounded border border-slate-200 bg-white p-5">
                <h2 class="text-xl font-black text-courtigo-navy">Favorites</h2>
                <div class="mt-4 space-y-4">
                    @foreach($favoriteCourts as $court)
                        <a href="{{ route('courts.show', $court) }}" class="flex gap-3">
                            <img class="h-20 w-24 rounded object-cover" src="{{ $court->primaryImage() }}" alt="{{ $court->name }}">
                            <div>
                                <p class="font-black text-courtigo-navy">{{ $court->name }}</p>
                                <p class="text-sm text-slate-500">{{ $court->city }} · ₱{{ number_format($court->hourly_rate) }}/hr</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </x-dashboard-shell>
@endsection
