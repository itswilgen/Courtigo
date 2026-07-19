<header class="sticky top-0 z-30 border-b border-slate-200 bg-white text-slate-900 shadow-sm">
    <div class="flex h-16 items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button class="grid h-10 w-10 place-items-center rounded-2xl border border-slate-200 bg-white text-courtigo-navy shadow-sm lg:hidden" type="button" data-sidebar-open aria-label="Open menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
        </div>

        <div class="flex items-center gap-2">
            <button class="grid h-10 w-10 place-items-center rounded-2xl text-slate-700 transition hover:bg-slate-100 hover:text-courtigo-navy xl:hidden" type="button" aria-label="Next reservation" data-mobile-widget-open="reservation">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5-2.25v2.25M3.75 8.25h16.5M5.25 5.25h13.5c.828 0 1.5.672 1.5 1.5v12c0 .828-.672 1.5-1.5 1.5H5.25c-.828 0-1.5-.672-1.5-1.5v-12c0-.828.672-1.5 1.5-1.5Z" /></svg>
            </button>
            <button class="grid h-10 w-10 place-items-center rounded-2xl text-slate-700 transition hover:bg-slate-100 hover:text-courtigo-navy xl:hidden" type="button" aria-label="Community rooms" data-mobile-widget-open="community">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72M15 11.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8.25a6 6 0 1 1 12 0v.75H6v-.75Zm12-10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-12 0a2.25 2.25 0 1 0 4.5 0 2.25 2.25 0 0 0-4.5 0Z" /></svg>
            </button>
            <a href="{{ route('notifications.index') }}" class="relative grid h-10 w-10 place-items-center rounded-2xl text-slate-700 transition hover:bg-slate-100 hover:text-courtigo-navy" aria-label="View notifications">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022 23.848 23.848 0 0 0 5.455 1.31m5.714 0a3 3 0 0 1-5.714 0" /></svg>
                <span class="absolute right-2 top-2 h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
            </a>
            <x-dashboard.profile-dropdown />
        </div>
    </div>
</header>
