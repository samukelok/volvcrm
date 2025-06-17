<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            'is_active' => true, // Explicitly set active status
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
        
        // Add manual user lookup and password verification
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

        Auth::login($user); // Manually log in the user
        Log::info('Login successful', ['user_id' => $user->id]);

        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user->load('roles')
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user()->load('roles'));
    }
}