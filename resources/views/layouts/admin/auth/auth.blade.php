<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/admin/login.css') }}" rel="stylesheet">
    {{--<link rel="shortcut icon" href="{{ asset('images/admin/favicon.svg') }}" type="image/x-icon">--}}
</head>

<body>
    <div id="auth">
        @yield('content')
    </div>
    @section('js')
    <script src="{{ asset('js/admin/login.js') }}" defer></script>
    @show
</body>

</html>