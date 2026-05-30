<header class="sticky top-0 z-30 border-b border-white/10 bg-[#001f3f] text-white shadow-sm">
    <div class="flex h-16 items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button class="grid h-10 w-10 place-items-center rounded-2xl border border-white/20 bg-white/10 text-white shadow-sm lg:hidden" type="button" data-sidebar-open aria-label="Open menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
        </div>

        <div class="flex items-center gap-2">
            <button class="relative grid h-10 w-10 place-items-center rounded-2xl text-white/80 transition hover:bg-white/10 hover:text-white" type="button" aria-label="Notifications">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022 23.848 23.848 0 0 0 5.455 1.31m5.714 0a3 3 0 0 1-5.714 0" /></svg>
                <span class="absolute right-2 top-2 h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
            </button>
            <x-dashboard.profile-dropdown />
        </div>
    </div>
</header>
