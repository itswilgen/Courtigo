@props(['label', 'value'])

<div class="rounded border border-slate-200 bg-white p-4">
    <p class="text-2xl font-black text-courtigo-navy">{{ number_format($value) }}</p>
    <p class="mt-1 text-xs font-bold uppercase tracking-wide text-slate-500">{{ $label }}</p>
</div>
