@extends('layouts.app-dashboard', ['title' => 'Groups | Courtigo'])

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Community groups</p>
            <h1 class="mt-1 text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">Find clubs, crews, and match rooms.</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Explore sport communities, join upcoming matches, and keep your court life connected.</p>
        </section>

        <section class="space-y-4">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-black text-courtigo-navy">Featured Groups</h2>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-courtigo-blue">Recommended</span>
            </div>
            <div class="grid gap-4 md:grid-cols-2 2xl:grid-cols-3">
                @foreach (array_slice($groups, 0, 3) as $group)
                    <x-courtigo.group-card :group="$group" />
                @endforeach
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <section class="space-y-4">
                <h2 class="text-xl font-black text-courtigo-navy">Suggested Groups</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($groups as $group)
                        <x-courtigo.group-card :group="$group" />
                    @endforeach
                </div>
            </section>

            <aside class="space-y-5">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-black text-courtigo-navy">My Groups</h2>
                    <div class="mt-4 space-y-3">
                        @foreach (array_slice($groups, 0, 2) as $group)
                            <a href="{{ route('groups.show', $group['slug']) }}" class="block rounded-2xl bg-slate-50 p-4 transition hover:bg-blue-50">
                                <span class="block font-black text-slate-900">{{ $group['name'] }}</span>
                                <span class="mt-1 block text-sm font-semibold text-slate-500">{{ $group['next_event'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="space-y-3">
                    @foreach ($rooms as $room)
                        <x-courtigo.community-room-card :room="$room" />
                    @endforeach
                </section>
            </aside>
        </div>
    </div>
@endsection
