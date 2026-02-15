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
        @php
            $isAuthPage = request()->routeIs('login', 'register', 'verification.notice');
        @endphp

        <header class="header">
            <div class="header__inner">
                <a class="header__logo" href="{{ url('/') }}">
                    <img src="{{ asset('images/COACHTECH_logo.png') }}" alt="COACHTECH">
                </a>

                @unless ($isAuthPage)
                    <!-- 商品検索バー -->
                    <form class="header__search" action="{{ url('/') }}" method="GET">
                        <input type="hidden" name="tab" value="all">
                        <input class="header__searchInput" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    </form>

                    <nav class="header__nav">
                        <!-- ログイン、ログアウトボタン切替 -->
                        <div class="header__navItem">
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <!-- <button type="submit" class="header__navButton header__navText">
                                        ログアウト
                                    </button> -->
                                    <a href="#" class="header__navButton" onclick="event.preventDefault(); this.closest('form').submit();">
                                        ログアウト
                                    </a>
                                </form>
                            @else
                                <a href="{{ route('login', ['redirect' => request()->fullUrl()]) }}" class="header__navButton">
                                    ログイン
                                </a>
                            @endauth
                        </div>

                        <!-- マイページ、出品ボタン -->
                        <div class="header__navItem">
                            <a href="{{ url('/mypage') }}" class="header__navButton">
                                マイページ
                            </a>
                        </div>
                        <div class="header__navItem">
                            <a href="{{ url('/sell') }}" class="header__sellButton">
                                出品
                            </a>
                        </div>
                    </nav>
                @endunless

            </div>
        </header>

        <main class="main">
            @yield('content')
        </main>

        @yield('js')
    </body>
</html>