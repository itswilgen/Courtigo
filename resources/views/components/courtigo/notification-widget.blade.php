<section {{ $attributes->class(['rounded-2xl border border-slate-200 bg-white p-5 shadow-sm']) }}>
    <h2 class="text-lg font-black text-courtigo-navy">Notifications</h2>
    <div class="mt-4 space-y-3">
        @foreach (['New slots opened at Cebu Smash Hub.', 'Metro Sports accepted weekend reservations.', 'A followed court posted a promo.'] as $notice)
            <p class="rounded-2xl bg-slate-50 p-3 text-sm font-semibold text-slate-600">{{ $notice }}</p>
        @endforeach
    </div>
</section>
