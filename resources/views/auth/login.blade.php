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
                class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            Login
        </button>
    </form>
    
    <div class="mt-4 text-center">
        <a href="/register" class="text-blue-500 hover:underline">Need an account? Register</a>
    </div>

    <!--Forgot Password Section -->
    <div class="mt-2 text-center">
        <a href="/forgot-password" class="inline-block text-sm text-gray-600 hover:text-blue-500 transition duration-150 ease-in-out">
            Forgot your password?
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('login-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    loginUser(email, password);
});
</script>
@endsection