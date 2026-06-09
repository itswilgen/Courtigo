@props(['profile'])

<section {{ $attributes->class(['overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm']) }}>
    <div class="h-32 bg-courtigo-navy"></div>
    <div class="p-5">
        <div class="-mt-16 flex flex-wrap items-end justify-between gap-4">
            <img class="h-24 w-24 rounded-2xl border-4 border-white object-cover shadow-lg" src="{{ $profile['avatar'] }}" alt="{{ $profile['name'] }}">
            <div class="grid grid-cols-3 gap-2 text-center">
                <div class="rounded-2xl bg-slate-50 px-3 py-2">
                    <p class="text-lg font-black text-courtigo-navy">{{ $profile['friends'] }}</p>
                    <p class="text-xs font-bold text-slate-500">Friends</p>
                </div>
                <div class="rounded-2xl bg-slate-50 px-3 py-2">
                    <p class="text-lg font-black text-courtigo-navy">{{ $profile['groups'] }}</p>
                    <p class="text-xs font-bold text-slate-500">Groups</p>
                </div>
                <div class="rounded-2xl bg-slate-50 px-3 py-2">
                    <p class="text-lg font-black text-courtigo-navy">{{ $profile['bookings'] }}</p>
                    <p class="text-xs font-bold text-slate-500">Games</p>
                </div>
            </div>
        </div>

        <h1 class="mt-4 text-2xl font-black text-slate-900">{{ $profile['name'] }}</h1>
        <p class="mt-1 text-sm font-semibold text-slate-500">{{ $profile['location'] }}</p>
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($profile['sports'] as $sport)
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-courtigo-blue">{{ $sport }}</span>
            @endforeach
        </div>

        <div class="mt-5 grid gap-2 sm:grid-cols-3">
            <button class="rounded-2xl bg-courtigo-navy px-4 py-3 text-sm font-black text-white transition hover:bg-blue-950" type="button">Add Friend</button>
            <button class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue" type="button">Message</button>
            <button class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue" type="button">Follow</button>
        </div>
    </div>
</section>
