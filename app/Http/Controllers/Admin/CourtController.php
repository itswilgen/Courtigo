<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['nullable', 'in:pending,approved,suspended,active,inactive'],
        ]);

        $courts = Court::query()
            ->with(['owner', 'vendorProfile.user'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.courts.index', compact('courts'));
    }

    public function show(Court $court)
    {
        $court->load(['owner', 'vendorProfile.user', 'bookings.user', 'images']);

        return view('admin.courts.show', compact('court'));
    }

    public function approve(Court $court)
    {
        $court->update(['status' => 'approved']);

        return back()->with('status', "{$court->name} has been approved.");
    }

    public function suspend(Court $court)
    {
        $court->update(['status' => 'suspended']);

        return back()->with('status', "{$court->name} has been suspended.");
    }
}
