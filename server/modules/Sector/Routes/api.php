<?php

use Illuminate\Support\Facades\Route;
use Modules\Sector\Controllers\SectorController;

// Public routes for dropdowns - no authentication required
Route::get('/', [SectorController::class, 'index']);

