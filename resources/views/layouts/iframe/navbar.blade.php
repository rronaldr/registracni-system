<body class="bg-gray-500">
<header class="bg-header-xl-dark bg-menu header-fixed-mobile text-white">
    <div class="container">
        <nav class="navbar-top d-flex align-items-center justify-content-between">
            <ul class="nav nav-system align-items-stretch ml-auto">
                @guest()
                    @if (Route::has('login'))
                        <li class="nav-item nav-item-light">
                            <a class="nav-link" target="_blank" href="{{ route('iframe.login.index') }}">
                                <i class="icon icon-user"></i>
                                {{ __('app.auth.login') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item nav-item-light">
                        <p class="nav-link text-white">
                            <i class="icon icon-user"></i> <span>{{ auth()->user()->getFullname() }}</span>
                        </p>
                    </li>
                    <li class="nav-item nav-item-light">
                        <a class="nav-link"
                           href="@if(isset(auth()->user()->xname)) {{ route('iframe.logout') }} @else {{ route('iframe.logout') }}@endif"
                        >{{ __('app.auth.logout') }}</a>
                    </li>
                @endguest
            </ul>
        </nav>
    </div>
</header>