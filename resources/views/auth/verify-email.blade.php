@extends('layouts.app')

@section('content')
    
    <div class="container mx-auto text-center">
        <h1 class="text-2xl font-bold mb-4">Verify Your Email Address</h1>

        @if (session('message'))
            <div class="mb-4 text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <p class="mb-4">
            Before proceeding, please check your email for a verification link.
            If you did not receive the email,
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                Resend Verification Email
            </button>
        </form>
    </div>

    @endsection
