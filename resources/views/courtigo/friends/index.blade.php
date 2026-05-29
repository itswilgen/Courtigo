@extends('layouts.app-dashboard', ['title' => 'Friends | Courtigo'])

@php
    $friends = ['Alyssa Cruz', 'Marco Reyes', 'Jem Santos', 'Nico Lim'];
    $groups = ['Weeknight doubles', 'Ortigas beginners', 'Tournament watchlist'];
    $suggestions = ['Bianca Tan', 'Rafael Ong', 'Sam Villanueva'];
@endphp

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Friends</p>
            <h1 class="mt-1 text-3xl font-black tracking-tight text-courtigo-navy">Build your play circle.</h1>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <h2 class="text-xl font-black text-courtigo-navy">Friends list</h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ($friends as $friend)
                        <article class="flex items-center justify-between rounded-2xl border border-slate-200 p-4 transition hover:-translate-y-0.5 hover:shadow-lg">
                            <div class="flex items-center gap-3">
                                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-blue-50 text-sm font-black text-courtigo-blue">{{ strtoupper(substr($friend, 0, 1)) }}</span>
                                <div>
                                    <h3 class="font-black text-courtigo-navy">{{ $friend }}</h3>
                                    <p class="text-sm font-semibold text-slate-500">Ready to play</p>
                                </div>
                            </div>
                            <button class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-black text-slate-600" type="button">Message</button>
                        </article>
                    @endforeach
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                    <h2 class="text-xl font-black text-courtigo-navy">Friend groups</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($groups as $group)
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="font-black text-courtigo-navy">{{ $group }}</p>
                                <p class="mt-1 text-sm text-slate-500">Placeholder group room</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                    <h2 class="text-xl font-black text-courtigo-navy">Suggested friends</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($suggestions as $friend)
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-3">
                                <span class="font-bold text-slate-700">{{ $friend }}</span>
                                <button class="rounded-xl bg-courtigo-navy px-3 py-2 text-xs font-black text-white" type="button">Add</button>
                            </div>
                        @endforeach
                    </div>
                </section>
            </aside>
        </div>
    </div>
@endsection
