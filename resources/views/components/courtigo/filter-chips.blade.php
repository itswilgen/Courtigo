@props(['filters' => ['Basketball', 'Badminton', 'Volleyball', 'Tennis', 'Available Today', 'Near Me']])

<div class="flex gap-2 overflow-x-auto pb-1" data-filter-chips>
    @foreach ($filters as $filter)
        <button class="shrink-0 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-black text-slate-700 shadow-sm transition hover:border-courtigo-blue hover:bg-blue-50 hover:text-courtigo-blue data-[active=true]:border-courtigo-navy data-[active=true]:bg-courtigo-navy data-[active=true]:text-white" type="button" data-filter-chip>
            {{ $filter }}
        </button>
    @endforeach
</div>
