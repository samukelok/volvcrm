@extends('layouts.dashboards')

@php
    $manifest = json_decode(file_get_contents(public_path('build-client/.vite/manifest.json')), true);
    $entry = $manifest['index.html'];
@endphp

@section('head')
    <!-- CSS -->
    @if (!empty($entry['css']))
        <link rel="stylesheet" href="{{ asset('build-client/' . $entry['css'][0]) }}">
    @endif
@endsection

@section('content')
    <div id="root"></div>
@endsection

@section('scripts')
    <!-- JS -->
    <script type="module" src="{{ asset('build-client/' . $entry['file']) }}"></script>

    <script>
        window.__USER__ = @json($user);
        window.__CLIENT__ = @json(Auth::user()->client ?? null);
        window.__FLASH__ = @json($flash);

    </script>
@endsection
