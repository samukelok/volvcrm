@extends('layouts.app')

@section('content')
<div class="client-dashboard">
    <h1>Welcome, {{ $user->name }}</h1>
    <div class="quick-actions">
        <a href="/client/funnel-request" class="btn btn-primary">
            Request New Funnel
        </a>
    </div>
</div>
@endsection