<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'COACHTECH')</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('css')
    </head>

    <body>
        <header class="header">
            <div class="header__inner">
            <a class="header__logo" href="{{ url('/') }}">
                <img src="{{ asset('images/COACHTECH_logo.png') }}" alt="COACHTECH">
            </a>
            </div>
        </header>

        <main class="main">
            @yield('content')
        </main>
    </body>
</html>