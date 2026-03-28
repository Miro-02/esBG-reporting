<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Controllers\ReportController;

// Protected routes - require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Get all reports for authenticated user
    Route::get('/', [ReportController::class, 'index']);
    
    // Create a new report
    Route::post('/', [ReportController::class, 'store']);
    
    // Get a single report
    Route::get('/{report}', [ReportController::class, 'show']);
    
    // Update a report
    Route::put('/{report}', [ReportController::class, 'update']);
    
    // Delete a report
    Route::delete('/{report}', [ReportController::class, 'destroy']);

    // Generate PDF for a report
    Route::get('/{report}/generate-pdf', [ReportController::class, 'generatePdf']);
});
