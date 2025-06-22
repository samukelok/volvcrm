@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Forgot your password?</h2>
    <p class="mb-4 text-sm text-gray-600">
        Enter your email and we'll send you a link to reset your password.
    </p>

    @if (session('status'))
        <div class="mb-4 text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required
               class="w-full mb-3 px-3 py-2 border rounded" />
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
            Email Password Reset Link
        </button>
    </form>
</div>
@endsection