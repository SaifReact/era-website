<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Website is under maintenance.</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/error.css') }}" rel="stylesheet">
</head>

<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <img class="img-error" src="{{ asset('images/errors/error-500.png') }}" alt="Website is under maintenance.">
                <div class="text-center">
                    <h1 class="error-title">Website is under maintenance.</h1>
                    <p class="fs-5 text-gray-600">The website is currently in maintenance mode. Please try again later.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
