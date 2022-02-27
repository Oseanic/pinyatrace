<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href = "{{ asset('icons/pinyatrace_logo1.png') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Pinyatrace', 'PinyaTrace') }}</title>

   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

   <!-- Icons-->
   <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
   <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet"> <!-- icons -->

   <!-- Main styles for this application-->
   <link href="{{ asset('css/style.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/global.css') }}">
   @yield('css')

</head>
<body class="c-body">

        <main class="c-app p-0 bg-white">
            @yield('app')
        </main>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tooltips.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/coreui-utils.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
</html>
