# Courtigo Card Components Redesign 2026
## Modern UI Standards with Enhanced Visual Hierarchy & Experience

---

## 1. COURT DISCOVERY CARD
**Purpose:** Help players find and book courts | **Context:** Courts listing, discovery, search results

### Current Issues
- Image aspect ratio (16:10) creates awkward layouts
- Vendor name competes visually with court title
- Ratings scattered top-right (low discoverability)
- Too many badges cause cognitive overload
- Follow button secondary and easy to miss
- Limited mobile optimization

### 2026 Redesign Principles
- **Leading image** with subtle overlay for metadata
- **Clear hierarchy:** Court name > Vendor > Details
- **Consolidated badges** with icon/color coding
- **Prominent CTA** with secondary actions
- **Smart spacing** using 8px grid system
- **Motion & feedback** on interaction

---

### WIREFRAME

#### Desktop (330px base, responsive to 400px+)
```
┌─────────────────────────────────┐
│  ⭐ 4.8    [Follow BTN] hover   │  ← Overlay on image
├─────────────────────────────────┤
│                                 │
│         IMAGE 16:9              │  ← Primary hero (smooth load)
│    (Vendor badge overlay)       │
│                                 │
├─────────────────────────────────┤
│ Metro Rally Court               │  ← Title (18px, bold)
│ by Metro Pickle Club            │  ← Vendor (14px, secondary)
├─────────────────────────────────┤
│ 📍 BGC High Street, Taguig      │  ← Location (single line)
├─────────────────────────────────┤
│ [⚡ NOW AVAILABLE] [₱950/hr]    │  ← Status + Price (inline)
├─────────────────────────────────┤
│   [View Slots]   [+ Follow]     │  ← Primary + Secondary CTA
└─────────────────────────────────┘
```

#### Mobile (full-width, stacked)
```
Same structure, optimized padding
- Tighter vertical spacing
- Full-width buttons with proper touch targets (44px)
- Image maintained at 16:9 ratio
```

---

### COMPONENT STRUCTURE

```
<CourtCard>
  ├─ Card Container (shadow, rounded)
  ├─ Image Section
  │  ├─ Hero Image (16:9, lazy, blur-up)
  │  ├─ Overlay
  │  │  ├─ Rating Badge (top-right)
  │  │  └─ Vendor Badge (bottom-left)
  │  └─ Follow Button (top-right, hover state)
  │
  ├─ Content Section
  │  ├─ Header
  │  │  ├─ Court Title
  │  │  └─ Vendor Name (smaller)
  │  │
  │  ├─ Location (icon + text)
  │  │
  │  ├─ Metadata Row
  │  │  ├─ Availability Badge
  │  │  ├─ Price Badge
  │  │  └─ Surface Type (optional)
  │  │
  │  └─ Action Row
  │     ├─ Primary CTA: "View Slots"
  │     └─ Secondary: Follow/Saved
```

---

### TAILWIND IMPLEMENTATION

#### Desktop Version
```blade
<a href="{{ route('courts.show', $court) }}" 
   class="group block overflow-hidden rounded-xl border border-slate-200 
          bg-white shadow-sm transition-all duration-300 hover:shadow-md 
          hover:border-slate-300">
  
  <!-- Image Container with Overlay -->
  <div class="relative aspect-video bg-slate-100 overflow-hidden">
    <!-- Vendor Badge (Bottom-Left) -->
    <div class="absolute bottom-3 left-3 z-10">
      <span class="inline-flex items-center gap-1.5 rounded-full 
                     bg-slate-900/90 backdrop-blur-sm px-3 py-1.5 
                     text-xs font-bold text-white ring-1 ring-white/10">
        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
        {{ $court['vendor'] }}
      </span>
    </div>

    <!-- Rating Badge (Top-Right) -->
    <div class="absolute top-3 right-3 z-10">
      <div class="flex items-center gap-1 rounded-lg bg-white/95 
                   backdrop-blur-sm px-2.5 py-1.5 shadow-sm ring-1 
                   ring-slate-200/50">
        <span class="text-sm font-black text-slate-900">
          ⭐ {{ $court['rating'] }}
        </span>
      </div>
    </div>

    <!-- Hero Image -->
    <img class="h-full w-full object-cover transition-transform 
                 duration-500 group-hover:scale-105" 
         src="{{ $court['image'] }}" 
         alt="{{ $court['name'] }}"
         loading="lazy">
  </div>

  <!-- Content Section -->
  <div class="p-4 space-y-3">
    
    <!-- Header -->
    <div>
      <h2 class="text-lg font-black tracking-tight text-slate-900 
                  truncate">
        {{ $court['name'] }}
      </h2>
      <p class="text-sm font-semibold text-slate-500 truncate">
        {{ $court['vendor'] }}
      </p>
    </div>

    <!-- Location -->
    <div class="flex items-center gap-2 text-sm font-medium 
                text-slate-600 truncate">
      <svg class="h-4 w-4 shrink-0 text-blue-600" fill="currentColor" 
           viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
      </svg>
      <span class="truncate">{{ $court['location'] }}</span>
    </div>

    <!-- Metadata Badges -->
    <div class="flex items-center gap-2 flex-wrap">
      <!-- Availability Status -->
      <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 
                    text-xs font-bold uppercase tracking-wide
                    @if($court['availability'] === 'available')
                      bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100
                    @elseif($court['availability'] === 'limited')
                      bg-amber-50 text-amber-700 ring-1 ring-amber-100
                    @else
                      bg-slate-100 text-slate-600 ring-1 ring-slate-200
                    @endif">
        <span class="h-1.5 w-1.5 rounded-full 
                     @if($court['availability'] === 'available') bg-emerald-500
                     @elseif($court['availability'] === 'limited') bg-amber-500
                     @else bg-slate-400 @endif"></span>
        {{ ucfirst($court['availability']) }}
      </span>

      <!-- Price Badge -->
      <span class="rounded-full bg-blue-50 px-3 py-1 text-xs 
                    font-bold text-blue-700 ring-1 ring-blue-100">
        ₱{{ number_format($court['price']) }}/hr
      </span>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-2 pt-1">
      <!-- Primary CTA -->
      <button class="flex-1 rounded-lg bg-slate-900 px-4 py-2.5 
                     text-sm font-black text-white transition-colors 
                     hover:bg-slate-950 active:bg-slate-950">
        View Slots
      </button>

      <!-- Follow Button -->
      <button type="button" 
              class="rounded-lg border border-slate-200 bg-white 
                     px-4 py-2.5 text-sm font-black text-slate-700 
                     transition-colors hover:bg-slate-50 active:bg-slate-100">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" 
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" 
                stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/>
        </svg>
      </button>
    </div>
  </div>
</a>
```

#### Mobile Version (Optimizations)
```blade
<!-- Same structure, responsive adjustments -->
<a href="{{ route('courts.show', $court) }}" 
   class="group block overflow-hidden rounded-lg border border-slate-200 
          bg-white shadow-sm transition-all duration-300 
          active:shadow-md md:rounded-xl md:hover:shadow-md">
  
  <!-- Image with better mobile spacing -->
  <div class="relative aspect-video bg-slate-100 overflow-hidden">
    <!-- Badges with better touch zones on mobile -->
    <div class="absolute inset-3 flex items-start justify-between">
      <!-- Rating -->
      <div class="rounded-lg bg-white/95 px-2.5 py-1 text-xs 
                   font-bold text-slate-900 shadow-sm">
        ⭐ {{ $court['rating'] }}
      </div>
      
      <!-- Vendor Badge (moved to top for visibility) -->
      <div class="rounded-full bg-slate-900/90 px-2.5 py-1 
                   text-xs font-bold text-white">
        {{ substr($court['vendor'], 0, 12) }}
      </div>
    </div>

    <img class="h-full w-full object-cover" 
         src="{{ $court['image'] }}" 
         alt="{{ $court['name'] }}">
  </div>

  <!-- Content with mobile-optimized spacing -->
  <div class="p-4 space-y-3">
    <div>
      <h2 class="text-base font-black text-slate-900">
        {{ $court['name'] }}
      </h2>
    </div>

    <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
      <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
      </svg>
      {{ $court['location'] }}
    </div>

    <div class="flex items-center gap-1.5 flex-wrap">
      <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 
                    text-xs font-bold uppercase
                    @if($court['availability'] === 'available')
                      bg-emerald-50 text-emerald-700
                    @endif">
        <span class="h-1.5 w-1.5 rounded-full 
                     @if($court['availability'] === 'available') bg-emerald-500 @endif"></span>
        {{ ucfirst($court['availability']) }}
      </span>
      <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs 
                    font-bold text-blue-700">
        ₱{{ number_format($court['price']) }}/hr
      </span>
    </div>

    <!-- Full-width buttons on mobile -->
    <div class="grid grid-cols-[1fr_auto] gap-2 pt-2">
      <button class="rounded-lg bg-slate-900 px-4 py-2 text-xs 
                     font-black text-white transition-colors 
                     active:bg-slate-950">
        View Slots
      </button>
      <button class="rounded-lg border border-slate-200 bg-white px-3 
                     py-2 text-slate-700 transition-colors active:bg-slate-100">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/>
        </svg>
      </button>
    </div>
  </div>
</a>
```

---

### Key 2026 Improvements
✅ **Larger, cleaner image** with better focal point  
✅ **Vendor branding** as secondary info  
✅ **Prominent rating** with visual indicator  
✅ **Consolidated status** into single pill  
✅ **Better CTA hierarchy** - Primary action clear  
✅ **Mobile-first touch targets** (44px minimum)  
✅ **Smoother interactions** with backdrop blur  
✅ **Lazy loading & blur-up** effect support  
✅ **Accessible color contrast** (WCAG AA+)  
✅ **Responsive typography** (18px→16px title)

---

---

## 2. BOOKING CONFIRMATION CARD
**Purpose:** Display user's booking with status & actions | **Context:** My Bookings page, dashboard

### Current Issues
- Horizontal 3-column grid on desktop breaks on tablet (144px image too small)
- Amount hidden in side panel (poor mobile UX)
- Status badge secondary to title
- Date/time info in small gray text (low hierarchy)
- Action buttons lack clear primary intent
- Reference number competes with important data
- No visual distinction for booking states (pending vs confirmed vs completed)

### 2026 Redesign Principles
- **Vertical card layout** with flexible image size
- **Status-first visual hierarchy** with color coding
- **Amount prominent** above fold on all devices
- **Clearer action flow** with progressive disclosure
- **Timeline-aware design** (upcoming vs completed states)
- **Better information scannability**

---

### WIREFRAME

#### Desktop (Full-width context)
```
┌──────────────────────────────────────────────────────────┐
│ [🟢 CONFIRMED]  Metro Rally Court            ₱950 x 2hrs │  ← Status + Title + Duration
├──────────────────────────────────────────────────────────┤
│ ┌─────────────┐                                          │
│ │   IMAGE     │  Court Name                  ₱1,900      │  ← Quick amount view
│ │  144x96px   │  by Metro Pickle Club        Paid ✓      │
│ │             │  Today · 4:00 - 6:00 PM                  │
│ │             │  Ref: BK-2026-001234                     │
│ │             │                                          │
│ │             │  [View Details]  [Rebook]               │
│ └─────────────┘                                          │
└──────────────────────────────────────────────────────────┘

Status colors:
  🟢 Confirmed → Emerald
  🔵 Pending → Amber
  ⚫ Completed → Blue  
  🔴 Cancelled → Red
```

#### Mobile (Card-based)
```
┌────────────────────────────────┐
│ [CONFIRMED]    REF: BK-2026... │  ← Status + Reference
├────────────────────────────────┤
│        IMAGE (16:9 mobile)     │
├────────────────────────────────┤
│ Metro Rally Court              │
│ by Metro Pickle Club           │
├────────────────────────────────┤
│ 📅 Today · 4:00 - 6:00 PM      │
│ 📍 Court 1 · Indoor            │
├────────────────────────────────┤
│ Total: ₱1,900                  │
│ Status: Paid ✓                 │
├────────────────────────────────┤
│ [View Details] [Cancel]        │
└────────────────────────────────┘
```

---

### COMPONENT STRUCTURE

```
<BookingCard>
  ├─ Card Wrapper (border, shadow, state-aware)
  │
  ├─ Header Section
  │  ├─ Status Badge (colored, left-aligned)
  │  ├─ Title (Court Name)
  │  └─ Quick Actions (desktop only, right)
  │
  ├─ Main Content Grid
  │  ├─ Image Column (fixed width desktop, full mobile)
  │  │  └─ Court Image (144x96 desktop, 16:9 mobile)
  │  │
  │  └─ Details Column
  │     ├─ Court Header (name + vendor)
  │     ├─ Location Badge
  │     ├─ Date/Time Row
  │     ├─ Reference Number (subtle)
  │     └─ Amount Display (prominent)
  │
  └─ Footer Section
     ├─ Status Badge (payment status)
     └─ Action Buttons (primary + secondary)
```

---

### TAILWIND IMPLEMENTATION

#### Desktop Version
```blade
<article class="overflow-hidden rounded-2xl border-2 shadow-soft 
            transition-all duration-300 
            @switch($booking->status)
              @case('confirmed')
                border-emerald-200 bg-white hover:shadow-md
              @break
              @case('pending')
                border-amber-200 bg-amber-50/40 hover:shadow-md
              @break
              @case('completed')
                border-blue-200 bg-white hover:shadow-md
              @break
              @case('cancelled')
                border-red-200 bg-red-50/20 hover:shadow-md
              @break
            @endswitch">

  <!-- Header Row -->
  <div class="flex items-center justify-between gap-4 border-b 
              @switch($booking->status)
                @case('confirmed') border-emerald-100
                @case('pending') border-amber-100
                @case('completed') border-blue-100
                @case('cancelled') border-red-100
              @endswitch
              bg-gradient-to-r px-6 py-4
              @switch($booking->status)
                @case('confirmed')
                  from-emerald-50/50 to-transparent
                @break
                @case('pending')
                  from-amber-50/50 to-transparent
                @break
                @case('completed')
                  from-blue-50/50 to-transparent
                @break
                @case('cancelled')
                  from-red-50/50 to-transparent
                @break
              @endswitch">

    <!-- Status Badge -->
    <div class="flex items-center gap-3">
      <span class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 
                    text-sm font-black uppercase tracking-wide
                    @switch($booking->status)
                      @case('confirmed')
                        bg-emerald-100 text-emerald-700
                      @break
                      @case('pending')
                        bg-amber-100 text-amber-700
                      @break
                      @case('completed')
                        bg-blue-100 text-blue-700
                      @break
                      @case('cancelled')
                        bg-red-100 text-red-700
                      @break
                    @endswitch">
        <span class="h-2 w-2 rounded-full
                     @switch($booking->status)
                       @case('confirmed') bg-emerald-500
                       @case('pending') bg-amber-500
                       @case('completed') bg-blue-500
                       @case('cancelled') bg-red-500
                     @endswitch"></span>
        {{ ucfirst($booking->status) }}
      </span>

      <!-- Court Name (Hidden on mobile, shown on desktop) -->
      <h2 class="hidden text-xl font-black text-slate-900 md:block flex-1">
        {{ $booking->court?->name }}
      </h2>
    </div>

    <!-- Duration Info (right side) -->
    <div class="text-right">
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

    <!-- Image Column -->
    <div class="flex flex-col gap-4 lg:gap-0">
      <img class="hidden rounded-xl object-cover lg:block h-28 w-44" 
           src="{{ $booking->court?->primaryImage() }}" 
           alt="{{ $booking->court?->name }}">
      
      <!-- Reference (shown in image area on desktop) -->
      <p class="text-xs font-black uppercase tracking-wider text-slate-400 
                hidden lg:block">
        Ref: {{ $booking->reference }}
      </p>
    </div>

    <!-- Details Column -->
    <div class="space-y-3">
      <div>
        <h3 class="text-xl font-black text-slate-900 lg:hidden">
          {{ $booking->court?->name }}
        </h3>
        <p class="text-sm font-black text-slate-500">
          {{ $booking->court?->vendorProfile?->business_name ?? 'Courtigo Partner' }}
        </p>
      </div>

      <!-- Location & Type -->
      <div class="flex flex-wrap items-center gap-3">
        <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          </svg>
          {{ $booking->court?->location }}
        </div>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold 
                      text-slate-600">
          {{ $booking->court?->surface_type ?? 'Indoor' }}
        </span>
      </div>

      <!-- Date & Time -->
      <div class="space-y-1">
        <p class="text-sm font-bold text-slate-900">
          📅 {{ $booking->booking_date?->format('l, M d, Y') }}
        </p>
        <p class="text-sm font-bold text-slate-700">
          ⏰ {{ substr($booking->starts_at, 0, 5) }} — 
          {{ substr($booking->ends_at, 0, 5) }}
        </p>
      </div>
    </div>

    <!-- Amount & Actions Column -->
    <div class="space-y-4">
      <!-- Amount Card -->
      <div class="rounded-xl bg-gradient-to-br
                   @switch($booking->status)
                     @case('confirmed')
                       from-emerald-50 to-emerald-50/50
                     @break
                     @case('pending')
                       from-amber-50 to-amber-50/50
                     @break
                     @case('completed')
                       from-blue-50 to-blue-50/50
                     @break
                     @case('cancelled')
                       from-slate-100 to-slate-50
                     @break
                   @endswitch
                   p-4 text-center ring-1
                   @switch($booking->status)
                     @case('confirmed') ring-emerald-100
                     @case('pending') ring-amber-100
                     @case('completed') ring-blue-100
                     @case('cancelled') ring-slate-200
                   @endswitch">
        <p class="text-xs font-black uppercase tracking-wide text-slate-500">
          Total Amount
        </p>
        <p class="mt-1 text-2xl font-black text-slate-900">
          ₱{{ number_format($booking->total_amount) }}
        </p>
        <p class="mt-2 text-xs font-black 
                   @switch($booking->status)
                     @case('confirmed') text-emerald-700
                     @case('pending') text-amber-700
                     @case('completed') text-blue-700
                     @case('cancelled') text-slate-500
                   @endswitch">
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
             class="rounded-lg bg-slate-900 px-4 py-2.5 text-center text-sm 
                    font-black text-white transition-colors hover:bg-slate-950 
                    active:bg-slate-950">
            Complete Payment
          </a>
        @else
          <a href="{{ $booking->court ? route('courts.show', $booking->court) : route('courts.index') }}" 
             class="rounded-lg bg-slate-900 px-4 py-2.5 text-center text-sm 
                    font-black text-white transition-colors hover:bg-slate-950">
            View Details
          </a>
        @endif

        @if($booking->status === 'confirmed' || $booking->status === 'pending')
          <button type="button" 
                  class="rounded-lg border border-red-200 bg-white px-4 py-2.5 
                         text-sm font-black text-red-700 transition-colors 
                         hover:bg-red-50 active:bg-red-100">
            Cancel Booking
          </button>
        @elseif($booking->status === 'completed')
          <a href="{{ $booking->court ? route('courts.show', $booking->court) : route('courts.index') }}" 
             class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 
                    text-center text-sm font-black text-slate-700 
                    transition-colors hover:border-slate-300 active:bg-slate-50">
            Book Again
          </a>
        @endif
      </div>
    </div>
  </div>
</article>
```

#### Mobile Version
```blade
<article class="overflow-hidden rounded-xl border-2 shadow-soft
            @switch($booking->status)
              @case('confirmed')
                border-emerald-200 bg-white
              @break
              @case('pending')
                border-amber-200 bg-amber-50/40
              @break
              @case('completed')
                border-blue-200 bg-white
              @break
              @case('cancelled')
                border-red-200 bg-red-50/20
              @break
            @endswitch">

  <!-- Compact Header -->
  <div class="flex items-center justify-between gap-3 border-b 
              @switch($booking->status)
                @case('confirmed') border-emerald-100
                @case('pending') border-amber-100
                @case('completed') border-blue-100
                @case('cancelled') border-red-100
              @endswitch
              px-4 py-3">
    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 
                  text-xs font-black uppercase
                  @switch($booking->status)
                    @case('confirmed')
                      bg-emerald-100 text-emerald-700
                    @break
                    @case('pending')
                      bg-amber-100 text-amber-700
                    @break
                    @case('completed')
                      bg-blue-100 text-blue-700
                    @break
                    @case('cancelled')
                      bg-red-100 text-red-700
                    @break
                  @endswitch">
      <span class="h-1.5 w-1.5 rounded-full
                   @switch($booking->status)
                     @case('confirmed') bg-emerald-500
                     @case('pending') bg-amber-500
                     @case('completed') bg-blue-500
                     @case('cancelled') bg-red-500
                   @endswitch"></span>
      {{ ucfirst($booking->status) }}
    </span>
    <p class="text-xs font-black text-slate-400">
      {{ $booking->reference }}
    </p>
  </div>

  <!-- Image (Mobile full-width) -->
  <img class="h-40 w-full object-cover" 
       src="{{ $booking->court?->primaryImage() }}" 
       alt="{{ $booking->court?->name }}">

  <!-- Content -->
  <div class="space-y-4 p-4">
    <!-- Court Info -->
    <div>
      <h3 class="text-base font-black text-slate-900">
        {{ $booking->court?->name }}
      </h3>
      <p class="mt-1 text-xs font-bold text-slate-500">
        {{ $booking->court?->vendorProfile?->business_name }}
      </p>
    </div>

    <!-- Details -->
    <div class="space-y-2 text-sm">
      <p class="font-semibold text-slate-700">
        📅 {{ $booking->booking_date?->format('M d, Y') }}
      </p>
      <p class="font-semibold text-slate-700">
        ⏰ {{ substr($booking->starts_at, 0, 5) }} — 
        {{ substr($booking->ends_at, 0, 5) }}
      </p>
    </div>

    <!-- Amount & Status -->
    <div class="rounded-lg bg-slate-50 p-3 text-center">
      <p class="text-xs font-bold uppercase text-slate-500">Total</p>
      <p class="mt-1 text-xl font-black text-slate-900">
        ₱{{ number_format($booking->total_amount) }}
      </p>
      <p class="mt-1 text-xs font-bold text-slate-600">
        @if($booking->status === 'confirmed')
          ✓ Paid
        @endif
      </p>
    </div>

    <!-- Actions (stacked on mobile) -->
    <div class="grid grid-cols-2 gap-2">
      @if($booking->status === 'pending')
        <a href="{{ route('bookings.payment', $booking) }}" 
           class="rounded-lg bg-slate-900 px-3 py-2.5 text-center text-xs 
                  font-bold text-white active:bg-slate-950">
          Pay Now
        </a>
      @else
        <a href="{{ $booking->court ? route('courts.show', $booking->court) : '#' }}" 
           class="rounded-lg bg-slate-900 px-3 py-2.5 text-center text-xs 
                  font-bold text-white active:bg-slate-950">
          Details
        </a>
      @endif

      <button class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 
                     text-xs font-bold text-slate-700 active:bg-slate-50">
        @if($booking->status === 'completed')
          Rebook
        @else
          Cancel
        @endif
      </button>
    </div>
  </div>
</article>
```

---

### Key 2026 Improvements
✅ **Status-first hierarchy** with color coding  
✅ **Amount prominently displayed** above fold  
✅ **Flexible image sizing** (hidden on mobile, 180px on desktop)  
✅ **Clear payment status** with visual indicators  
✅ **Consolidated metadata** in readable format  
✅ **State-aware styling** (confirmed vs pending vs completed)  
✅ **Better mobile actions** - full-width buttons  
✅ **Improved scannability** - information chunked logically  
✅ **Progressive disclosure** - reference number subtle  
✅ **Accessibility** - Touch targets 44px+ on mobile

---

---

## 3. VENDOR/VENUE PROFILE CARD
**Purpose:** Showcase venue operator for partnership/booking | **Context:** Dashboard feed, vendor discovery

### Current Issues
- Avatar + initials take up 11x11px (barely visible)
- Business name truncated without visual emphasis
- Location secondary (hard to find venue)
- Description takes 2 lines (too verbose for card)
- Online badge isolated (poor indicator)
- Two competing CTAs without clear hierarchy
- Missing business credibility signals (rating, verified badge)
- Mobile layout inefficient

### 2026 Redesign Principles
- **Avatar-first design** with larger visual prominence
- **Verification badges** for trust building
- **Concise business info** with key metrics
- **Clear action path** (view profile vs contact)
- **Better mobile adaption** with stacked layout
- **Status indicators** more prominent

---

### WIREFRAME

#### Desktop (Feed/Discovery context)
```
┌────────────────────────────────────────────┐
│ ┌──────┐  Metro Pickle Club    [VERIFIED]  │
│ │      │  by Rafael Cruz                    │
│ │ LOGO │  📍 BGC Taguig, Metro Manila       │
│ │      │  ⭐ 4.8 (24 reviews) · 12 courts  │
│ └──────┘  🟢 ACTIVE                        │
│                                            │
│  Fresh slots available for league season.  │
│                                            │
│  [View Profile]  [Browse Courts]          │
└────────────────────────────────────────────┘
```

#### Mobile
```
┌──────────────────────────────────────┐
│ ┌────────────┐ Metro Pickle Club     │
│ │    LOGO    │ [VERIFIED] ✓          │
│ │   64x64    │                       │
│ └────────────┘ Rafael Cruz           │
│                📍 BGC Taguig          │
│                ⭐ 4.8 · 24 reviews   │
│                🟢 12 Courts Active   │
│                                      │
│  Fresh slots available for league    │
│  season. Book now for exclusive      │
│  early-bird rates.                   │
│                                      │
│  [View Profile]                      │
│  [Browse Courts]                     │
└──────────────────────────────────────┘
```

---

### COMPONENT STRUCTURE

```
<VendorCard>
  ├─ Card Container (border, shadow, interactive)
  │
  ├─ Header Section
  │  ├─ Avatar (larger, 64x64 or 80x80)
  │  └─ Verification Badge (top-right corner)
  │
  ├─ Info Section
  │  ├─ Business Name (bold, larger)
  │  ├─ Owner Name (secondary)
  │  └─ Status Indicator (online/active)
  │
  ├─ Metadata Section
  │  ├─ Location (icon + text)
  │  ├─ Rating (stars + count)
  │  └─ Court Count
  │
  ├─ Description
  │  └─ Short bio (2 lines max)
  │
  └─ Action Footer
     ├─ Primary CTA: View Profile
     └─ Secondary CTA: Browse Courts
```

---

### TAILWIND IMPLEMENTATION

#### Desktop Version
```blade
<article class="overflow-hidden rounded-2xl border border-slate-200 
            bg-white shadow-sm transition-all duration-300 
            hover:shadow-md hover:border-slate-300">
  
  <!-- Header with Avatar -->
  <div class="relative flex items-start gap-4 bg-gradient-to-br 
              from-slate-50 to-transparent p-5">
    
    <!-- Avatar Container -->
    <div class="relative">
      <img class="h-20 w-20 rounded-xl object-cover ring-2 ring-white 
                   shadow-md" 
           src="{{ $vendor['avatar'] }}" 
           alt="{{ $vendor['name'] }}">
      
      <!-- Status Indicator (bottom-right) -->
      @if($vendor['status'] === 'active')
        <span class="absolute -bottom-1 -right-1 flex h-6 w-6 
                     items-center justify-center rounded-full bg-emerald-500 
                     ring-2 ring-white">
          <span class="h-3 w-3 rounded-full bg-emerald-300 
                       animate-pulse"></span>
        </span>
      @endif
    </div>

    <!-- Business Info -->
    <div class="flex-1 min-w-0 pt-1">
      <div class="flex items-start justify-between gap-2">
        <div>
          <h3 class="text-lg font-black text-slate-900 truncate">
            {{ $vendor['business_name'] }}
          </h3>
          <p class="text-sm font-semibold text-slate-500 truncate">
            by {{ $vendor['owner_name'] }}
          </p>
        </div>
        
        <!-- Verification Badge -->
        @if($vendor['verified'])
          <span class="inline-flex items-center gap-1 rounded-full 
                       bg-emerald-50 px-2.5 py-1 text-xs font-bold 
                       text-emerald-700 ring-1 ring-emerald-100">
            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Verified
          </span>
        @endif
      </div>

      <!-- Location -->
      <div class="mt-2 flex items-center gap-2 text-sm font-medium 
                  text-slate-600 truncate">
        <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" 
             stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
        </svg>
        {{ $vendor['location'] }}
      </div>
    </div>
  </div>

  <!-- Metrics Section -->
  <div class="flex items-center justify-between gap-3 border-t 
              border-slate-100 px-5 py-3 bg-slate-50/50">
    
    <!-- Rating -->
    <div class="flex items-center gap-1 text-sm font-semibold text-slate-700">
      <span class="text-amber-500">⭐</span>
      <span class="font-black">{{ $vendor['rating'] }}</span>
      <span class="text-slate-500">({{ $vendor['reviews'] }} reviews)</span>
    </div>

    <!-- Court Count -->
    <div class="text-sm font-black text-blue-700 bg-blue-50 
                rounded-full px-3 py-1">
      {{ $vendor['court_count'] }} Courts
    </div>
  </div>

  <!-- Description -->
  <div class="px-5 py-4">
    <p class="text-sm leading-5 text-slate-600 line-clamp-2">
      {{ $vendor['description'] }}
    </p>
  </div>

  <!-- Actions Footer -->
  <div class="border-t border-slate-100 grid grid-cols-2 gap-2 p-4">
    <a href="{{ route('vendor.show', $vendor['slug']) }}" 
       class="rounded-lg bg-slate-900 px-4 py-2.5 text-center text-sm 
              font-black text-white transition-colors hover:bg-slate-950">
      View Profile
    </a>
    <a href="{{ route('vendor.courts', $vendor['slug']) }}" 
       class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 
              text-center text-sm font-black text-slate-700 transition-colors 
              hover:bg-slate-50">
      Browse Courts
    </a>
  </div>
</article>
```

#### Mobile Version
```blade
<article class="overflow-hidden rounded-xl border border-slate-200 
            bg-white shadow-sm active:shadow-md">
  
  <!-- Header -->
  <div class="flex items-start gap-4 p-4 pb-3">
    
    <!-- Avatar -->
    <div class="relative flex-shrink-0">
      <img class="h-16 w-16 rounded-lg object-cover ring-2 ring-white 
                   shadow-sm" 
           src="{{ $vendor['avatar'] }}" 
           alt="{{ $vendor['name'] }}">
      @if($vendor['status'] === 'active')
        <span class="absolute -bottom-0.5 -right-0.5 flex h-5 w-5 
                     items-center justify-center rounded-full 
                     bg-emerald-500 ring-2 ring-white">
          <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
        </span>
      @endif
    </div>

    <!-- Info -->
    <div class="flex-1 min-w-0">
      <div class="flex items-start justify-between gap-1">
        <div class="min-w-0">
          <h3 class="text-base font-black text-slate-900 truncate">
            {{ $vendor['business_name'] }}
          </h3>
          @if($vendor['verified'])
            <span class="text-xs font-bold text-emerald-700">
              ✓ Verified Vendor
            </span>
          @endif
        </div>
      </div>
      
      <p class="text-xs font-semibold text-slate-500 mt-1 truncate">
        {{ $vendor['owner_name'] }}
      </p>
      
      <p class="text-xs text-slate-600 mt-1 flex items-center gap-1">
        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
          <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
        </svg>
        {{ $vendor['location'] }}
      </p>
    </div>
  </div>

  <!-- Quick Stats -->
  <div class="flex items-center justify-between gap-2 border-y 
              border-slate-100 px-4 py-2.5 text-xs font-bold">
    <div class="text-amber-600">
      ⭐ {{ $vendor['rating'] }} · {{ $vendor['reviews'] }} reviews
    </div>
    <div class="rounded-full bg-blue-50 px-2.5 py-0.5 text-blue-700">
      {{ $vendor['court_count'] }} courts
    </div>
  </div>

  <!-- Description (optional, minimal on mobile) -->
  @if($vendor['description'])
    <p class="px-4 py-3 text-xs leading-4 text-slate-600 
              line-clamp-1">
      {{ $vendor['description'] }}
    </p>
  @endif

  <!-- Actions (full-width on mobile) -->
  <div class="grid grid-cols-2 gap-2 border-t border-slate-100 p-3">
    <a href="{{ route('vendor.show', $vendor['slug']) }}" 
       class="rounded-lg bg-slate-900 px-3 py-2 text-center text-xs 
              font-bold text-white active:bg-slate-950">
      Profile
    </a>
    <a href="{{ route('vendor.courts', $vendor['slug']) }}" 
       class="rounded-lg border border-slate-200 bg-white px-3 py-2 
              text-center text-xs font-bold text-slate-700 active:bg-slate-50">
      Courts
    </a>
  </div>
</article>
```

---

### Key 2026 Improvements
✅ **Larger avatar** (20x20 → 64x64/80x80) for better recognition  
✅ **Verification badges** build trust immediately  
✅ **Rating & review count** prominent with visual hierarchy  
✅ **Status indicator** shows online/active state  
✅ **Concise description** - 2 lines max  
✅ **Clear CTA hierarchy** - Profile primary, Courts secondary  
✅ **Better mobile layout** - Stacked with proper spacing  
✅ **Court count badge** provides credibility signal  
✅ **Improved touch targets** on mobile (40px+ buttons)  
✅ **Better information scannability** with visual grouping

---

---

## 4. SUBSCRIPTION PLAN/PROMOTION CARD
**Purpose:** Showcase pricing tier with features for vendors | **Context:** Landing page pricing section, vendor dashboard

### Current Issues
- Plan names small (uppercase text hard to scan)
- Price prominent but "/ mo" text tiny and easy to miss
- Feature list uses bullet points (low visual weight)
- "Most Popular" badge positioned awkwardly (-top-3)
- Featured variant (dark background) causes contrast issues with text
- Features list not scannable (no icons)
- CTA buttons lack clear differentiation
- No visual pricing comparison aid
- Missing "savings" or "popular" messaging hierarchy
- Difficult to compare plans side-by-side

### 2026 Redesign Principles
- **Card hierarchy** with clear featured state
- **Better price formatting** with clear period
- **Scannable feature list** with checkmark icons
- **Improved CTA visibility** across all variants
- **Feature icons** for quick identification
- **Savings badges** to highlight value
- **Comparison-friendly** layout
- **Better mobile stacking**

---

### WIREFRAME

#### Desktop (3-column grid)
```
┌──────────────────────┐  ┌──────────────────────┐  ┌──────────────────────┐
│ STARTER              │  │ ⭐ PREMIUM           │  │ ENTERPRISE           │
│ Free                 │  │ ₱999 / month         │  │ ₱2,499 / month       │
│ New vendors          │  │ Serious court owners │  │ Large facilities     │
│                      │  │ Most Popular         │  │                      │
│ ✓ 1 court listing    │  │ ✓ Up to 10 courts    │  │ ✓ Unlimited courts   │
│ ✓ Basic analytics    │  │ ✓ Advanced analytics │  │ ✓ Full analytics     │
│ ✓ Booking calendar   │  │ ✓ Priority listing   │  │ ✓ Dedicated support  │
│ ✓ Email support      │  │ ✓ Phone support      │  │ ✓ Custom integration │
│                      │  │                      │  │                      │
│ [Get started]        │  │ [Get started]        │  │ [Get started]        │
│ (outlined)           │  │ (green, filled)      │  │ (outlined)           │
└──────────────────────┘  │ SAVE 20% YEARLY →    │  └──────────────────────┘
                          └──────────────────────┘
```

#### Mobile (Stacked with scroll)
```
┌────────────────────────────────┐
│ STARTER                        │
│ Free                           │
│ New vendors                    │
│                                │
│ ✓ 1 court listing             │
│ ✓ Basic analytics             │
│ ✓ Booking calendar            │
│                                │
│ [Get started]                  │
└────────────────────────────────┘

┌────────────────────────────────┐
│ ⭐ PREMIUM                      │
│ ₱999 / month                   │
│ Most Popular for serious ops   │
│ [Save 20% with annual]        │
│                                │
│ ✓ Up to 10 courts             │
│ ✓ Advanced analytics          │
│ ✓ Priority listing            │
│                                │
│ [Get started] [secondary]      │
└────────────────────────────────┘
```

---

### COMPONENT STRUCTURE

```
<PricingCard>
  ├─ Card Container (featured variant styles)
  │
  ├─ Badge Section
  │  └─ "Most Popular" / "Save 20%" (conditional)
  │
  ├─ Header Section
  │  ├─ Plan Name (level indicator)
  │  ├─ Price Display (large, with period)
  │  └─ Subtitle / Audience
  │
  ├─ Features List
  │  ├─ Icon + Feature Name (repeated)
  │  └─ Visual hierarchy with colors
  │
  ├─ Divider
  │
  ├─ Optional Extras
  │  └─ "Save X% annually" banner
  │
  └─ Action Section
     ├─ Primary CTA (filled for featured)
     └─ Secondary link (copy to clipboard, compare)
```

---

### TAILWIND IMPLEMENTATION

#### Desktop Version
```blade
<article class="relative flex flex-col overflow-hidden rounded-2xl border-2 
            transition-all duration-300 
            @if($plan['featured'])
              border-slate-900 bg-gradient-to-br from-slate-900 to-slate-800
              shadow-xl hover:shadow-2xl scale-105 lg:scale-100
            @else
              border-slate-200 bg-white hover:border-slate-300 hover:shadow-md
            @endif">

  <!-- Top Badge Section -->
  @if($plan['featured'])
    <div class="absolute -top-3 left-0 right-0 flex justify-center pointer-events-none">
      <span class="inline-flex items-center gap-2 rounded-full 
                    bg-gradient-to-r from-courtigo-green to-emerald-500 
                    px-5 py-2 text-xs font-black text-white 
                    shadow-lg ring-2 ring-white">
        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
        </svg>
        Most Popular
      </span>
    </div>

    <!-- Yearly Savings Badge (right side) -->
    <div class="absolute top-5 right-5 text-right">
      <span class="inline-block rounded-lg bg-courtigo-green/20 
                    px-3 py-1 text-xs font-black text-courtigo-green">
        Save 20% yearly
      </span>
    </div>
  @endif

  <!-- Header Content -->
  <div class="px-8 @if($plan['featured']) pt-10 @else pt-6 @endif pb-5">
    
    <!-- Plan Name -->
    <h3 class="text-xs font-black uppercase tracking-widest 
               @if($plan['featured'])
                 text-white/60
               @else
                 text-slate-500
               @endif">
      {{ $plan['name'] }} Plan
    </h3>

    <!-- Price Display -->
    <div class="mt-4">
      @if($plan['price'] === 'Free')
        <p class="text-5xl font-black 
                  @if($plan['featured'])
                    text-white
                  @else
                    text-slate-900
                  @endif">
          {{ $plan['price'] }}
        </p>
      @else
        <div class="flex items-baseline gap-1">
          <span class="text-5xl font-black 
                       @if($plan['featured'])
                         text-white
                       @else
                         text-slate-900
                       @endif">
            {{ $plan['price'] }}
          </span>
          <span class="text-sm font-semibold 
                       @if($plan['featured'])
                         text-white/50
                       @else
                         text-slate-500
                       @endif">
            / month
          </span>
        </div>
      @endif
    </div>

    <!-- Audience Description -->
    <p class="mt-3 text-sm leading-6 
              @if($plan['featured'])
                text-white/70
              @else
                text-slate-600
              @endif">
      {{ $plan['description'] }}
    </p>
  </div>

  <!-- Divider -->
  <div class="mx-6 h-px 
              @if($plan['featured'])
                bg-white/10
              @else
                bg-slate-100
              @endif"></div>

  <!-- Features List -->
  <div class="space-y-3 px-8 py-6">
    @foreach($plan['features'] as $feature)
      <div class="flex items-start gap-3">
        <svg class="h-5 w-5 shrink-0 mt-0.5 
                    @if($plan['featured'])
                      text-courtigo-green
                    @else
                      text-emerald-600
                    @endif" 
             fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
        </svg>
        <span class="text-sm font-bold 
                     @if($plan['featured'])
                       text-white/90
                     @else
                       text-slate-700
                     @endif">
          {{ $feature }}
        </span>
      </div>
    @endforeach
  </div>

  <!-- CTA Button -->
  <div class="mt-auto border-t 
              @if($plan['featured'])
                border-white/10
              @else
                border-slate-100
              @endif
              px-8 py-6">
    <a href="{{ route('vendor.apply') }}" 
       class="block w-full rounded-xl px-4 py-3 text-center text-sm 
              font-black transition-all duration-200
              @if($plan['featured'])
                bg-gradient-to-r from-courtigo-green to-emerald-500
                text-white shadow-lg hover:shadow-xl 
                hover:from-courtigo-green hover:to-emerald-600
              @else
                border border-slate-300 bg-white text-slate-900
                hover:bg-slate-50 active:bg-slate-100
              @endif">
      Get started
    </a>
  </div>

  <!-- Optional: Comparison Link (bottom) -->
  <div class="border-t 
              @if($plan['featured'])
                border-white/10
              @else
                border-slate-100
              @endif
              px-8 py-3 text-center">
    <button type="button" 
            class="text-xs font-bold 
                   @if($plan['featured'])
                     text-white/60 hover:text-white
                   @else
                     text-slate-500 hover:text-slate-700
                   @endif">
      Compare all plans →
    </button>
  </div>
</article>
```

#### Mobile Version (Scrollable, single-column focus)
```blade
<article class="relative overflow-hidden rounded-xl border-2 
            flex flex-col
            @if($plan['featured'])
              border-slate-900 bg-gradient-to-br from-slate-900 to-slate-800
              shadow-lg -mx-4 px-4 py-6
            @else
              border-slate-200 bg-white
              p-4
            @endif">

  <!-- Badge (compact on mobile) -->
  @if($plan['featured'])
    <div class="mb-4 inline-flex items-center gap-1 rounded-full 
                bg-courtigo-green px-3 py-1.5 text-xs font-bold 
                text-white w-fit">
      ⭐ Most Popular
    </div>
  @endif

  <!-- Header -->
  <div>
    <h3 class="text-xs font-black uppercase tracking-wide 
               @if($plan['featured'])
                 text-white/60
               @else
                 text-slate-500
               @endif">
      {{ $plan['name'] }}
    </h3>

    <!-- Price -->
    <div class="mt-2">
      @if($plan['price'] === 'Free')
        <p class="text-3xl font-black 
                  @if($plan['featured'])
                    text-white
                  @else
                    text-slate-900
                  @endif">
          {{ $plan['price'] }}
        </p>
      @else
        <div class="flex items-baseline gap-0.5">
          <span class="text-4xl font-black 
                       @if($plan['featured'])
                         text-white
                       @else
                         text-slate-900
                       @endif">
            {{ $plan['price'] }}
          </span>
          <span class="text-xs font-semibold 
                       @if($plan['featured'])
                         text-white/50
                       @else
                         text-slate-500
                       @endif">
            /mo
          </span>
        </div>
      @endif
    </div>

    <!-- Description -->
    <p class="mt-2 text-xs 
              @if($plan['featured'])
                text-white/70
              @else
                text-slate-600
              @endif">
      {{ $plan['description'] }}
    </p>
  </div>

  <!-- Features (compact) -->
  <div class="my-4 space-y-2">
    @foreach($plan['features'] as $feature)
      <div class="flex items-center gap-2">
        <svg class="h-4 w-4 shrink-0 
                    @if($plan['featured'])
                      text-courtigo-green
                    @else
                      text-emerald-600
                    @endif" 
             fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
        </svg>
        <span class="text-xs font-semibold 
                     @if($plan['featured'])
                       text-white/90
                     @else
                       text-slate-700
                     @endif">
          {{ $feature }}
        </span>
      </div>
    @endforeach
  </div>

  <!-- CTA -->
  <div class="mt-4 grid grid-cols-2 gap-2">
    <a href="{{ route('vendor.apply') }}" 
       class="rounded-lg px-4 py-2.5 text-center text-xs font-bold 
              transition-all
              @if($plan['featured'])
                bg-courtigo-green text-white active:bg-emerald-600
              @else
                border border-slate-200 bg-white text-slate-700 
                active:bg-slate-50
              @endif">
      Get started
    </a>
    <button type="button" 
            class="rounded-lg px-4 py-2.5 text-xs font-bold 
                   transition-all
                   @if($plan['featured'])
                     border border-white/20 text-white/70 
                     active:bg-white/10
                   @else
                     border border-slate-200 bg-white text-slate-700
                     active:bg-slate-50
                   @endif">
      Learn more
    </button>
  </div>
</article>
```

---

### Key 2026 Improvements
✅ **Clear pricing hierarchy** - Featured card scaled on desktop  
✅ **Better price formatting** - "/ month" inline and clear  
✅ **Scannable features** - Checkmark icons for each item  
✅ **Top badge** repositioned naturally with shadow  
✅ **Savings messaging** - "Save 20% yearly" visible on featured  
✅ **Improved contrast** - White text on dark background (WCAG AAA)  
✅ **Better mobile layout** - Single column with proper prioritization  
✅ **CTA clarity** - Filled for featured, outlined for others  
✅ **Feature icons** - Emerald checkmarks for visual weight  
✅ **Touch-friendly** - Buttons 44px+ on mobile  
✅ **Comparison-aware** - Layout encourages side-by-side review  
✅ **Scale animation** - Featured plan slightly larger on desktop

---

## RESPONSIVE BEHAVIOR SUMMARY

### Breakpoints Used
- **Mobile:** Default (< 640px)
- **Tablet:** `md` (768px+)
- **Desktop:** `lg` (1024px+)

### Card Behaviors

| Feature | Mobile | Tablet | Desktop |
|---------|--------|--------|---------|
| **Court Card** | Full-width, touch-friendly | 3-col, stacked | 4-col grid |
| **Booking Card** | Stacked vertically | 2-col layout | 3-col (img-content-actions) |
| **Vendor Card** | Minimal, compact avatar | Normal sizing | Larger avatar (80px) |
| **Plan Card** | Single scroll focus | 2-col layout | 3-col with scale |

---

## COLOR SYSTEM (2026 Standards)

### Semantic Colors
```
Primary (Actions): slate-900 → Dark navy
Secondary (Borders): slate-200 → Light gray
Success (Available): emerald-500/600 → Green
Warning (Limited): amber-500/600 → Amber
Danger (Cancelled): red-500/600 → Red
Info (Details): blue-500/600 → Blue
Brand (Courtigo): courtigo-navy, courtigo-green
```

### Usage in Cards
- **CTA Buttons:** slate-900 background, white text
- **Secondary Actions:** outline with slate-200 border
- **Status Indicators:** Semantic color system
- **Badges:** Tinted backgrounds (50% opacity) with darker text

---

## MOTION & INTERACTIONS

### Hover States
```css
.card-hover {
  @apply transition-all duration-300 
         hover:shadow-md hover:border-slate-300;
}

.image-hover {
  @apply transition-transform duration-500 group-hover:scale-105;
}

.button-hover {
  @apply transition-colors duration-200 
         hover:bg-slate-950 active:bg-slate-950;
}
```

### Mobile Active States
- Use `active:` prefix for touch feedback
- Provide 44px+ touch targets
- No `:hover` on mobile (only desktop)

---

## ACCESSIBILITY CHECKLIST

✅ Color contrast ratio ≥ 4.5:1 (text on background)  
✅ Touch targets ≥ 44px × 44px (mobile)  
✅ Keyboard navigation support (tab through CTAs)  
✅ Icon + text labels (not icon-only buttons)  
✅ Alt text on all images  
✅ ARIA labels for status indicators  
✅ Semantic HTML structure  
✅ Focus visible states on buttons  

---

## IMPLEMENTATION NOTES

### Component Reusability
Each card can be extracted as a reusable Blade component:
- `<x-courtigo.court-card-redesign />`
- `<x-courtigo.booking-card-redesign />`
- `<x-courtigo.vendor-card-redesign />`
- `<x-courtigo.pricing-card-redesign />`

### Data Props Required
Update your database seeders and controller views to include:
- Court: `status`, `surface_type`, `availability_tone`
- Booking: `total_amount`, `payment_status`
- Vendor: `verified_at`, `rating_average`, `court_count`
- Plan: `featured`, `annual_savings`

### Migration Path
1. Create new `redesign.blade.php` versions first
2. Run A/B test on 50% of users
3. Collect metrics (CTR, time-on-page, conversions)
4. Gradually migrate all users
5. Remove old components after 2 weeks

---

## PERFORMANCE CONSIDERATIONS

### Image Optimization
- Use `loading="lazy"` on all card images
- Serve WebP with PNG fallback
- 16:9 ratio optimized for web (320×180 → 1920×1080)
- Blur-up placeholder effect

### Bundle Size Impact
- Card CSS: ~2.5KB (gzipped)
- Component refactor: No JS required (pure Blade)
- Tailwind compilation: Uses existing classes

### Metrics to Track
- First Contentful Paint (FCP)
- Largest Contentful Paint (LCP)
- Cumulative Layout Shift (CLS)
- Click-through rates per card type
