<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobListingController;

Route::prefix('jobs')->group(function () {
    Route::get('/', [JobListingController::class, 'index']); // Get job listings with filtering
    Route::post('/', [JobListingController::class, 'store']); // Create a new job listing
    Route::get('/{job}', [JobListingController::class, 'show']); // Get a specific job listing
    Route::put('/{job}', [JobListingController::class, 'update']); // Update a job listing
    Route::delete('/{job}', [JobListingController::class, 'destroy']); // Delete a job listing
});
