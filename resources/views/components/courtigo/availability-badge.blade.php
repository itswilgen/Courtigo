@props(['label' => 'Available Today', 'tone' => 'available'])

@php
    $classes = [
        'available' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'limited' => 'bg-amber-50 text-amber-700 ring-amber-100',
        'closed' => 'bg-slate-100 text-slate-600 ring-slate-200',
    ][$tone] ?? 'bg-emerald-50 text-emerald-700 ring-emerald-100';
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-black uppercase tracking-wide ring-1', $classes]) }}>
    <span class="h-2 w-2 rounded-full bg-current"></span>
    {{ $label }}
</span>
