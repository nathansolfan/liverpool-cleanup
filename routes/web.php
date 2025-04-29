<?php

use App\Http\Controllers\CleanupAreaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// default / to welcome laravel page
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard from Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes from Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Anyone can see these routes
Route::get('/cleanup-areas', [CleanupAreaController::class, 'index'])->name('cleanup-areas.index');
Route::get('/cleanup-areas/{cleanupArea}',[CleanupAreaController::class, 'show'])->name('cleanup-areas.show');

// Pages only logged-in users can access
Route::middleware('auth')->group(function () {
    Route::get('cleanup-areas/create', [CleanupAreaController::class, 'create'])->name('cleanup-areas.create');
    Route::get('cleanup-areas', [CleanupAreaController::class, 'store'])->name('cleanup-areas.store');
    Route::get('cleanup-areas/{CleanupArea}/edit', [CleanupAreaController::class, 'edit'])->name('cleanup-areas.edit');
    Route::get('cleanup-areas/{CleanupArea}', [CleanupAreaController::class, 'update'])->name('cleanup-areas.update');
    Route::get('cleanup-areas/{CleanupArea}', [CleanupAreaController::class, 'destroy'])->name('cleanup-areas.destroy');

});

// API ROUTES
Route::prefix('api')->group(function () {
    Route::get('/cleanup-areas', [CleanupAreaController::class, 'apiIndex'])->name('api.cleanup-areas');
});

require __DIR__.'/auth.php';
