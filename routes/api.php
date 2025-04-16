<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('sign-up', [AuthController::class, 'register']);
    Route::post('sign-in', [AuthController::class, 'login']);
    Route::delete('sign-out', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::post("tasks", [TaskController::class, 'create']);

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

    Route::prefix('tasks')->group(function () {
        Route::get("/", [TaskController::class, 'list']);

        Route::prefix('{task_id}')->group(function () {
            Route::get("/", [TaskController::class, 'findById']);

            Route::middleware(["can:edit tasks", "can:delete tasks"])->group(function () {
                Route::patch("/", [TaskController::class, 'update']);
                Route::delete("/", [TaskController::class, 'delete']);
            });
        });
    });
});

