<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <!--javascript-->
        <script src="{{ asset('js/app.js') }}"></script>
       
        @yield('css')
    </head>

    <body class="body">
     <header class="header-page">
        <a href="/menu"><button class="menu-button" type="button"></button></a>
        <h1 class="header-logo">
            Rese
        </h1>
     </header>
        <main>
            @yield('main')
        </main>
    </body>
</html>
