<!DOCTYPE html>
<html>
<head>
    <title>View Capsule</title>
</head>
<body>
    <h1>Capsule Details</h1>
    <p><strong>Message:</strong> {{ $capsule->message }}</p>
    <p><strong>Location:</strong> {{ $capsule->gps_latitude }}, {{ $capsule->gps_longitude }}</p>
    <p><strong>Country:</strong> {{ $capsule->country }}</p>
    <p><strong>Reveal At:</strong> {{ $capsule->reveal_at }}</p>
    <p><strong>Revealed At:</strong> {{ $capsule->revealed_at }}</p>
    <p><strong>Mood:</strong> {{ $capsule->mood_id }}</p>
    <p><strong>Public:</strong> {{ $capsule->is_public ? 'Yes' : 'No' }}</p>
</body>
</html>
