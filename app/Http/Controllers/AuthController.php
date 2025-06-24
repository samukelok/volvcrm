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
        Log::debug('Full form data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'token' => 'nullable|string'
        ]);

        // Log the incoming request data
        logger('--- Register Request ---');
        logger('Name: ' . $request->name);
        logger('Email: ' . $request->email);
        logger('Token: ' . $request->token);

        $token = $request->input('token');
        Log::debug('Token: ' . $token);

        $invitation = null;
        $clientId = null;
        $roleName = 'client_user';

        // Check if token is present
        if ($request->filled('token')) {
            logger('Token provided, attempting to find matching invitation...');

            $invitation = Invitation::where('token', $request->token)
                ->where('email', $request->email)
                ->where('expires_at', '>', now())
                ->first();

            logger('Invitation found: ' . json_encode($invitation));

            if (!$invitation) {
                logger('Invitation not found or expired.');
                return response()->json(['message' => 'Invalid or expired invitation token.'], 422);
            }

            $clientId = $invitation->client_id;
            $roleName = $invitation->role ?? 'client_user';

            logger("Extracted client_id: $clientId and role: $roleName from invitation.");
        } else {
            logger('No token provided, proceeding without invitation.');
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
            'client_id' => $clientId,
        ]);

        logger('User created: ' . json_encode($user));

        // Assign role
        $user->assignRole($roleName);
        logger("Role assigned to user: $roleName");

        // Delete invitation after use
        if ($invitation) {
            $invitation->delete();
            logger('Invitation deleted after successful registration.');
        }

        // Trigger registration event
        event(new Registered($user));

        // Authenticate the user
        Auth::login($user);
        $request->session()->regenerate();
        logger('User logged in and session regenerated.');

        return response()->json([
            'message' => 'Registered and logged in successfully. Please verify your email.',
            'user' => $user->load('roles'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user()->load('roles');
            $redirectTo = $user->hasRole('admin') ? '/admin' : '/dashboard';

            return response()->json([
                'message' => 'Logged in',
                'user' => $user,
                'redirect' => $redirectTo
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
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
        // For API (token-based) logout
        $token = $request->user()?->currentAccessToken();
        if ($token) {
            $token->delete();
        }

        // For session-based logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
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
