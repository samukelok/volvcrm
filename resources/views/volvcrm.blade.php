@extends('layouts.app')

@php
    $manifest = json_decode(file_get_contents(public_path('build-landing-page/.vite/manifest.json')), true);
    $entry = $manifest['index.html'];
@endphp

@section('head')
    <!-- CSS -->
    @if (!empty($entry['css']))
        <link rel="stylesheet" href="{{ asset('build-landing-page/' . $entry['css'][0]) }}">
    @endif
@endsection

@section('content')
    <div id="root"></div>
@endsection

@section('scripts')
    <!-- JS -->
    <script type="module" src="{{ asset('build-landing-page/' . $entry['file']) }}"></script>

@endsection