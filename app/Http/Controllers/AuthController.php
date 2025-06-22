<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        // Send email verification
        event(new Registered($user)); 

        Auth::login($user);
        $request->session()->regenerate();

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
