@extends('layouts.courtigo', ['title' => 'Vendor Application | Courtigo'])

@section('content')
    <section class="bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Private vendor onboarding</p>
                <h1 class="mt-3 text-4xl font-black text-courtigo-navy">Register your pickleball venue</h1>
                <p class="mt-4 text-lg leading-8 text-slate-600">Courtigo keeps vendor registration separate from public player signups. Applications enter an admin approval queue before subscriptions unlock court management.</p>
                <div class="mt-8 space-y-4">
                    @foreach(['Upload business requirements', 'Wait for admin approval', 'Choose a subscription plan', 'Publish courts and accept bookings'] as $step)
                        <div class="flex gap-3 rounded border border-slate-200 p-4">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded bg-green-50 font-black text-courtigo-green">✓</span>
                            <p class="font-semibold text-slate-700">{{ $step }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <form class="rounded border border-slate-200 bg-slate-50 p-6">
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-bold text-slate-700">Business name<input class="mt-2 w-full rounded border border-slate-200 px-3 py-3 font-normal" placeholder="Metro Pickle Club"></label>
                    <label class="text-sm font-bold text-slate-700">Owner email<input class="mt-2 w-full rounded border border-slate-200 px-3 py-3 font-normal" placeholder="owner@example.com"></label>
                    <label class="text-sm font-bold text-slate-700">Phone<input class="mt-2 w-full rounded border border-slate-200 px-3 py-3 font-normal" placeholder="+63"></label>
                    <label class="text-sm font-bold text-slate-700">City<input class="mt-2 w-full rounded border border-slate-200 px-3 py-3 font-normal" placeholder="Taguig"></label>
                    <label class="text-sm font-bold text-slate-700 sm:col-span-2">Business address<input class="mt-2 w-full rounded border border-slate-200 px-3 py-3 font-normal" placeholder="Venue address"></label>
                    <label class="text-sm font-bold text-slate-700 sm:col-span-2">Requirements upload<input type="file" class="mt-2 w-full rounded border border-slate-200 bg-white px-3 py-3 font-normal"></label>
                </div>
                <div class="mt-6">
                    <p class="mb-3 text-sm font-bold text-slate-700">Preferred plan</p>
                    <div class="grid gap-3 md:grid-cols-3">
                        @foreach($plans as $plan)
                            <label class="cursor-pointer rounded border border-slate-200 bg-white p-4">
                                <input type="radio" name="plan" class="mr-2" @checked($loop->first)>
                                <span class="font-black text-courtigo-navy">{{ $plan->name }}</span>
                                <span class="mt-2 block text-sm text-slate-500">₱{{ number_format($plan->price) }}/mo</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <button class="mt-6 w-full rounded bg-courtigo-navy px-5 py-3 font-bold text-white">Submit application</button>
            </form>
        </div>
    </section>
@endsection
