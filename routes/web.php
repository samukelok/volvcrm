<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Sanctum CSRF endpoint
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['csrf_cookie_set' => true]);
});

// Admin dashboard (protected by admin middleware)
Route::middleware(['auth:sanctum', 'admin'])->get('/admin', function (Request $request) {
    return view('dashboard.admin', [
        'user' => $request->user(),
        'dashboard' => $request->user()->dashboardData() 
    ]);
});

// Client dashboard
Route::middleware(['auth:sanctum'])->get('/dashboard', function (Request $request) {
    return view('dashboard.client', [
        'user' => $request->user()
    ]);
});

// API routes are called as web (cookies + session approach)
Route::middleware(['web'])->group(function () {
    Route::post('/api/login', [AuthController::class, 'login']);
    Route::post('/api/register', [AuthController::class, 'register']);
    Route::post('/api/logout', [AuthController::class, 'logout']);
    Route::get('/api/me', [AuthController::class, 'me']);
});