<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body class="body">
    <header class="header-page">
        
            <a href="/menu"><button class="menu-button" type="button"></button></a>
       
        <h1 class="header-logo">
            Rese
        </h1>
        <div class="header-list">
            <p class="headerlink">All area</p>
            <p class="headerlink">All genre</p>
            <p class="headerlink">Search</p>
        </div>
    </header>

    <main class="main">
        @yield('main')
    </main>
</body>
</html>