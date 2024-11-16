<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feature is inactive</title>
</head>

<body>
    <div class="container">
        <h1>Feature is inactive</h1>
        @if (!empty($message))
            <p>{{ $message }}</p>
        @endif
        <a href="{{ url('/') }}">Return to Home Page</a>
    </div>
</body>

</html>
