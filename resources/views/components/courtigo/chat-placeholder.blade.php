@props(['compact' => false])

<section {{ $attributes->class(['overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm']) }}>
    <div class="grid {{ $compact ? 'grid-cols-1' : 'lg:grid-cols-[260px_minmax(0,1fr)]' }}">
        <aside class="border-b border-slate-200 bg-slate-50 p-4 lg:border-b-0 lg:border-r">
            <h2 class="text-lg font-black text-courtigo-navy">Conversations</h2>
            <div class="mt-4 space-y-2">
                @foreach ([['Friday Badminton', 'Match plans'], ['Marco Reyes', 'See you at 6'], ['Hoop Night PH', 'Court confirmed']] as $chat)
                    <button class="w-full rounded-2xl bg-white p-3 text-left transition hover:bg-blue-50" type="button">
                        <span class="block text-sm font-black text-slate-800">{{ $chat[0] }}</span>
                        <span class="mt-1 block truncate text-xs font-semibold text-slate-500">{{ $chat[1] }}</span>
                    </button>
                @endforeach
            </div>
        </aside>

        <div class="p-4">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm font-black text-slate-900">Friday Badminton</p>
                <div class="mt-4 space-y-3">
                    <p class="max-w-[80%] rounded-2xl bg-white p-3 text-sm font-semibold text-slate-600">Who is joining the 6 PM rally?</p>
                    <p class="ml-auto max-w-[80%] rounded-2xl bg-courtigo-navy p-3 text-sm font-semibold text-white">I am in. I reserved Court 2.</p>
                    <p class="max-w-[80%] rounded-2xl bg-white p-3 text-sm font-semibold text-slate-600">Great, two slots left.</p>
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <input class="h-11 min-w-0 flex-1 rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold outline-none focus:border-courtigo-blue focus:ring-4 focus:ring-blue-100" type="text" placeholder="Message placeholder" disabled>
                <button class="rounded-2xl bg-courtigo-navy px-4 text-sm font-black text-white" type="button">Send</button>
            </div>
        </div>
    </div>
</section>
