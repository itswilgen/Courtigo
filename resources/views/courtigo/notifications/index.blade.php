@extends('layouts.app-dashboard', ['title' => 'Notifications | Courtigo'])

@section('content')
    <div class="mx-auto max-w-4xl space-y-5">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Your updates</p>
                    <h1 class="mt-1 text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">Notifications</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Booking confirmations, court news, and activity from the places and people you follow.</p>
                </div>
                @if ($notifications->contains(fn ($notification) => is_null($notification->read_at)))
                    <form method="POST" action="{{ route('notifications.read-all') }}">@csrf @method('PATCH')<button class="h-11 rounded-2xl border border-slate-200 bg-white px-5 text-sm font-black text-slate-700 transition hover:border-courtigo-blue hover:text-courtigo-blue" type="submit">Mark all as read</button></form>
                @endif
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @forelse ($notifications as $notification)
                <article class="flex gap-4 border-b border-slate-100 p-5 last:border-b-0 {{ is_null($notification->read_at) ? 'bg-blue-50/50' : '' }}">
                    <span class="mt-1 grid h-10 w-10 shrink-0 place-items-center rounded-2xl {{ is_null($notification->read_at) ? 'bg-courtigo-navy text-white' : 'bg-slate-100 text-slate-500' }}">@if (str_contains(strtolower($notification->title), 'booking'))⌚@else🔔@endif</span>
                    <div class="min-w-0 flex-1"><div class="flex flex-wrap items-center justify-between gap-2"><h2 class="font-black text-courtigo-navy">{{ $notification->title }}</h2><time class="text-xs font-semibold text-slate-400">{{ $notification->created_at->diffForHumans() }}</time></div><p class="mt-1 text-sm leading-6 text-slate-600">{{ $notification->message }}</p></div>
                    @if (is_null($notification->read_at))<span class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-courtigo-green" aria-label="Unread"></span>@endif
                </article>
            @empty
                <div class="p-10 text-center"><div class="text-3xl">🔔</div><h2 class="mt-4 text-lg font-black text-courtigo-navy">You’re all caught up</h2><p class="mt-2 text-sm text-slate-500">New booking and court updates will appear here.</p><a href="{{ route('courts.index') }}" class="mt-5 inline-flex rounded-2xl bg-courtigo-navy px-5 py-3 text-sm font-black text-white hover:bg-blue-950">Browse courts</a></div>
            @endforelse
        </section>
    </div>
@endsection
