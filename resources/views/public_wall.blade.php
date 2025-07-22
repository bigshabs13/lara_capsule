<!DOCTYPE html>
<html>
<head>
    <title>Public Capsule Wall</title>
</head>
<body>
    <h1>Public Capsule Wall</h1>
    <ul>
        @foreach($capsules as $capsule)
            <li>
                <strong>{{ $capsule->message }}</strong>
                ({{ $capsule->country }}, {{ $capsule->reveal_at }})
            </li>
        @endforeach
    </ul>
</body>
</html>
