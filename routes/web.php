<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/courses', [UserController::class, 'courses'])->name('courses.index');
Route::get('/teachers', [UserController::class, 'teachers'])->name('teachers.index');
Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/contact', [UserController::class, 'contact'])->name('contact');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes - Protected by admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/users/{id}', [DashboardController::class, 'showUser'])->name('users.show');
    Route::post('/users/{id}/change-role', [DashboardController::class, 'changeUserRole'])->name('users.change-role');
    Route::delete('/users/{id}', [DashboardController::class, 'deleteUser'])->name('users.delete');

    // System
    Route::get('/refresh-cache', [DashboardController::class, 'refreshCache'])->name('refresh-cache');
});

// Log Viewer (Legacy route)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/log', [LogController::class, 'index'])->name('logs.index');
});
