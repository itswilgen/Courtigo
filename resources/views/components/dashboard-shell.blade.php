@props(['title', 'eyebrow'])

<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">{{ $eyebrow }}</p>
            <h1 class="mt-2 text-3xl font-black text-courtigo-navy">{{ $title }}</h1>
        </div>
        <div class="flex gap-2">
            <button class="rounded border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700">Export</button>
            <button class="rounded bg-courtigo-navy px-4 py-2 text-sm font-bold text-white">Create</button>
        </div>
    </div>
    {{ $slot }}
</section>
