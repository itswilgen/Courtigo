@props(['vendor'])

<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300">
  
    <!-- Header with Avatar -->
    <div class="relative flex items-start gap-4 bg-gradient-to-br from-slate-50 to-transparent p-5">
        
        <!-- Avatar Container -->
        <div class="relative">
            <img class="h-20 w-20 rounded-xl object-cover ring-2 ring-white shadow-md" 
                 src="{{ $vendor['avatar'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop' }}" 
                 alt="{{ $vendor['business_name'] ?? 'Vendor' }}">
            
            <!-- Status Indicator (bottom-right) -->
            @if($vendor['status'] === 'active' || ($vendor['is_active'] ?? false))
                <span class="absolute -bottom-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500 ring-2 ring-white">
                    <span class="h-3 w-3 rounded-full bg-emerald-300 animate-pulse"></span>
                </span>
            @endif
        </div>

        <!-- Business Info -->
        <div class="flex-1 min-w-0 pt-1">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <h3 class="text-lg font-black text-slate-900 truncate">
                        {{ $vendor['business_name'] ?? $vendor->business_name ?? 'Venue Name' }}
                    </h3>
                    <p class="text-sm font-semibold text-slate-500 truncate">
                        by {{ $vendor['owner_name'] ?? ($vendor->user?->name ?? 'Owner') }}
                    </p>
                </div>
                
                <!-- Verification Badge -->
                @if($vendor['verified'] ?? ($vendor->approved_at ?? false))
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-emerald-100 shrink-0">
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Verified
                    </span>
                @endif
            </div>

            <!-- Location -->
            <div class="mt-2 flex items-center gap-2 text-sm font-medium text-slate-600 truncate">
                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                {{ $vendor['location'] ?? $vendor->city ?? 'Metro Manila' }}
            </div>
        </div>
    </div>

    <!-- Metrics Section -->
    <div class="flex items-center justify-between gap-3 border-t border-slate-100 px-5 py-3 bg-slate-50/50">
        
        <!-- Rating -->
        <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
            <span class="text-amber-500">⭐</span>
            <span class="font-black">{{ $vendor['rating'] ?? $vendor->rating_average ?? 4.8 }}</span>
            <span class="text-slate-500">({{ $vendor['reviews'] ?? $vendor->reviews_count ?? 0 }} reviews)</span>
        </div>

        <!-- Court Count -->
        <div class="text-sm font-black text-blue-700 bg-blue-50 rounded-full px-3 py-1">
            {{ $vendor['court_count'] ?? $vendor->courts_count ?? 0 }} Courts
        </div>
    </div>

    <!-- Description -->
    <div class="px-5 py-4">
        <p class="text-sm leading-5 text-slate-600 line-clamp-2">
            {{ $vendor['description'] ?? $vendor->description ?? 'Premium pickleball venue with world-class facilities and professional coaching.' }}
        </p>
    </div>

    <!-- Actions Footer -->
    <div class="border-t border-slate-100 grid grid-cols-2 gap-2 p-4">
        <a href="{{ route('vendor.show', $vendor['slug'] ?? ($vendor->user?->id ?? '#')) }}" 
           class="rounded-lg bg-slate-900 px-4 py-2.5 text-center text-sm font-black text-white transition-colors hover:bg-slate-950">
            View Profile
        </a>
        <a href="{{ route('vendor.courts', $vendor['slug'] ?? ($vendor->user?->id ?? '#')) }}" 
           class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-center text-sm font-black text-slate-700 transition-colors hover:bg-slate-50">
            Browse Courts
        </a>
    </div>
</article>
