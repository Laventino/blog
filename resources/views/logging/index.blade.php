<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/loggin.css')}}">
        <title>
            @hasSection('title')
                @yield('title')
            @else
                Menglong
            @endif
        </title>
        
    </head>
    <body class="h-100vh">
        @yield('content')
    </body>
</html>
