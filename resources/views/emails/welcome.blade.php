<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
</head>
<body>
    <h1>Welcome, {{ $data['name'] }}!</h1>
    <p>{{ $data['message'] }}</p>
</body>
</html>
