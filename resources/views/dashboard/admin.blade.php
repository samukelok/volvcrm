@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    <h1>Welcome, {{ $user->name }}</h1>
    <h3>Your phone is {{$user->phone}}</h3>
    <p>You were verified at {{$user->email_verified_at}}</p>
    <div class="quick-actions">
        <a href="/admin" class="btn btn-primary">
            View Guide
        </a>
    </div>
</div>
@endsection