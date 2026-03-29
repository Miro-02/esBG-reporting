<?php

use Illuminate\Support\Facades\Route;

// Reports module routes - prefixed with /reports
Route::prefix('reports')->group(base_path('modules/Reports/Routes/api.php'));

// Load other module routes
require base_path('modules/Auth/Routes/api.php');
require base_path('modules/Country/Routes/api.php');
require base_path('modules/Sector/Routes/api.php');
require base_path('modules/User/Routes/api.php');
require base_path('modules/Framework/Routes/api.php');


