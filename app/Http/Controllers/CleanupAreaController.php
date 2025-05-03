<?php

namespace App\Http\Controllers;

use App\Models\CleanupArea;
use Illuminate\Http\Request;

class CleanupAreaController extends Controller
{

    public function apiIndex(Request $request)
    {
        // This will eventually return cleanup areas in JSON format for the map
        // For now, return empty array until we implement the database
        return response()->json([]);
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
        // dd('Create method reached!'); // This will show if the method is being hit
        // return view('cleanup-areas.create');
        //return the view with the form
        return view('cleanup-areas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // steps: validate - create new CleanupArea - redirect
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'severity' => 'required|in:low,medium,high',
        ]);

        // Add additional fields not from the form
        $validated['status'] = 'reported'; //default for new areas
        $validated['user_id'] = $request->user()->id;
        // $validated['user_id'] = Auth::id();

        // create: var: Model + create(   $validated  )
        $cleanupArea = CleanupArea::create($validated);

        // redirect
        return redirect()->route('cleanup-areas.show', $cleanupArea)->with('success', 'Cleanup Area reported with success');
    }

    /**
     * Display the specified resource.
     */
    public function show(CleanupArea $cleanup)
    {
        // display each specific cleanupArea
        return view('cleanup-areas.show', compact('cleanup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CleanupArea $cleanup)
    {
        return view('cleanup-areas.edit', compact('cleanup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CleanupArea $cleanup)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'severity' => 'required|in:low,medium,high',
        ]);

        $cleanup->update($validated);

        return redirect()->route('cleanup-areas.index')->with('success', 'Cleanup Area has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CleanupArea $cleanup)
    {

        $cleanup->delete();

        return redirect()->route('cleanup-areas.index')->with('success', 'Cleanup Route deleted');
    }
}
