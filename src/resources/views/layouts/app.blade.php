<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="toppage-header">
        <div class="toppage-header__inner">
            <h1 class="toppage-header__logo">
                <form action="/" method="get" class="toppage-header__form">
                    <button type="submit" class="toppage-header__button">
                        <img src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
                    </button>
                </form>
            </h1>

            <div class="toppage-header__search-form">
                @yield('search')
            </div>

            <nav class="toppage-header__nav">
                @yield('nav')
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>