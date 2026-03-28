<?php

use Illuminate\Support\Facades\Route;
use Modules\Framework\Controllers\ReferenceDataController;

Route::prefix('api')->group(function () {
    // Reference data endpoints (public, no auth required)
    Route::get('/reference-data', [ReferenceDataController::class, 'index']);
    Route::get('/reference-data/countries', [ReferenceDataController::class, 'countries']);
    Route::get('/reference-data/sectors', [ReferenceDataController::class, 'sectors']);
    Route::get('/reference-data/legal-forms', [ReferenceDataController::class, 'legalForms']);
    Route::get('/reference-data/frameworks', [ReferenceDataController::class, 'frameworks']);
    Route::get('/reference-data/certifications', [ReferenceDataController::class, 'certifications']);
    Route::get('/reference-data/cdp-levels', [ReferenceDataController::class, 'cdpLevels']);
    Route::get('/reference-data/ecoVadis-ratings', [ReferenceDataController::class, 'ecoVadisRatings']);
});
