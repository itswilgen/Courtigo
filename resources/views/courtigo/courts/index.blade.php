@extends('layouts.app-dashboard', ['title' => 'Courts | Courtigo'])

@section('content')
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
        <section class="min-w-0 space-y-5">
            <div class="dashboard-hero rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Courts feed</p>
                <h1 class="mt-1 text-3xl font-black tracking-tight text-courtigo-navy">Find your next court.</h1>
                <div class="mt-5 grid gap-3 md:grid-cols-[1fr_auto]">
                    <input class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold outline-none transition focus:border-courtigo-blue focus:bg-white" type="search" placeholder="Search by court, venue, or city">
                    <button class="rounded-2xl bg-courtigo-navy px-5 py-3 text-sm font-black text-white transition hover:bg-blue-950" type="button">Filter courts</button>
                </div>
            </div>

            @forelse($courts as $court)
                <x-dashboard.feed-card :court="$court" />
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-sm">
                    <h2 class="text-xl font-black text-courtigo-navy">No courts available</h2>
                    <p class="mt-2 text-sm text-slate-500">Approved court cards will appear in this social feed.</p>
                </div>
            @endforelse
        </section>

        <aside class="space-y-5 xl:sticky xl:top-20 xl:self-start">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <h2 class="text-lg font-black text-courtigo-navy">Popular filters</h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach (['Open now', 'Indoor', 'Outdoor', 'Top rated', 'Near me', 'Featured'] as $filter)
                        <button class="rounded-full bg-slate-100 px-3 py-2 text-xs font-black uppercase tracking-wide text-slate-600 transition hover:bg-blue-50 hover:text-courtigo-blue" type="button">{{ $filter }}</button>
                    @endforeach
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <h2 class="text-lg font-black text-courtigo-navy">Venue updates</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-500">
                    <p class="rounded-2xl bg-slate-50 p-3">New night slots are opening soon for followed venues.</p>
                    <p class="rounded-2xl bg-slate-50 p-3">Follow courts to keep announcements in your feed.</p>
                </div>
            </section>
        </aside>
    </div>
@endsection
