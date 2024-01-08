<body class="bg-gray-500">
<header class="header-main bg-primary bg-cover">
    <div class="container">
        <nav class="navbar-top d-xl-flex justify-content-between align-self-start">
            <ul class="nav">
                @guest()
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="{{ route('iframe.login.index') }}">
                                <i class="icon icon-user"></i>
                                {{ __('app.auth.login') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <p class="text-white">
                            <i class="icon icon-user"></i> <span>{{ auth()->user()->getFullname() }}</span>
                        </p>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="@if(isset(auth()->user()->xname)) {{ route('logout') }} @else {{ route('logout.external') }}@endif"
                        >{{ __('app.auth.logout') }}</a>
                    </li>
                @endguest
            </ul>
        </nav>
    </div>
</header>