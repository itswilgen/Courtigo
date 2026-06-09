<div class="fixed inset-0 z-50 hidden" data-slots-modal aria-hidden="true">
    <div class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm" data-slots-close></div>
    <div class="absolute inset-x-4 top-1/2 mx-auto max-w-lg -translate-y-1/2 rounded-2xl border border-slate-200 bg-white p-5 shadow-2xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-black uppercase tracking-wide text-courtigo-blue">Court 1</p>
                <h2 class="mt-1 text-2xl font-black text-courtigo-navy" data-slots-title>Available slots</h2>
                <p class="mt-1 text-sm font-semibold text-slate-500" data-slots-vendor>Today</p>
            </div>
            <button class="grid h-10 w-10 place-items-center rounded-2xl text-slate-500 transition hover:bg-slate-100 hover:text-courtigo-navy" type="button" data-slots-close aria-label="Close slots">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3" data-slots-list></div>

        <div class="mt-5 grid grid-cols-2 gap-3">
            <button class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue" type="button" data-slots-close>Close</button>
            <button class="rounded-2xl bg-courtigo-green px-4 py-3 text-sm font-black text-white transition hover:bg-green-600" type="button">Reserve</button>
        </div>
    </div>
</div>
