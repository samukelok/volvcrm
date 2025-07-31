<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use App\Models\Invitation;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'token' => 'nullable|string'
        ]);

        // Log all form data for debugging
        Log::info('Registration request data:', $request->all());

        $invitation = null;
        $clientId = null;
        $roleName = 'client_admin'; // Default role for new users

        // Check if token is present
        if ($request->filled('token')) {
            logger('Token provided, checking invitation.');

            $invitation = Invitation::where('token', $request->token)
                ->where('email', $request->email)
                ->where('expires_at', '>', now())
                ->first();

            if (!$invitation) {
                logger('Invitation not found or expired.');
                return response()->json([
                    'flash' => 'Invalid or expired invitation token.',
                    'type' => 'error'
                ], 422);
            }

            $clientId = $invitation->client_id;
            $roleName = $invitation->role ?? 'client_user';

            // Log assigned client and role
            logger("Assigned client ID: {$clientId}, role: {$roleName}");
        } else {
            logger('No token provided, proceeding without invitation.');
        }

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
                'client_id' => $clientId,
            ]);

            // Log user creation and assigned role with client ID
            logger("User created: {$user->id}, assigned role: {$roleName}, client ID: {$clientId}");

            // Assign role
            $user->assignRole($roleName);

            // Trigger registration event
            event(new Registered($user));

            // Authenticate the user
            Auth::login($user);
            $request->session()->regenerate();

            // Store flash message in session for redirect
            session()->flash('success', ':) Welcome to VolvCRM.');

            return response()->json([
                'flash' => ':) Welcome to VolvCRM.',
                'user' => $user->load('roles'),
                'redirect' => $user->hasRole('admin') ? '/admin' : '/client'
            ]);

        } catch (\Exception $e) {
            logger('Registration failed: ' . $e->getMessage());
            return response()->json([
                'flash' => 'Registration failed. Please try again.',
                'type' => 'error'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user()->load('roles');
            $redirectTo = $user->hasRole('admin') ? '/admin' : '/client';

            // Store flash message in session for redirect
            session()->flash('success', 'Welcome back! ');

            // Store flash message in session for redirect
            session()->flash('success', 'Welcome back!');

            return response()->json([
                'flash' => 'Welcome back! ',
                'user' => $user,
                'redirect' => $redirectTo
            ]);
        }

        return response()->json([
            'flash' => 'Invalid email or password. Please try again.',
            'type' => 'error'
        ], 401);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('roles');

        $response = [
            'user' => $user,
            'dashboard' => []
        ];

        if ($user->hasRole('admin')) {
            $response['dashboard'] = [
                'type' => 'admin',
                'quick_actions' => [
                    ['title' => 'Manage Clients', 'url' => '/admin/clients'],
                    ['title' => 'View Funnel Requests', 'url' => '/admin/funnel-requests']
                ],
                'stats' => [] // To populate this later
            ];
        } else {
            $response['dashboard'] = [
                'type' => 'client',
                'quick_actions' => [
                    ['title' => 'Request New Funnel', 'url' => '/client/funnel-request'],
                    ['title' => 'View Leads', 'url' => '/client/leads']
                ]
            ];
        }

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        try {
        try {
            // For API (token-based) logout
            $token = $request->user()?->currentAccessToken();
            if ($token) {
                $token->delete();
            }

            // For session-based logout
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Store flash message in session for redirect
            session()->flash('success', 'You have been logged out successfully.');

            return response()->json([
                'flash' => 'You have been logged out successfully.',
                'redirect' => '/login'
            ]);

        } catch (\Exception $e) {
            logger('Logout failed: ' . $e->getMessage());
            return response()->json([
                'flash' => 'Logout failed. Please try again.',
                'type' => 'error'
            ], 500);
        }

            return response()->json([
                'redirect' => $redirectTo
            ]);
        } catch (\Exception $e) {
            logger('Logout failed: ' . $e->getMessage());
            return response()->json([
                'flash' => 'Logout failed. Please try again.',
                'type' => 'error'
            ], 500);
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
}