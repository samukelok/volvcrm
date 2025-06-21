@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6">Register</h1>
    
    <form id="register-form">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="name">Name</label>
            <input type="text" id="name" name="name" required
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="email">Email</label>
            <input type="email" id="email" name="email" required
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="password">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2" for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <button type="submit" 
                class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
            Register
        </button>
    </form>
    
    <div class="mt-4 text-center">
        <a href="/login" class="text-blue-500 hover:underline">Already have an account? Login</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('register-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    registerUser(name, email, password, confirm);
});
</script>
@endsection