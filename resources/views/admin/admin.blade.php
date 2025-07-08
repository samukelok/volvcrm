@php
    $manifest = json_decode(file_get_contents(public_path('build-admin/.vite/manifest.json')), true);
    $entry = $manifest['index.html'];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>

    <!-- Load CSS dynamically -->
    @if (!empty($entry['css']))
        <link rel="stylesheet" href="{{ asset('build-admin/' . $entry['css'][0]) }}" />
    @endif
</head>
<body>
    <div id="root"></div>

    <!-- Load JS dynamically -->
    <script type="module" src="{{ asset('build-admin/' . $entry['file']) }}"></script>
</body>
</html>