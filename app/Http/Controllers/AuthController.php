<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->filled('redirect') && str_starts_with($request->query('redirect'), url('/'))) {
            $request->session()->put('url.intended', $request->query('redirect'));
        }

        if (Auth::check()) {
            return redirect()->intended(route($this->dashboardRouteFor(Auth::user()->role)));
        }

        return view('courtigo.auth.login');
    }

    public function register(Request $request): View|RedirectResponse
    {
        if ($request->filled('redirect') && str_starts_with($request->query('redirect'), url('/'))) {
            $request->session()->put('url.intended', $request->query('redirect'));
        }

        if (Auth::check()) {
            return redirect()->intended(route($this->dashboardRouteFor(Auth::user()->role)));
        }

        return view('courtigo.auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'These login details do not match a Courtigo account.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route($this->dashboardRouteFor($request->user()->role)));
    }

    public function storeRegistration(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'] ?? null,
            'password' => Hash::make($attributes['password']),
            'role' => 'player',
            'status' => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.player'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function dashboardRouteFor(string $role): string
    {
        return match ($role) {
            'admin' => 'dashboard.admin',
            'vendor' => 'dashboard.vendor',
            default => 'dashboard.player',
        };
    }
}
