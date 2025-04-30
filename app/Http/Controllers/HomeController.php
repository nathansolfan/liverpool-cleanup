<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    // Get statistics for the homepage
    $statistics = [
        'area_count' => CleanupArea::count(),
        'completed_count' => CleanupArea::where('status', 'completed')->count(),
        'users_count' => User::count(),


    ];

}
