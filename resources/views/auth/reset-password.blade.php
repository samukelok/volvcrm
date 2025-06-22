@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <input type="email" name="email" value="{{ old('email', $email) }}" required
               class="w-full mb-3 px-3 py-2 border rounded" placeholder="Email" />
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="password" name="password" required
               class="w-full mb-3 px-3 py-2 border rounded" placeholder="New Password" />
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="password" name="password_confirmation" required
               class="w-full mb-3 px-3 py-2 border rounded" placeholder="Confirm Password" />

        <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
            Reset Password
        </button>
    </form>
</div>
@endsection