<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::middleware(['auth:sanctum'])->group(function () {
    // Show email verification notice
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Verify the email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // Marks the email as verified
        return redirect('/dashboard'); // or wherever you want
    })->middleware(['signed'])->name('verification.verify');

    // Resend verification email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Sanctum CSRF endpoint
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['csrf_cookie_set' => true]);
});

// Admin dashboard (protected by admin middleware)
Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function (Request $request) {
    $user = $request->user();
    return view('dashboard.admin', [
        'user' => $user,
        'dashboard' => []
    ]);
});

// Client dashboard
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
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