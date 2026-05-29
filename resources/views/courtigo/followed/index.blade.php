@extends('layouts.app-dashboard', ['title' => 'Followed Courts | Courtigo'])

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Followed</p>
            <h1 class="mt-1 text-3xl font-black tracking-tight text-courtigo-navy">Venues and courts you follow.</h1>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
            <section class="space-y-5">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                    <h2 class="text-xl font-black text-courtigo-navy">Followed vendors</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @foreach (['Northside Sports Hub', 'Rally Point Manila', 'Pickle Yard PH', 'Metro Court Club'] as $vendor)
                            <article class="rounded-2xl border border-slate-200 p-4">
                                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-blue-50 text-sm font-black text-courtigo-blue">{{ strtoupper(substr($vendor, 0, 1)) }}</span>
                                <h3 class="mt-3 font-black text-courtigo-navy">{{ $vendor }}</h3>
                                <p class="mt-1 text-sm text-slate-500">Vendor update placeholder</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    @forelse($courts as $court)
                        <x-dashboard.feed-card :court="$court" />
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-sm md:col-span-2">
                            <h2 class="text-xl font-black text-courtigo-navy">No followed courts yet</h2>
                            <p class="mt-2 text-sm text-slate-500">Featured courts are shown here as placeholders until follows are connected.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft lg:sticky lg:top-20 lg:self-start">
                <h2 class="text-xl font-black text-courtigo-navy">Recent updates</h2>
                <div class="mt-4 space-y-3">
                    @foreach (['New weekend slots posted', 'Followed venue added a promo', 'Court maintenance notice', 'League night announcement'] as $update)
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="font-bold text-slate-700">{{ $update }}</p>
                            <p class="mt-1 text-sm text-slate-500">Placeholder notification</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
@endsection
