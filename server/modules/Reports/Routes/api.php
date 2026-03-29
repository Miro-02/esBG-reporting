<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Controllers\ReportController;
use Modules\Reports\Controllers\ImportReportController;

// Protected routes - require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Get all reports for authenticated user
    Route::get('/', [ReportController::class, 'index']);
    
    // Create a new report
    Route::post('/', [ReportController::class, 'store']);
    
    // Bulk import reports from Excel
    Route::post('/import', [ImportReportController::class, 'store']);
    
    // Get a single report
    Route::get('/{report}', [ReportController::class, 'show']);
    
    // Update report metadata
    Route::put('/{report}/metadata', [ReportController::class, 'updateMetadata']);

    // Update individual sections
    Route::put('/{report}/section1', [ReportController::class, 'updateSection1']);
    Route::put('/{report}/section2', [ReportController::class, 'updateSection2']);
    Route::put('/{report}/section3', [ReportController::class, 'updateSection3']);
    Route::put('/{report}/section4', [ReportController::class, 'updateSection4']);
    Route::put('/{report}/section5', [ReportController::class, 'updateSection5']);
    Route::put('/{report}/section6', [ReportController::class, 'updateSection6']);
    Route::put('/{report}/section7', [ReportController::class, 'updateSection7']);

    // Update frameworks and certifications
    Route::put('/{report}/frameworks', [ReportController::class, 'updateFrameworks']);
    Route::put('/{report}/certifications', [ReportController::class, 'updateCertifications']);
    
    // Delete a report
    Route::delete('/{report}', [ReportController::class, 'destroy']);

    // Generate PDF for a report
    Route::get('/{report}/generate-pdf', [ReportController::class, 'generatePdf']);

    // Get compliance violations for a report
    Route::get('/{report}/violations', [ReportController::class, 'getViolations']);
});
