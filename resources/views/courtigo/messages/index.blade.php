@extends('layouts.app-dashboard', ['title' => 'Messages | Courtigo'])

@section('content')
    <div class="space-y-5">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Community</p>
            <div class="mt-1 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-courtigo-navy sm:text-3xl">Messages</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Coordinate games, share court plans, and stay connected with your community.</p>
                </div>
                <a href="{{ route('friends.index') }}" class="inline-flex h-11 items-center justify-center rounded-2xl bg-courtigo-navy px-5 text-sm font-black text-white transition hover:bg-blue-950">Find players</a>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="grid min-h-[580px] lg:grid-cols-[320px_minmax(0,1fr)]">
                <aside class="border-b border-slate-200 bg-slate-50 p-4 lg:border-b-0 lg:border-r">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-lg font-black text-courtigo-navy">Conversations</h2>
                        <a href="{{ route('groups.index') }}" class="text-sm font-black text-courtigo-blue hover:text-courtigo-navy">Groups</a>
                    </div>
                    <div class="mt-4 space-y-2">
                        @foreach ($conversations as $conversation)
                            <a href="{{ route('messages.index', ['conversation' => $conversation['slug']]) }}" class="flex items-center gap-3 rounded-2xl p-3 transition {{ $active['slug'] === $conversation['slug'] ? 'bg-white shadow-sm ring-1 ring-slate-200' : 'hover:bg-white' }}">
                                @if (str_starts_with($conversation['avatar'], 'http'))
                                    <img class="h-11 w-11 rounded-2xl object-cover" src="{{ $conversation['avatar'] }}" alt="{{ $conversation['name'] }}">
                                @else
                                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-courtigo-navy text-xs font-black text-white">{{ $conversation['avatar'] }}</span>
                                @endif
                                <span class="min-w-0 flex-1">
                                    <span class="flex items-center justify-between gap-2"><span class="truncate text-sm font-black text-slate-800">{{ $conversation['name'] }}</span><span class="shrink-0 text-xs font-semibold text-slate-400">{{ $conversation['time'] }}</span></span>
                                    <span class="mt-1 flex items-center gap-2"><span class="truncate text-xs font-semibold text-slate-500">{{ $conversation['preview'] }}</span>@if($conversation['unread'])<span class="grid h-5 min-w-5 place-items-center rounded-full bg-courtigo-green px-1 text-[10px] font-black text-white">{{ $conversation['unread'] }}</span>@endif</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </aside>

                <div class="flex min-w-0 flex-col">
                    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                        <div><p class="font-black text-courtigo-navy">{{ $active['name'] }}</p><p class="mt-1 text-xs font-semibold text-emerald-600">{{ $active['type'] === 'group' ? 'Community group' : 'Available to play' }}</p></div>
                        <a href="{{ $active['type'] === 'group' ? route('groups.show', $active['slug']) : route('profiles.preview', $active['slug']) }}" class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-black text-slate-700 transition hover:bg-blue-50 hover:text-courtigo-blue">View {{ $active['type'] === 'group' ? 'group' : 'profile' }}</a>
                    </div>
                    <div class="flex-1 space-y-4 bg-slate-50 p-5">
                        <div class="max-w-md rounded-2xl rounded-tl-sm bg-white p-4 text-sm font-semibold leading-6 text-slate-600 shadow-sm">Who is joining the next rally? I can reserve a court if we have enough players.</div>
                        <div class="ml-auto max-w-md rounded-2xl rounded-tr-sm bg-courtigo-navy p-4 text-sm font-semibold leading-6 text-white">I’m in. Let’s check available times and book a slot.</div>
                        <div class="max-w-md rounded-2xl rounded-tl-sm bg-white p-4 text-sm font-semibold leading-6 text-slate-600">Great! I’ll send the court details here once it’s confirmed.</div>
                    </div>
                    <form class="flex gap-2 border-t border-slate-200 p-4" onsubmit="return false;">
                        <input class="h-12 min-w-0 flex-1 rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-100" type="text" placeholder="Write a message…" aria-label="Message {{ $active['name'] }}">
                        <button class="rounded-2xl bg-courtigo-navy px-5 text-sm font-black text-white transition hover:bg-blue-950" type="submit">Send</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
