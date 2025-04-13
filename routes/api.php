<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('sign-up', [AuthController::class, 'register']);
    Route::post('sign-in', [AuthController::class, 'login']);
    Route::delete('sign-out', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// protected routes
