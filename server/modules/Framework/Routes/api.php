<?php

use Illuminate\Support\Facades\Route;
use Modules\Framework\Controllers\FrameworkController;
use Modules\Framework\Controllers\CertificationController;

// Public routes for dropdowns - no authentication required
// Routes are automatically prefixed with 'api/framework' by ModuleServiceProvider
Route::get('frameworks', [FrameworkController::class, 'index']);
Route::get('certifications', [CertificationController::class, 'certifications']);
Route::get('legal-forms', [CertificationController::class, 'legalForms']);
Route::get('cdp-levels', [CertificationController::class, 'cdpLevels']);
Route::get('ecoVadis-ratings', [CertificationController::class, 'ecoVadisRatings']);