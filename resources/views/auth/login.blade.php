@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6">Login</h1>
    
    <form id="login-form">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="email">Email</label>
            <input type="email" id="email" name="email" required
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2" for="password">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <button type="submit" 
                class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
            Login
        </button>
    </form>
    
    <div class="mt-4 text-center">
        <a href="/register" class="text-blue-500 hover:underline">Need an account? Register</a>
    </div>
</div>
@endsection