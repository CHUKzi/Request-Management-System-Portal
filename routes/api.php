<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->prefix('/v1')->group(function () {
    // Auth
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('/check-auth', [AuthController::class, 'checkAuth']);

    // Requests
    Route::middleware('auth:sanctum')->prefix('/requests')->group(function () {
        Route::get('/', [RequestController::class, 'index']);
        Route::post('/store', [RequestController::class, 'store']);
        Route::get('/edit/{id}', [RequestController::class, 'edit']);
        Route::patch('/update/{id}', [RequestController::class, 'update']);
        Route::delete('/delete/{id}', [RequestController::class, 'destroy']);
    });
});

