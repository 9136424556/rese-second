<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ReseManagement</title>
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/admin-app.css') }}" />
        @yield('css')
    </head>

    <body class="body">
     <header class="header-page">
        <h1 class="header-logo">
            ReseManagement
        </h1>
        @if(Auth::check())
        <div class="header-logout">
            <form action="/logout" method="POST">
            @csrf
                <button class="logout-button" type="submit">Logout</button>
            </form>
        </div>
        @endif
     </header>
        <main>
            @yield('main')
        </main>
    </body>
</html>
