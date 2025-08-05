<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;

// User Routes
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/courses', [UserController::class, 'courses'])->name('courses.index');
Route::get('/teachers', [UserController::class, 'teachers'])->name('teachers.index');
Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/contact', [UserController::class, 'contact'])->name('contact');

// Admin Routes (Log Viewer)
Route::get('/log', [LogController::class, 'index'])->name('logs.index');


