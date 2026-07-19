@props(['plan', 'featured' => false])

@php
    $isFeatured = $plan['featured'] ?? $featured;
@endphp

<article class="relative flex flex-col overflow-hidden rounded-2xl border-2 transition-all duration-300 
            @if($isFeatured)
              border-slate-900 bg-gradient-to-br from-slate-900 to-slate-800
              shadow-xl hover:shadow-2xl scale-105 lg:scale-100
            @else
              border-slate-200 bg-white hover:border-slate-300 hover:shadow-md
            @endif">

    <!-- Top Badge Section -->
    @if($isFeatured)
        <div class="absolute -top-3 left-0 right-0 flex justify-center pointer-events-none">
            <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-courtigo-green to-emerald-500 px-5 py-2 text-xs font-black text-white shadow-lg ring-2 ring-white">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Most Popular
            </span>
        </div>

        <!-- Yearly Savings Badge (right side) -->
        <div class="absolute top-5 right-5 text-right">
            <span class="inline-block rounded-lg bg-courtigo-green/20 px-3 py-1 text-xs font-black text-courtigo-green">
                Save 20% yearly
            </span>
        </div>
    @endif

    <!-- Header Content -->
    <div class="px-8 @if($isFeatured) pt-10 @else pt-6 @endif pb-5">
        
        <!-- Plan Name -->
        <h3 class="text-xs font-black uppercase tracking-widest 
                   @if($isFeatured)
                     text-white/60
                   @else
                     text-slate-500
                   @endif">
            {{ $plan['name'] ?? 'Plan' }}
        </h3>

        <!-- Price Display -->
        <div class="mt-4">
            @if($plan['price'] === 'Free' || $plan['price'] === 'free')
                <p class="text-5xl font-black 
                          @if($isFeatured)
                            text-white
                          @else
                            text-slate-900
                          @endif">
                    Free
                </p>
            @else
                <div class="flex items-baseline gap-1">
                    <span class="text-5xl font-black 
                                 @if($isFeatured)
                                   text-white
                                 @else
                                   text-slate-900
                                 @endif">
                        {{ $plan['price'] }}
                    </span>
                    <span class="text-sm font-semibold 
                                 @if($isFeatured)
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
                  @if($isFeatured)
                    text-white/70
                  @else
                    text-slate-600
                  @endif">
            {{ $plan['copy'] ?? $plan['description'] ?? 'Perfect plan for your needs' }}
        </p>
    </div>

    <!-- Divider -->
    <div class="mx-6 h-px 
                @if($isFeatured)
                  bg-white/10
                @else
                  bg-slate-100
                @endif"></div>

    <!-- Features List -->
    <div class="space-y-3 px-8 py-6">
        @foreach($plan['features'] ?? [] as $feature)
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 shrink-0 mt-0.5 
                            @if($isFeatured)
                              text-courtigo-green
                            @else
                              text-emerald-600
                            @endif" 
                     fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-bold 
                             @if($isFeatured)
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
                @if($isFeatured)
                  border-white/10
                @else
                  border-slate-100
                @endif
                px-8 py-6">
        <a href="{{ route('vendor.apply') }}" 
           class="block w-full rounded-xl px-4 py-3 text-center text-sm font-black transition-all duration-200
                  @if($isFeatured)
                    bg-gradient-to-r from-courtigo-green to-emerald-500 text-white shadow-lg hover:shadow-xl 
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
                @if($isFeatured)
                  border-white/10
                @else
                  border-slate-100
                @endif
                px-8 py-3 text-center">
        <button type="button" 
                class="text-xs font-bold 
                       @if($isFeatured)
                         text-white/60 hover:text-white
                       @else
                         text-slate-500 hover:text-slate-700
                       @endif">
            Compare all plans →
        </button>
    </div>
</article>
