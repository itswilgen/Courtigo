@extends('layouts.app-dashboard', ['title' => 'Settings | Courtigo'])

@section('content')
    <div class="space-y-6">
        <div class="dashboard-hero rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Account</p>
            <h1 class="mt-1 text-3xl font-black tracking-tight text-courtigo-navy">Settings</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Placeholder account controls for the user dashboard architecture.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <h2 class="text-xl font-black text-courtigo-navy">Profile information</h2>
                <div class="mt-5 space-y-4">
                    <label class="block">
                        <span class="text-sm font-black text-slate-600">Name</span>
                        <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600" type="text" value="{{ $user->name }}" disabled>
                    </label>
                    <label class="block">
                        <span class="text-sm font-black text-slate-600">Email</span>
                        <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600" type="email" value="{{ $user->email }}" disabled>
                    </label>
                    <button class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-black text-slate-500" type="button">Profile editing coming soon</button>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft">
                <h2 class="text-xl font-black text-courtigo-navy">Preferences</h2>
                <div class="mt-5 space-y-3">
                    @foreach (['Booking reminders', 'Venue announcements', 'Friend activity', 'Promotional updates'] as $setting)
                        <label class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50 p-4">
                            <span class="font-bold text-slate-700">{{ $setting }}</span>
                            <input class="h-5 w-5 rounded border-slate-300 text-courtigo-blue" type="checkbox" checked disabled>
                        </label>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
