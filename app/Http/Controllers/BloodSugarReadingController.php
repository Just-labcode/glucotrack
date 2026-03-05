<?php

namespace App\Http\Controllers;

use App\Http\Requests\BloodSugarReadingRequest;
use App\Models\BloodSugarReading;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BloodSugarReadingController extends Controller
{
    /**
     * Display a listing of readings with summary stats.
     */
    public function index(): View
    {
        $readings = BloodSugarReading::latest()->paginate(10);

        $allReadings = BloodSugarReading::all();

        $stats = [
            'total'   => $allReadings->count(),
            'average' => $allReadings->avg('level') ? round($allReadings->avg('level'), 1) : null,
            'highest' => $allReadings->max('level'),
            'lowest'  => $allReadings->min('level'),
        ];

        $statusCounts = [
            'low'      => $allReadings->filter(fn($r) => $r->status === 'low')->count(),
            'normal'   => $allReadings->filter(fn($r) => $r->status === 'normal')->count(),
            'elevated' => $allReadings->filter(fn($r) => $r->status === 'elevated')->count(),
            'high'     => $allReadings->filter(fn($r) => $r->status === 'high')->count(),
        ];

        return view('readings.index', compact('readings', 'stats', 'statusCounts'));
    }

    /**
     * Show form to create a new reading.
     */
    public function create(): View
    {
        return view('readings.create');
    }

    /**
     * Store a new reading.
     */
    public function store(BloodSugarReadingRequest $request): RedirectResponse
    {
        $reading = BloodSugarReading::create($request->validated());

        return redirect()
            ->route('readings.show', $reading)
            ->with('success', 'Reading logged successfully!');
    }

    /**
     * Show a single reading with status & suggestion.
     */
    public function show(BloodSugarReading $reading): View
    {
        return view('readings.show', compact('reading'));
    }

    /**
     * Show form to edit a reading.
     */
    public function edit(BloodSugarReading $reading): View
    {
        return view('readings.edit', compact('reading'));
    }

    /**
     * Update an existing reading.
     */
    public function update(BloodSugarReadingRequest $request, BloodSugarReading $reading): RedirectResponse
    {
        $reading->update($request->validated());

        return redirect()
            ->route('readings.show', $reading)
            ->with('success', 'Reading updated successfully!');
    }

    /**
     * Delete a reading.
     */
    public function destroy(BloodSugarReading $reading): RedirectResponse
    {
        $reading->delete();

        return redirect()
            ->route('readings.index')
            ->with('success', 'Reading deleted successfully.');
    }
}