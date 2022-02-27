<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('css/free.min.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    </head>
    <body class="c-app">

        <div class="container d-flex align-items-center justify-content-center min-vh-100 p-0">
            <div class="row">
                <img src="{{ asset('img/pinyasafe_logo.png') }}" height="500" width="500">
            </div>
        </div>

        <!-- Styles -->
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
<h1>You scanned the QR</h1>