@extends('layouts.app-dashboard', ['title' => $group['name'].' | Courtigo'])

@section('content')
    <div class="space-y-6">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="h-56 bg-slate-100">
                <img class="h-full w-full object-cover" src="{{ $group['cover'] }}" alt="{{ $group['name'] }}">
            </div>
            <div class="p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">{{ $group['sport'] }} group</p>
                        <h1 class="mt-1 text-3xl font-black text-courtigo-navy">{{ $group['name'] }}</h1>
                        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $group['description'] }}</p>
                    </div>
                    <button class="rounded-2xl bg-courtigo-navy px-5 py-3 text-sm font-black text-white transition hover:bg-blue-950" type="button">Join Group</button>
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <section class="space-y-5">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-xl font-black text-courtigo-navy">Upcoming Events</h2>
                    <div class="mt-4 grid gap-3 md:grid-cols-2">
                        @foreach ([$group['next_event'], 'Open rally next week', 'Beginner-friendly session'] as $event)
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="font-black text-slate-900">{{ $event }}</p>
                                <p class="mt-1 text-sm font-semibold text-slate-500">Placeholder event details</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-xl font-black text-courtigo-navy">Recent Activity</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($activities as $activity)
                            <x-courtigo.activity-card :activity="$activity" />
                        @endforeach
                    </div>
                </section>
            </section>

            <aside class="space-y-5">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-black text-courtigo-navy">Members</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($friends as $friend)
                            <a href="{{ route('profiles.preview', $friend['slug']) }}" class="flex items-center gap-3 rounded-2xl bg-slate-50 p-3 transition hover:bg-blue-50">
                                <img class="h-11 w-11 rounded-2xl object-cover" src="{{ $friend['avatar'] }}" alt="{{ $friend['name'] }}">
                                <span class="font-black text-slate-800">{{ $friend['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>

                <x-courtigo.chat-placeholder compact />
            </aside>
        </div>
    </div>
@endsection
