@extends('layouts.app-dashboard', ['title' => $profilePreview['name'].' | Courtigo'])

@section('content')
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">
        <div class="space-y-5">
            <x-courtigo.user-profile-preview :profile="$profilePreview" />

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-xl font-black text-courtigo-navy">Recent Activity</h2>
                <div class="mt-4 space-y-3">
                    @foreach ($activities as $activity)
                        <x-courtigo.activity-card :activity="$activity" />
                    @endforeach
                </div>
            </section>
        </div>

        <aside class="space-y-5">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-black text-courtigo-navy">Joined Groups</h2>
                <div class="mt-4 space-y-3">
                    @foreach (array_slice($groups, 0, 3) as $group)
                        <a href="{{ route('groups.show', $group['slug']) }}" class="block rounded-2xl bg-slate-50 p-4 transition hover:bg-blue-50">
                            <span class="block font-black text-slate-900">{{ $group['name'] }}</span>
                            <span class="mt-1 block text-sm font-semibold text-slate-500">{{ $group['members'] }} members</span>
                        </a>
                    @endforeach
                </div>
            </section>

            <x-courtigo.chat-placeholder compact />
        </aside>
    </div>
@endsection
