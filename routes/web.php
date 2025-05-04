<?php

use App\Http\Controllers\CleanupAreaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Individual cleanup areas are viewable by public
Route::get('/cleanup-areas/{cleanupArea}', [CleanupAreaController::class, 'show'])->name('cleanup-areas.show');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cleanup Areas management (requires auth)
    Route::get('/cleanup-areas', [CleanupAreaController::class, 'index'])->name('cleanup-areas.index');
    Route::get('/cleanup-areas/create', [CleanupAreaController::class, 'create'])->name('cleanup-areas.create');
    Route::post('/cleanup-areas', [CleanupAreaController::class, 'store'])->name('cleanup-areas.store');
    Route::get('/cleanup-areas/{cleanupArea}/edit', [CleanupAreaController::class, 'edit'])->name('cleanup-areas.edit');
    Route::put('/cleanup-areas/{cleanupArea}', [CleanupAreaController::class, 'update'])->name('cleanup-areas.update');
    Route::delete('/cleanup-areas/{cleanupArea}', [CleanupAreaController::class, 'destroy'])->name('cleanup-areas.destroy');
});

// API routes
Route::prefix('api')->group(function () {
    Route::get('/cleanup-areas', [CleanupAreaController::class, 'apiIndex'])->name('api.cleanup-areas');
});

require __DIR__.'/auth.php';
