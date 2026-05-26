@extends('layouts.courtigo', ['title' => 'Create Account | Courtigo'])

@section('content')
    <section class="bg-white">
        <div class="mx-auto grid min-h-[calc(100vh-153px)] max-w-7xl gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:px-8 lg:py-14">
            <div class="flex flex-col justify-center" data-reveal>
                <div class="mb-5 w-fit rounded-full border border-green-100 bg-green-50 px-4 py-2 text-sm font-bold text-green-700">Create your player account</div>
                <h1 class="max-w-xl text-4xl font-black tracking-tight text-courtigo-navy sm:text-5xl">Book courts faster with your own Courtigo profile.</h1>
                <p class="mt-5 max-w-xl text-lg leading-8 text-slate-600">Save your details, manage reservations, and keep your next pickleball session easy to find.</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded border border-slate-200 bg-slate-50 p-4">
                        <p class="text-2xl font-black text-courtigo-navy">Fast</p>
                        <p class="mt-1 text-sm font-semibold text-slate-600">Reserve available slots</p>
                    </div>
                    <div class="rounded border border-slate-200 bg-slate-50 p-4">
                        <p class="text-2xl font-black text-courtigo-navy">Clear</p>
                        <p class="mt-1 text-sm font-semibold text-slate-600">Track booking details</p>
                    </div>
                    <div class="rounded border border-slate-200 bg-slate-50 p-4">
                        <p class="text-2xl font-black text-courtigo-navy">Ready</p>
                        <p class="mt-1 text-sm font-semibold text-slate-600">Find courts anytime</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center" data-reveal>
                <div class="w-full max-w-md rounded border border-slate-200 bg-white p-6 shadow-xl shadow-slate-950/10 sm:p-8">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Player signup</p>
                        <h2 class="mt-2 text-3xl font-black text-courtigo-navy">Create account</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">This creates a player account for court reservations.</p>
                    </div>

                    @if($errors->any())
                        <div class="mt-5 rounded border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-5">
                        @csrf
                        <div>
                            <label for="name" class="text-sm font-bold text-slate-700">Full name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-50" placeholder="Mika Santos">
                        </div>

                        <div>
                            <label for="email" class="text-sm font-bold text-slate-700">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-50" placeholder="you@example.com">
                        </div>

                        <div>
                            <label for="phone" class="text-sm font-bold text-slate-700">Phone number <span class="font-semibold text-slate-400">optional</span></label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-50" placeholder="+63 917 000 0000">
                        </div>

                        <div>
                            <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" required class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-50" placeholder="At least 8 characters">
                        </div>

                        <div>
                            <label for="password_confirmation" class="text-sm font-bold text-slate-700">Confirm password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-50" placeholder="Repeat your password">
                        </div>

                        <button type="submit" class="w-full rounded bg-courtigo-green px-5 py-3 text-sm font-black text-white shadow-sm transition hover:bg-green-600">Create account</button>
                    </form>

                    <p class="mt-5 text-center text-sm font-semibold text-slate-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-black text-courtigo-blue hover:text-blue-700">Log in</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
