<?php

use App\Http\Controllers\Api\AnalyticsApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Sanctum Bearer Token Authentication
|--------------------------------------------------------------------------
|
| Public routes (throttled heavily to prevent brute-force attacks).
| Protected routes require a valid Bearer token from /api/login.
|
*/

// Public: auth — 10 requests per minute to prevent brute-force
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/login',    [AuthApiController::class, 'login']);
    Route::post('/register', [AuthApiController::class, 'register']);
});

// Protected: all routes below require a valid Sanctum Bearer token
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

    // Auth
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user',    [AuthApiController::class, 'user']);

    // Tasks — full CRUD + toggle complete
    Route::get('/tasks',                   [TaskApiController::class, 'index']);
    Route::post('/tasks',                  [TaskApiController::class, 'store']);
    Route::get('/tasks/{task}',            [TaskApiController::class, 'show']);
    Route::put('/tasks/{task}',            [TaskApiController::class, 'update']);
    Route::delete('/tasks/{task}',         [TaskApiController::class, 'destroy']);
    Route::patch('/tasks/{task}/complete', [TaskApiController::class, 'complete']);

    // Analytics
    Route::get('/analytics/summary', [AnalyticsApiController::class, 'summary']);
});
