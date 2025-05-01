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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
