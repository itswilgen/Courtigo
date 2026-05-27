<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'role' => ['nullable', 'in:admin,owner,customer,player,vendor'],
        ]);

        $users = User::query()
            ->when($filters['role'] ?? null, fn ($query, $role) => $query->where('role', $role))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['courts', 'bookings.court', 'reports']);

        return view('admin.users.show', compact('user'));
    }

    public function ban(User $user)
    {
        abort_if(auth()->id() === $user->id, 422, 'You cannot ban your own administrator account.');

        $user->update(['is_banned' => true, 'status' => 'banned']);

        return back()->with('status', "{$user->name} has been banned.");
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false, 'status' => 'active']);

        return back()->with('status', "{$user->name} has been unbanned.");
    }

    public function destroy(User $user)
    {
        abort_if(auth()->id() === $user->id, 422, 'You cannot delete your own administrator account.');

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }
}
