<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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

// Admin Routes (Log Viewer)
Route::get('/log', [LogController::class, 'index'])->name('logs.index');


