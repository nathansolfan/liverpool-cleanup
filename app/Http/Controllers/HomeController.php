<?php

namespace App\Http\Controllers;

use App\Models\CleanupArea;
use App\Models\User;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        // Get statistics for the homepage
    $statistics = [
        'area_count' => CleanupArea::class,
        'completed_count' => CleanupArea::where('status', 'completed')->count(),
        'users_count' => User::count(),
    ];

    // Get upcoming cleanup events (we'll add this model later)
    // For now, pass an empty collection
    $upcomingEvents = collect();

    return view('home', compact('statistics', 'upcomingEvents'));
    }
}
