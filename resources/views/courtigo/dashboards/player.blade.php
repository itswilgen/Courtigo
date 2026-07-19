@extends('layouts.app-dashboard', ['title' => 'Home Feed | Courtigo'])

@php
    $statusClasses = [
        'confirmed' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'completed' => 'bg-blue-50 text-blue-700 ring-blue-100',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'cancelled' => 'bg-red-50 text-red-700 ring-red-100',
    ];
@endphp

@section('content')
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <section class="min-w-0 space-y-6">
            <div class="dashboard-hero rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Home feed</p>
                        <h1 class="mt-1 text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">Welcome back, {{ $user->name }}.</h1>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Discover active courts, follow venue updates, and keep your next rally close.</p>
                    </div>
                    <a href="{{ route('courts.index') }}" class="inline-flex justify-center rounded-2xl bg-courtigo-navy px-5 py-3 text-sm font-black text-white transition hover:bg-blue-950">Find courts</a>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['label' => 'Upcoming', 'value' => $metrics['upcoming']],
                        ['label' => 'Confirmed', 'value' => $metrics['confirmed']],
                        ['label' => 'Completed', 'value' => $metrics['completed']],
                        ['label' => 'Total spent', 'value' => 'PHP '.number_format($metrics['spent'])],
                    ] as $metric)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-black uppercase tracking-wide text-slate-500">{{ $metric['label'] }}</p>
                            <p class="mt-2 text-2xl font-black text-courtigo-navy">{{ $metric['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-soft">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-courtigo-navy text-sm font-black text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    <button class="flex-1 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-left text-sm font-bold text-slate-500">Share a court update or invite friends to play...</button>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2 border-t border-slate-100 pt-4 text-sm font-black text-slate-600">
                    <button class="rounded-xl py-2 transition hover:bg-slate-100" type="button">Post</button>
                    <button class="rounded-xl py-2 transition hover:bg-slate-100" type="button">Invite</button>
                    <button class="rounded-xl py-2 transition hover:bg-slate-100" type="button">Check in</button>
                </div>
            </div>

            <div class="space-y-5">
                @forelse($recommendedCourts as $court)
                    <x-dashboard.feed-card :court="$court" />
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-sm">
                        <h2 class="text-xl font-black text-courtigo-navy">No court posts yet</h2>
                        <p class="mt-2 text-sm text-slate-500">Court updates will appear here once venues are available.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <aside class="space-y-6 xl:sticky xl:top-20 xl:self-start">
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
                <div class="p-5">
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Next reservation</p>
                    @if ($nextBooking)
                        <img class="mt-4 h-44 w-full rounded-2xl object-cover" src="{{ $nextBooking->court?->primaryImage() }}" alt="{{ $nextBooking->court?->name ?? 'Reserved court' }}">
                        <h2 class="mt-4 text-xl font-black text-courtigo-navy">{{ $nextBooking->court?->name ?? 'Reserved court' }}</h2>
                        <p class="mt-2 text-sm font-semibold text-slate-600">{{ $nextBooking->booking_date?->format('M d, Y') }} · {{ substr($nextBooking->starts_at, 0, 5) }} - {{ substr($nextBooking->ends_at, 0, 5) }}</p>
                        <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-black uppercase tracking-wide ring-1 {{ $statusClasses[$nextBooking->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">{{ ucfirst($nextBooking->status) }}</span>
                    @else
                        <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5">
                            <h2 class="font-black text-courtigo-navy">No upcoming booking</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-500">Book a live slot and your next game appears here.</p>
                        </div>
                    @endif
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <div class="flex items-center justify-between">
                    <a href="{{ route('notifications.index') }}" class="text-lg font-black text-courtigo-navy hover:text-courtigo-blue">Notifications</a>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-500">{{ $notifications->count() }}</span>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse($notifications as $notification)
                        <div class="rounded-2xl bg-slate-50 p-3">
                            <p class="text-sm font-black text-courtigo-navy">{{ $notification->title }}</p>
                            <p class="mt-1 text-sm leading-5 text-slate-500">{{ $notification->message }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No notifications yet.</p>
                    @endforelse
                </div>
                <a href="{{ route('notifications.index') }}" class="mt-4 inline-flex text-sm font-black text-courtigo-blue hover:text-courtigo-navy">View all notifications <span class="ml-1" aria-hidden="true">&rarr;</span></a>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <h2 class="text-lg font-black text-courtigo-navy">Community rooms</h2>
                <div class="mt-4 space-y-2">
                    @foreach (['Beginner rallies', 'Weekend open play', 'Tournament prep'] as $room)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3 py-3">
                            <span class="text-sm font-bold text-slate-700">{{ $room }}</span>
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        </div>
                    @endforeach
                </div>
            </section>
        </aside>
    </div>
@endsection
