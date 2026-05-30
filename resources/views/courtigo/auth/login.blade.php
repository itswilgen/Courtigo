@extends('layouts.courtigo', ['title' => 'Login | Courtigo'])

@section('content')
    <section class="hero-visual hero-bg-auth bg-white">
        <div class="mx-auto grid min-h-[calc(100vh-153px)] max-w-7xl gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:px-8 lg:py-14">
            <div class="flex flex-col justify-center">
                <div class="mb-5 w-fit rounded-full border border-green-100 bg-green-50 px-4 py-2 text-sm font-bold text-green-700">Welcome back, player</div>
                <h1 class="max-w-xl text-4xl font-black tracking-tight text-courtigo-navy sm:text-5xl">Log in and get back to your next pickleball match.</h1>
                <p class="mt-5 max-w-xl text-lg leading-8 text-slate-600">Check your bookings, review court details, and keep your next game day organized from one simple Courtigo account.</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded border border-slate-200 bg-slate-50 p-4">
                        <p class="text-2xl font-black text-courtigo-navy">1</p>
                        <p class="mt-1 text-sm font-semibold text-slate-600">Open your bookings</p>
                    </div>
                    <div class="rounded border border-slate-200 bg-slate-50 p-4">
                        <p class="text-2xl font-black text-courtigo-navy">2</p>
                        <p class="mt-1 text-sm font-semibold text-slate-600">Confirm court time</p>
                    </div>
                    <div class="rounded border border-slate-200 bg-slate-50 p-4">
                        <p class="text-2xl font-black text-courtigo-navy">3</p>
                        <p class="mt-1 text-sm font-semibold text-slate-600">Show up and play</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <div class="w-full max-w-md rounded border border-slate-200 bg-white p-6 shadow-xl shadow-slate-950/10 sm:p-8">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-courtigo-blue">Courtigo login</p>
                        <h2 class="mt-2 text-3xl font-black text-courtigo-navy">Access your account</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Use the email and password connected to your Courtigo profile.</p>
                    </div>

                    @if($errors->any())
                        <div class="mt-5 rounded border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="text-sm font-bold text-slate-700">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-50" placeholder="player@courtigo.test">
                        </div>

                        <div>
                            <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-2 w-full rounded border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-courtigo-blue focus:ring-4 focus:ring-blue-50" placeholder="Enter your password">
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <label class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                                <input name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-courtigo-blue focus:ring-courtigo-blue">
                                Remember me
                            </label>
                            <span class="text-sm font-semibold text-slate-400">Need help?</span>
                        </div>

                        <button type="submit" class="w-full rounded bg-courtigo-green px-5 py-3 text-sm font-black text-white shadow-sm">Log in</button>
                    </form>

                    <p class="mt-5 text-center text-sm font-semibold text-slate-500">
                        New to Courtigo?
                        <a href="{{ route('register') }}" class="font-black text-courtigo-blue">Create an account</a>
                    </p>

                    <div class="mt-6 rounded bg-slate-50 p-4 text-sm text-slate-600">
                        <p class="font-black text-courtigo-navy">Demo player account</p>
                        <p class="mt-1"><span class="font-semibold">Email:</span> player@courtigo.test</p>
                        <p><span class="font-semibold">Password:</span> password</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
