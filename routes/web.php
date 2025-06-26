<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ClientOnboardingController;
use App\Http\Controllers\DomainVerificationController;
    use App\Models\Invitation;

use App\Models\Role;

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

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    // Remove invitation if it exists
    Invitation::where('email', $request->user()->email)->delete();

    // Redirect conditionally
    $redirectTo = $request->query('redirectTo', '/dashboard');

    return redirect($redirectTo);
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

// Client/Company Onboarding
Route::get('/onboarding', [ClientOnboardingController::class, 'show'])->name('client.onboarding');
Route::post('/onboarding', [ClientOnboardingController::class, 'store'])->name('client.onboarding.store');
Route::get('/verify-domain', [DomainVerificationController::class, 'verify'])->name('client.verify.domain');

/**
 * 
 * 
 * 
 * Client Dashboard
 * 
 * 
 * 
 */

//  Main Page
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
    $user = $request->user();
    return view('dashboard.client', [
        'user' => $user,
        'dashboard' => []
    ]);
});

// Profile Page
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    })->name('profile');

    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Team Members Page
Route::middleware(['auth'])->group(function () {
    Route::get('/team-members', function () {
        $user = Auth::user();

        if (!$user->client) {
            // No team yet – show only the logged-in user with a message
            $teamMembers = collect([$user]);
            $availableRoles = Role::where('name', '!=', 'admin')->get();

            return view('dashboard.members', [
                'user' => $user,
                'teamMembers' => $teamMembers,
                'availableRoles' => $availableRoles,
                'noTeam' => true,
            ]);
        }

        // Client exists – show full team
        $teamMembers = $user->client->users()->with('roles')->get();
        $availableRoles = Role::where('name', '!=', 'admin')->get();

        return view('dashboard.members', compact('user', 'teamMembers', 'availableRoles'));
    })->name('team');

    Route::post('/team-members/invite', [TeamController::class, 'invite'])->name('team.invite');
    Route::put('/team-members/{user}/update-role', [TeamController::class, 'updateRole'])->name('team.update-role');
    Route::delete('/team-members/{user}/remove', [TeamController::class, 'remove'])->name('team.remove');
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
