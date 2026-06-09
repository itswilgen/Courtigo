@props(['following' => false])

<button
    type="button"
    data-follow-button
    data-following="{{ $following ? 'true' : 'false' }}"
    class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 text-sm font-black text-courtigo-navy transition hover:border-courtigo-blue hover:text-courtigo-blue data-[following=true]:border-courtigo-navy data-[following=true]:bg-courtigo-navy data-[following=true]:text-white"
>
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5.25v13.5m6.75-6.75H5.25" data-follow-icon-plus />
        <path class="hidden" stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" data-follow-icon-check />
    </svg>
    <span data-follow-label>{{ $following ? 'Following' : 'Follow' }}</span>
</button>
