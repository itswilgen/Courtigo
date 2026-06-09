<section {{ $attributes->class(['rounded-2xl border border-slate-200 bg-white p-5 shadow-sm']) }}>
    <h2 class="text-lg font-black text-courtigo-navy">Community Rooms</h2>
    <div class="mt-4 space-y-3">
        @foreach ([['Badminton Community', '32 online'], ['Basketball Community', '21 online'], ['Volleyball Community', '14 online'], ['Tennis Community', '9 online']] as $room)
            <div class="rounded-2xl bg-slate-50 p-3">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm font-black text-slate-800">{{ $room[0] }}</span>
                    <span class="text-xs font-bold text-slate-500">{{ $room[1] }}</span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <button class="rounded-xl border border-slate-200 bg-white px-2 py-2 text-xs font-black text-courtigo-navy transition hover:border-courtigo-blue" type="button">View</button>
                    <button class="rounded-xl bg-blue-950 px-2 py-2 text-xs font-black text-white transition hover:bg-blue-950" type="button">Join</button>
                </div>
            </div>
        @endforeach
    </div>
</section>
