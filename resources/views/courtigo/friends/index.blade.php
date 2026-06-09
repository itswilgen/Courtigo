@extends('layouts.app-dashboard', ['title' => 'Friends | Courtigo'])

@section('content')
    <div class="space-y-5" data-community-tabs>
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
                <div>
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Friends and activity</p>
                    <h1 class="mt-1 text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">Build your play circle.</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Find players, respond to friend requests, and keep up with court activity across your sports community.</p>
                </div>
                <a href="{{ route('groups.index') }}" class="inline-flex h-11 items-center justify-center rounded-2xl bg-courtigo-navy px-5 text-sm font-black text-white transition hover:bg-blue-950">Browse Groups</a>
            </div>

            <div class="mt-5 flex gap-2 overflow-x-auto pb-1">
                @foreach ([['friends', 'Friends'], ['requests', 'Friend Requests'], ['suggested', 'Suggested'], ['activity', 'Activity']] as [$tab, $label])
                    <button class="shrink-0 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-black text-slate-700 transition hover:bg-slate-100 hover:text-courtigo-navy data-[active=true]:border-courtigo-navy data-[active=true]:bg-courtigo-navy data-[active=true]:text-white" type="button" data-community-tab="{{ $tab }}" data-active="{{ $loop->first ? 'true' : 'false' }}">{{ $label }}</button>
                @endforeach
            </div>
        </section>

        <section data-community-panel="friends">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($friends as $friend)
                    <x-courtigo.friend-card :friend="$friend" />
                @endforeach
            </div>
        </section>

        <section class="hidden" data-community-panel="requests">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($friendRequests as $request)
                    <x-courtigo.friend-request-card :request="$request" />
                @endforeach
            </div>
        </section>

        <section class="hidden" data-community-panel="suggested">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($suggestedFriends as $friend)
                    <x-courtigo.suggested-friend-card :friend="$friend" />
                @endforeach
            </div>
        </section>

        <section class="hidden" data-community-panel="activity">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_380px]">
                <div class="space-y-3">
                    @foreach ($activities as $activity)
                        <x-courtigo.activity-card :activity="$activity" />
                    @endforeach
                </div>

                <div class="space-y-4">
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <h2 class="text-lg font-black text-courtigo-navy">Activity Tracking</h2>
                        <div class="mt-4 grid gap-3">
                            @foreach (['Recent bookings at Metro Rally Court', 'Recently joined Friday Badminton Club', 'Recently followed Arena Sports Center', 'Event participation: Saturday doubles'] as $item)
                                <p class="rounded-2xl bg-slate-50 p-3 text-sm font-semibold text-slate-600">{{ $item }}</p>
                            @endforeach
                        </div>
                    </section>
                    <x-courtigo.chat-placeholder compact />
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-2">
            @foreach ($rooms as $room)
                <x-courtigo.community-room-card :room="$room" />
            @endforeach
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('js/community.js') }}" defer></script>
    @endpush
@endsection
