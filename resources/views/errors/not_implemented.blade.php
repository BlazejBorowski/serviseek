<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feature Not Implemented</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Feature Not Implemented</h1>
        <p>We apologize, but the feature you are trying to use has not been implemented yet.</p>
        @if (!empty($message))
            <p>Error message: {{ $message }}</p>
        @endif
        <a href="{{ url('/') }}">Return to Home Page</a>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
