@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    <h1>Admin Dashboard</h1>
    <div class="quick-actions">
        @foreach($dashboard['quick_actions'] as $action)
            <a href="{{ $action['url'] }}">{{ $action['title'] }}</a>
        @endforeach
    </div>
</div>
@endsection