<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Name - @yield('title')</title>
        <link rel="stylesheet" href="{{ mix('/css/app.css')}}">
    </head>
    <body class="h-100vh">
        @include('dashboard.navbar')
        @include('dashboard.menuLeftSide')
        <div class="dashboard-container-main">
            @yield('content')
        </div>

    </body>
</html>
