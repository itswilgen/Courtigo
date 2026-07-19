@props(['booking'])

@php
    $court = $booking->court;
    $vendor = $court?->vendorProfile?->business_name ?? 'Courtigo Partner';
    
    $statusColors = [
        'confirmed' => ['border' => 'border-emerald-200', 'bg' => 'bg-white', 'headerBg' => 'from-emerald-50/50', 'headerBorder' => 'border-emerald-100', 'badge' => 'bg-emerald-100 text-emerald-700', 'dot' => 'bg-emerald-500', 'amount' => 'from-emerald-50 to-emerald-50/50 ring-emerald-100'],
        'pending' => ['border' => 'border-amber-200', 'bg' => 'bg-amber-50/40', 'headerBg' => 'from-amber-50/50', 'headerBorder' => 'border-amber-100', 'badge' => 'bg-amber-100 text-amber-700', 'dot' => 'bg-amber-500', 'amount' => 'from-amber-50 to-amber-50/50 ring-amber-100'],
        'completed' => ['border' => 'border-blue-200', 'bg' => 'bg-white', 'headerBg' => 'from-blue-50/50', 'headerBorder' => 'border-blue-100', 'badge' => 'bg-blue-100 text-blue-700', 'dot' => 'bg-blue-500', 'amount' => 'from-blue-50 to-blue-50/50 ring-blue-100'],
        'cancelled' => ['border' => 'border-red-200', 'bg' => 'bg-red-50/20', 'headerBg' => 'from-red-50/50', 'headerBorder' => 'border-red-100', 'badge' => 'bg-red-100 text-red-700', 'dot' => 'bg-red-500', 'amount' => 'from-slate-100 to-slate-50 ring-slate-200'],
    ];
    
    $colors = $statusColors[$booking->status] ?? $statusColors['confirmed'];
@endphp

<article class="overflow-hidden rounded-2xl border-2 shadow-soft transition-all duration-300 {{ $colors['border'] }} {{ $colors['bg'] }} hover:shadow-md">

    <!-- Header Row -->
    <div class="flex items-center justify-between gap-4 border-b {{ $colors['headerBorder'] }} bg-gradient-to-r {{ $colors['headerBg'] }} to-transparent px-6 py-4">

        <!-- Status Badge -->
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-black uppercase tracking-wide {{ $colors['badge'] }}">
                <span class="h-2 w-2 rounded-full {{ $colors['dot'] }}"></span>
                {{ ucfirst($booking->status) }}
            </span>

            <!-- Court Name (Hidden on mobile, shown on desktop) -->
            <h2 class="hidden text-xl font-black text-slate-900 md:block flex-1 truncate">
                {{ $court?->name }}
            </h2>
        </div>

        <!-- Duration Info (right side) -->
        <div class="hidden sm:block text-right">
            <p class="text-sm font-black text-slate-500 uppercase tracking-wide">
                Duration
            </p>
            <p class="mt-1 text-lg font-black text-slate-900">
                2 hours
            </p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid gap-6 p-6 lg:grid-cols-[180px_1fr_280px] lg:items-center">

        <!-- Image Column (Desktop Only) -->
        <div class="hidden lg:flex flex-col gap-0">
            <img class="rounded-xl object-cover h-28 w-44" 
                 src="{{ $court?->primaryImage() }}" 
                 alt="{{ $court?->name ?? 'Court booking' }}">
            
            <!-- Reference -->
            <p class="text-xs font-black uppercase tracking-wider text-slate-400 mt-2">
                Ref: {{ $booking->reference }}
            </p>
        </div>

        <!-- Details Column -->
        <div class="space-y-3">
            <div>
                <h3 class="text-xl font-black text-slate-900 lg:hidden">
                    {{ $court?->name ?? 'Reserved court' }}
                </h3>
                <p class="text-sm font-black text-slate-500">
                    {{ $vendor }}
                </p>
            </div>

            <!-- Location & Type -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    {{ $court?->location ?? 'Location pending' }}
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                    {{ $court?->surface_type ?? 'Indoor' }}
                </span>
            </div>

            <!-- Date & Time -->
            <div class="space-y-1">
                <p class="text-sm font-bold text-slate-900">
                    📅 {{ $booking->booking_date?->format('l, M d, Y') ?? 'Date pending' }}
                </p>
                <p class="text-sm font-bold text-slate-700">
                    ⏰ {{ substr($booking->starts_at ?? '00:00', 0, 5) }} — 
                    {{ substr($booking->ends_at ?? '00:00', 0, 5) }}
                </p>
            </div>
        </div>

        <!-- Amount & Actions Column -->
        <div class="space-y-4">
            <!-- Amount Card -->
            <div class="rounded-xl bg-gradient-to-br {{ $colors['amount'] }} p-4 text-center ring-1">
                <p class="text-xs font-black uppercase tracking-wide text-slate-500">
                    Total Amount
                </p>
                <p class="mt-1 text-2xl font-black text-slate-900">
                    ₱{{ number_format($booking->total_amount) }}
                </p>
                <p class="mt-2 text-xs font-black 
                           @if($booking->status === 'confirmed') text-emerald-700
                           @elseif($booking->status === 'pending') text-amber-700
                           @elseif($booking->status === 'completed') text-blue-700
                           @else text-slate-500 @endif">
                    @if($booking->status === 'confirmed')
                        ✓ Paid
                    @elseif($booking->status === 'pending')
                        Payment Pending
                    @else
                        {{ ucfirst($booking->status) }}
                    @endif
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-2">
                @if($booking->status === 'pending')
                    <a href="{{ route('bookings.payment', $booking) }}" 
                       class="rounded-lg bg-slate-900 px-4 py-2.5 text-center text-sm font-black text-white transition-colors hover:bg-slate-950 active:bg-slate-950">
                        Complete Payment
                    </a>
                @else
                    <a href="{{ $court ? route('courts.show', $court) : route('courts.index') }}" 
                       class="rounded-lg bg-slate-900 px-4 py-2.5 text-center text-sm font-black text-white transition-colors hover:bg-slate-950">
                        View Details
                    </a>
                @endif

                @if($booking->status === 'confirmed' || $booking->status === 'pending')
                    <button type="button" 
                            class="rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-black text-red-700 transition-colors hover:bg-red-50 active:bg-red-100">
                        Cancel Booking
                    </button>
                @elseif($booking->status === 'completed')
                    <a href="{{ $court ? route('courts.show', $court) : route('courts.index') }}" 
                       class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-center text-sm font-black text-slate-700 transition-colors hover:border-slate-300 active:bg-slate-50">
                        Book Again
                    </a>
                @endif
            </div>
        </div>
    </div>
</article>
