<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('sign-up', [AuthController::class, 'register']);
    Route::post('sign-in', [AuthController::class, 'login']);
    Route::delete('sign-out', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('categories')->group(function () {
       Route::post("/", [CategoryController::class, 'create']);
       Route::get("/", [CategoryController::class, 'list']);
       Route::prefix('{category_id}')->group(function () {
           Route::get("/", [CategoryController::class, 'findById']);
           Route::put("/", [CategoryController::class, 'update']);
           Route::delete("/", [CategoryController::class, 'delete']);
       });
    });
});

