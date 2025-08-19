<!DOCTYPE html>
<html>
<head>
    <title>New Funnel Created</title>
</head>
<body>
    <h2>New Funnel Created</h2>
    <p>A new funnel titled <strong>{{ $funnel->title }}</strong> has been created.</p>
    <p><strong>Goal:</strong> {{ $funnel->goal }}</p>
    <p><strong>Target Audience:</strong> {{ $funnel->target_audience }}</p>
    <p><strong>CTA:</strong> {{ $funnel->cta }}</p>
    <p><strong>Deadline:</strong> {{ $funnel->deadline->format('d M Y') }}</p>
    <p>Please review the funnel in the dashboard.</p>
</body>
</html>
