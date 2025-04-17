<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('sign-up', "register");
        Route::post('sign-in', "login");
        Route::delete('sign-out', "logout")
            ->middleware('auth:sanctum');
});

Route::post("tasks", [TaskController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('categories')
        ->controller(CategoryController::class)
        ->group(function () {
           Route::post("/", "create");
           Route::get("/", "list");
           Route::prefix('{category_id}')->group(function () {
               Route::get("/", "findById");
               Route::put("/", "update");
               Route::delete("/", "delete");
           });
    });

    Route::controller(TaskController::class)->group(function () {
        Route::get("my-tasks", "myTasks");

        Route::prefix('tasks')
            ->group(function () {
                Route::get("/","list");

                Route::prefix('{task_id}')->group(function () {
                    Route::get("/","findById");

                    Route::middleware(["can:edit tasks", "can:delete tasks"])->group(function () {
                        Route::patch("/","update");
                        Route::delete("/","delete");
                    });

                    Route::patch("/assign", "assignTaskToUser")->middleware(["can:assign tasks"]);
                });
            });
    });
});

