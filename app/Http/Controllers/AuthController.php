<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{   
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true, 
        ]);

        $user->assignRole('client_user');

        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        Log::debug('Login attempt', ['email' => $request->email]);

        $credentials = $request->only('email', 'password');
        
        // Password validation
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            Log::warning('Login failed: User not found', ['email' => $credentials['email']]);
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            Log::warning('Login failed: Password mismatch', ['user_id' => $user->id]);
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        if (!$user->is_active) {
            Log::warning('Login failed: Inactive account', ['user_id' => $user->id]);
            return response()->json(['message' => 'Account is inactive'], 403);
        }

        Auth::login($user);
        Log::info('Login successful', ['user_id' => $user->id]);

        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user->load('roles')
        ]);
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
    $request->user()->currentAccessToken()->delete();

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