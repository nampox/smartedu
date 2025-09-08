<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MediaQueryController;
use App\Http\Controllers\FileUploadController;
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

// Public API routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// File upload routes (with rate limiting)
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/upload', [FileUploadController::class, 'upload']);
    Route::post('/upload-multiple', [FileUploadController::class, 'uploadMultiple']);
});

// Protected API routes
Route::middleware(['auth:web', 'throttle:60,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // File management
    Route::delete('/files', [FileUploadController::class, 'delete']);
    Route::get('/files/info', [FileUploadController::class, 'info']);
    Route::get('/files/url', [FileUploadController::class, 'url']);
    
    // Media management
    Route::prefix('media')->group(function () {
        Route::post('/avatar', [MediaController::class, 'uploadAvatar']);
        Route::post('/document', [MediaController::class, 'uploadDocument']);
        Route::post('/image', [MediaController::class, 'uploadImage']);
        Route::get('/', [MediaController::class, 'index']);
        Route::get('/stats', [MediaController::class, 'stats']);
        Route::get('/{media}', [MediaController::class, 'show']);
        Route::get('/{media}/download', [MediaController::class, 'download']);
        Route::delete('/{media}', [MediaController::class, 'destroy']);
    });
    
    // Query Builder APIs
    Route::prefix('query')->middleware('query.builder')->group(function () {
        // Users query
        Route::get('/users', [UserController::class, 'index'])->middleware('permission:query-users');
        Route::get('/users/filters', [UserController::class, 'filters'])->middleware('permission:query-users');
        Route::get('/users/stats', [UserController::class, 'stats'])->middleware('permission:query-users');
        Route::get('/users/search', [UserController::class, 'search'])->middleware('permission:query-users');
        Route::get('/users/{user}', [UserController::class, 'show'])->middleware('permission:query-users');
        
        // Media query
        Route::get('/media', [MediaQueryController::class, 'index'])->middleware('permission:query-media');
        Route::get('/media/filters', [MediaQueryController::class, 'filters'])->middleware('permission:query-media');
        Route::get('/media/stats', [MediaQueryController::class, 'stats'])->middleware('permission:query-media');
        Route::get('/media/search', [MediaQueryController::class, 'search'])->middleware('permission:query-media');
        Route::get('/media/collection/{collection}', [MediaQueryController::class, 'byCollection'])->middleware('permission:query-media');
        Route::get('/media/{media}', [MediaQueryController::class, 'show'])->middleware('permission:query-media');
    });
});

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0',
    ]);
});
