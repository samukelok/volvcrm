@php
    $manifest = json_decode(file_get_contents(public_path('build-client/.vite/manifest.json')), true);
    $entry = $manifest['index.html'];
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Evolve Faster, Revolve Smarter.</title>

    <!-- CSS -->
    @if (!empty($entry['css']))
        <link rel="stylesheet" href="{{ asset('build-client/' . $entry['css'][0]) }}">
    @endif
</head>

<body>
    <div id="root"></div>

    <!-- JS -->
    <script type="module" src="{{ asset('build-client/' . $entry['file']) }}"></script>

    <script>
        window.__USER__ = @json($user);
    </script>

</body>

</html>
