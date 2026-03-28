<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Controllers\UserController;

// Protected routes - require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Get current user's profile
    Route::get('/profile', [UserController::class, 'profile']);
    
    // Update current user's company profile
    Route::put('/profile', [UserController::class, 'updateProfile']);
});
