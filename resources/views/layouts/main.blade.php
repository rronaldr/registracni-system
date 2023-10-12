{{--@include('layouts.header')--}}

{{--<body>--}}

{{--<div class="wrapper">--}}
{{--    <div id="body">--}}
{{--        @include('layouts.navbar')--}}
{{--        <main class="container mt-4 mb-8" id="vueApp">--}}
{{--            <div class="container-fluid">--}}
{{--                <div class="page-title">--}}
{{--                    <h3>{{ $title ?? '' }}</h3>--}}
{{--                </div>--}}
{{--                @yield('content')--}}
{{--            </div>--}}
{{--        </main>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@include('layouts.footer')--}}

{{--<script src="{{ asset('js/app.js') }}"></script>--}}
{{--<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>--}}
{{--@yield('scripts')--}}
{{--</body>--}}

{{--</html>--}}



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/dist/img/ico/01/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/dist/img/ico/01/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/dist/img/ico/01/favicon-16x16.png') }}">
    <link rel="mask-icon" href="{{ asset('storage/dist/img/ico/safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="shortcut icon" href="{{ asset('storage/dist/img/ico/01/favicon.ico') }}">
    <meta name="msapplication-config" content="{{ asset('storage/dist/img/ico/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/dist/fonts/fonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/dist/icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/dist/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/dist/css/theme-01.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/fontawesome.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/solid.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/brands.min.css') }}" >
</head>

<body>
<header class="header-main bg-primary bg-cover">
    <div class="header-mobile bg-cover">
        <div class="container">
            <nav class="navbar navbar-main navbar-expand p-0">

                <!-- mainmenu -->
                <ul class="navbar-nav nav-main mr-auto">
                    <li class="nav-item nav-logo nav-caret">
                        <a class="nav-link" href="https://www.vse.cz/">
                            <img src="{{ asset('storage/dist/img/logo/logo-full-cs-white.svg') }}" alt="VŠE">
                        </a>
                    </li>
                    <li class="nav-item bg-primary-550">
                        <a class="nav-link" href="https://registrace-dev.ac.vse.cz/" title="Akademická psychologická poradna"><span class="d-sm-inline d-lg-none">APP</span><span class="d-lg-inline d-none small">Poradna</span></a>
                    </li>
                    <li class="nav-item no-dropdown d-none d-xl-block bg-primary-600">
                        <a href="/consultation/list" class="nav-link">Nabízené konzultace</a>
                    </li>
                </ul>

                <nav class="navbar-top d-none d-xl-flex justify-content-between align-self-start">
                    <ul class="nav ">
                        <li class="nav-item nav-lang dropdown dropdown-primary">
                            <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">CZ</a>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <a href="/" class="dropdown-item active">Česky</a>
                                <a href="/english/" class="dropdown-item">English</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/?do=userLogin-login">
                                <span class="icon icon-user"></span>
                                Přihlásit se...
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- secondary menu -->
                <ul class="nav d-block d-xl-none d-flex text-right align-items-center">

                    <li class="d-xl-none nav-item nav-lang dropdown dropdown-primary mr-sm-1">
                        <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">CZ</a>
                        <div class="dropdown-menu dropdown-menu-right text-right">
                            <a href="/" class="dropdown-item active">Česky</a>
                            <a href="/english/" class="dropdown-item">English</a>
                        </div>							</li>

                    <li class="nav-item d-xl-none">
                        <a class="nav-link text-white" href="#modal-mainmenu" data-toggle="modal">
                            <span class="icon icon-menu"></span>
                            <span class="d-none d-inline-block ml-1">Menu</span>
                        </a>
                    </li>
                </ul>

            </nav>
        </div>

    </div>
</header>

<main class="container mt-4 mb-8" id="vueApp">
    <h3 class="text-primary">{{ $title ?? '' }}</h3>
    @yield('content')
</main>

@include('layouts.footer')

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
