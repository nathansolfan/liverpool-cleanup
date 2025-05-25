<?php

namespace App\Http\Controllers;

use App\Models\CleanupArea;
use Illuminate\Http\Request;

class CleanupAreaController extends Controller
{
    public function apiIndex(Request $request)
    {
        $query = CleanupArea::query();

        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('severity') && $request->severity != '') {
            $query->where('severity', $request->severity);
        }

        $areas = $query->get();

        // Return the actual areas instead of empty array
        return response()->json($areas);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cleanupAreas = CleanupArea::all();
        return view('cleanup-areas.index', compact('cleanupAreas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cleanup-areas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'severity' => 'required|in:low,medium,high',
            'status' => 'required|in:reported,scheduled,completed'
        ]);

        // Status is already set via hidden field, but we ensure it here as a fallback
        if (!isset($validated['status']) || empty($validated['status'])) {
            $validated['status'] = 'reported';
        }


        // $validated['status'] = 'reported';
        $validated['user_id'] = $request->user()->id;

        $cleanupArea = CleanupArea::create($validated);

        return redirect()->route('cleanup-areas.index', $cleanupArea)->with('success', 'Cleanup Area reported with success');
    }

    /**
     * Display the specified resource.
     */
    public function show(CleanupArea $cleanupArea)
    {
        // Changed parameter name and variable name for consistency
        return view('cleanup-areas.show', compact('cleanupArea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CleanupArea $cleanupArea)
    {
        $this->authorize('update', $cleanupArea);
        return view('cleanup-areas.edit', compact('cleanupArea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CleanupArea $cleanupArea)
    {
        $this->authorize('update', $cleanupArea);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'severity' => 'required|in:low,medium,high',
        ]);

        $cleanupArea->update($validated);

        return redirect()->route('cleanup-areas.index')->with('success', 'Cleanup Area has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CleanupArea $cleanupArea)
    {
        $this->authorize('delete', $cleanupArea);
        $cleanupArea->delete();

        return redirect()->route('cleanup-areas.index')->with('success', 'Cleanup Area deleted');
    }
}
