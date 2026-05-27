<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['nullable', 'in:pending,resolved,open'],
        ]);

        $reports = Report::query()
            ->with(['user', 'reporter', 'booking.court'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load(['user', 'reporter', 'booking.user', 'booking.court', 'court']);

        return view('admin.reports.show', compact('report'));
    }

    public function updateStatus(Request $request, Report $report)
    {
        $attributes = $request->validate([
            'status' => ['required', 'in:pending,resolved'],
        ]);

        $report->update($attributes);

        return back()->with('status', 'Report status updated.');
    }
}
