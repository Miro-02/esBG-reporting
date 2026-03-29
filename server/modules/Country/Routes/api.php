<?php

use Illuminate\Support\Facades\Route;
use Modules\Country\Controllers\CountryController;

// Public routes for dropdowns - no authentication required
Route::get('/', [CountryController::class, 'index']);

