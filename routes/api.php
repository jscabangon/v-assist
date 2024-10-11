<?php

/** Controllers */
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\TodoApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->group( function() {
        Route::post('login', [AuthApiController::class, 'login']);
        Route::post('logout', [AuthApiController::class, 'logout']);
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::prefix('users')->group(function() {
            Route::get('list', [UserApiController::class, 'list']);
            Route::get('view/{user}', [UserApiController::class, 'view']);
            Route::put('store', [UserApiController::class, 'store']);
            Route::patch('update/{userId}', [UserApiController::class, 'update']);
            Route::delete('delete/{userId}', [UserApiController::class, 'delete']);
        });

        Route::prefix('todo')->group(function() {
            Route::get('list', [TodoApiController::class, 'list']);
            Route::get('view/{todoId}', [TodoApiController::class, 'view']);
            Route::put('store', [TodoApiController::class, 'store']);
            Route::patch('update/{todoId}', [TodoApiController::class, 'update']);
            Route::delete('delete/{todoId}', [TodoApiController::class, 'delete']);
        });
    });
});