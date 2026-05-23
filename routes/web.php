<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// FILE: routes/web.php
// All routes listed here — authenticated user routes + admin-only routes

// ── PUBLIC ──────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/about', 'about')->name('about.show');
Route::view('/contact', 'contact')->name('contact.show');
Route::view('/terms', 'terms')->name('terms.show');

// ── GOOGLE OAUTH ────────────────────────────────────────────────────
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// ── AUTHENTICATED USER ROUTES ────────────────────────────────────────
// auth     = must be logged in (Jetstream handles redirect to /login)
// verified = email must be verified

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [TaskController::class, 'index'])
         ->middleware('redirect_admin_to_panel')
         ->name('dashboard');

    Route::get('/tasks/create',            [TaskController::class, 'create'])
         ->name('tasks.create');
    Route::post('/tasks',                  [TaskController::class, 'store'])
         ->name('tasks.store');
    Route::get('/tasks/{task}/edit',       [TaskController::class, 'edit'])
         ->name('tasks.edit');
    Route::put('/tasks/{task}',            [TaskController::class, 'update'])
         ->name('tasks.update');
    Route::delete('/tasks/{task}',         [TaskController::class, 'destroy'])
         ->name('tasks.destroy');
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])
         ->name('tasks.complete');
    Route::get('/task-history',            [TaskController::class, 'history'])
         ->name('tasks.history');
});

// ── ADMIN-ONLY ROUTES ────────────────────────────────────────────────
// 'admin' alias = AdminMiddleware (checks role === 'admin')
// All URLs prefixed with /admin/

Route::middleware(['auth', 'admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {

    Route::get('/dashboard',           [AdminController::class, 'dashboard'])
         ->name('dashboard');

    Route::get('/users',               [AdminController::class, 'users'])
         ->name('users');
    Route::patch('/users/{user}/role', [AdminController::class, 'toggleRole'])
         ->name('users.toggle-role');
    Route::delete('/users/{user}',     [AdminController::class, 'destroyUser'])
         ->name('users.destroy');

    Route::get('/tasks',               [AdminController::class, 'tasks'])
         ->name('tasks');
    Route::delete('/tasks/{task}',     [AdminController::class, 'destroyTask'])
         ->name('tasks.destroy');

    // REPORTS & ANALYTICS
    Route::get('/reports',             [AdminController::class, 'reports'])
         ->name('reports');
    Route::get('/analytics',           [AdminController::class, 'analytics'])
         ->name('analytics');
    Route::get('/analytics/data',      [AdminController::class, 'analyticsData'])
         ->name('analytics.data');
    Route::get('/activity',            [AdminController::class, 'activity'])
         ->name('activity');

    // SETTINGS
    Route::get('/settings',            [AdminController::class, 'settings'])
         ->name('settings');
    Route::post('/settings',           [AdminController::class, 'updateSettings'])
         ->name('settings.update');
});
