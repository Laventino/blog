<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ URL::to('/') }}/assets/image/logo.svg">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/jquery-min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/variable.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icon-font.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awsome.css') }}" rel="stylesheet">

    <!-- Custom function -->
    <script src="{{ asset('js/javascript.js') }}"></script>
    <script src="{{ asset('js/custom-scroll.js') }}"></script>

    @if (Auth::check())
        <!-- Custom function -->
        <script src="{{ asset('js/custom-scroll.js') }}"></script>
        <link href="{{ asset('css/custom-scroll.css') }}" rel="stylesheet">

        <script src="{{ asset('js/custom-drag-drop.js') }}"></script>
        <link href="{{ asset('css/custom-drag-drop.css') }}" rel="stylesheet">
    @endif
</head>
<style>
    .xx {
        background-color: blue;
        position: absolute;
        z-index: 1000;
    }
</style>

<body>
    <div id="app">
        @if (Auth::check())
        @endif
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
