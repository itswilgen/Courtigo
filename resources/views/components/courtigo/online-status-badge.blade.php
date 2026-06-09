@props(['status' => 'online'])

@php
    $state = strtolower($status);
    $meta = [
        'online' => ['label' => 'Online', 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-100'],
        'away' => ['label' => 'Away', 'class' => 'bg-amber-50 text-amber-700 ring-amber-100'],
        'offline' => ['label' => 'Offline', 'class' => 'bg-slate-100 text-slate-600 ring-slate-200'],
    ][$state] ?? ['label' => ucfirst($status), 'class' => 'bg-slate-100 text-slate-600 ring-slate-200'];
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-black uppercase tracking-wide ring-1', $meta['class']]) }}>
    <span class="h-2 w-2 rounded-full bg-current"></span>
    {{ $meta['label'] }}
</span>
