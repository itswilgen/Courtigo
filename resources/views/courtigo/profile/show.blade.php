@extends('layouts.app-dashboard', ['title' => 'Profile | Courtigo'])

@section('content')
    <div class="space-y-6">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
            <div class="dashboard-hero h-36"></div>
            <div class="-mt-10 px-5 pb-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div class="flex items-end gap-4">
                        <span class="grid h-24 w-24 place-items-center rounded-2xl border-4 border-white bg-blue-50 text-3xl font-black text-courtigo-blue">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <div class="pb-2">
                            <h1 class="text-3xl font-black text-courtigo-navy">{{ $user->name }}</h1>
                            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('settings.index') }}" class="rounded-2xl bg-courtigo-navy px-5 py-3 text-center text-sm font-black text-white transition hover:bg-blue-950">Edit profile</a>
                </div>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-[360px_minmax(0,1fr)]">
            <aside class="space-y-6">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                    <h2 class="text-xl font-black text-courtigo-navy">Player details</h2>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between gap-4 rounded-2xl bg-slate-50 p-3">
                            <span class="font-bold text-slate-500">Role</span>
                            <span class="font-black uppercase text-courtigo-navy">{{ $user->role }}</span>
                        </div>
                        <div class="flex justify-between gap-4 rounded-2xl bg-slate-50 p-3">
                            <span class="font-bold text-slate-500">Status</span>
                            <span class="font-black uppercase text-emerald-700">{{ $user->status }}</span>
                        </div>
                        <div class="flex justify-between gap-4 rounded-2xl bg-slate-50 p-3">
                            <span class="font-bold text-slate-500">Bookings</span>
                            <span class="font-black text-courtigo-navy">{{ $bookings->count() }}</span>
                        </div>
                    </div>
                </section>
            </aside>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <h2 class="text-xl font-black text-courtigo-navy">Profile feed</h2>
                <div class="mt-4 space-y-3">
                    @foreach (['Court check-ins will appear here.', 'Friend activity placeholder.', 'Followed venue highlights placeholder.'] as $item)
                        <div class="rounded-2xl bg-slate-50 p-4 text-sm font-semibold text-slate-600">{{ $item }}</div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
