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