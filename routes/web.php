<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

/**
 * 
 * 
 * 
 * Auth Pages
 * 
 * 
 */

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::middleware(['auth:sanctum'])->group(function () {
    // Show email verification notice
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Verify the email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); 
        return redirect('/dashboard');
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

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset password form
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/**
 * 
 * 
 * 
 * Client Dashboard
 * 
 * 
 * 
 */
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
    $user = $request->user();
    return view('dashboard.client', [
        'user' => $user,
        'dashboard' => []
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        $user = Auth::user(); 
        return view('dashboard.profile', compact('user')); 
    })->name('profile');

    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

/**
 * 
 * 
 * 
 * Admin Dashboard
 * 
 * 
 * 
 */
Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function (Request $request) {
    $user = $request->user();
    return view('admin.admin', [
        'user' => $user,
        'dashboard' => []
    ]);
});

/**
 * 
 * 
 * 
 * API routes are called as web (cookies + session approach)
 * 
 * 
 * 
 */

Route::middleware(['web'])->group(function () {
    Route::post('/api/login', [AuthController::class, 'login']);
    Route::post('/api/register', [AuthController::class, 'register']);
    Route::post('/api/logout', [AuthController::class, 'logout']);
    Route::get('/api/me', [AuthController::class, 'me']);
});

