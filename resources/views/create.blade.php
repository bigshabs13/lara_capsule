<!DOCTYPE html>
<html>
<head>
    <title>Create Time Capsule</title>
</head>
<body>
    <h1>Create a Time Capsule</h1>
    <form method="POST" action="{{ route('capsules.store') }}">
        @csrf
        <label>Message:</label><br>
        <textarea name="message" required></textarea><br><br>

        <label>Latitude:</label>
        <input type="text" name="gps_latitude" required><br>

        <label>Longitude:</label>
        <input type="text" name="gps_longitude" required><br>

        <label>Mood (optional):</label>
        <input type="text" name="mood_id"><br>

        <label>Reveal At:</label>
        <input type="datetime-local" name="reveal_at" required><br>

        <label>Public?</label>
        <input type="checkbox" name="is_public" value="1" checked><br><br>

        <button type="submit">Create Capsule</button>
    </form>
</body>
</html>
