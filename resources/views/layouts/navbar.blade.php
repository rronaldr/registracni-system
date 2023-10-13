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
                        <a class="nav-link" href="{{ route('events.index') }}" title="{{ __('app.event.events') }}">
                            <span class="d-sm-inline d-lg-none">{{ __('app.event.events') }}</span>
                            <span class="d-lg-inline d-none small">{{ __('app.event.events') }}</span></a>
                    </li>
                </ul>

                <nav class="navbar-top d-none d-xl-flex justify-content-between align-self-start">
                    <ul class="nav">
                        <li class="nav-item nav-lang dropdown dropdown-secondary">
                            <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                {{ app()->getLocale() }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <a href="{{ route('locale', ['locale' => 'cs']) }}" class="dropdown-item @if(app()->getLocale() === 'cs') active @endif">{{ __('app.cs') }}</a>
                                <a href="{{ route('locale', ['locale' => 'en']) }}" class="dropdown-item @if(app()->getLocale() === 'en') active @endif">{{ __('app.en') }}</a>
                            </div>
                        </li>

                        @guest()
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="icon icon-user"></i>
                                        {{ __('app.auth.login') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="icon icon-user"></i> <span>{{ auth()->user()->getFullname() }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right text-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('enrollment.user', auth()->user()->id) }}">{{ __('app.enrollment.my_enrollments') }}</a>
                                    <a class="dropdown-item"
                                       href="@if(isset(auth()->user()->xname)) {{ route('logout') }}@else {{ route('logout.external') }}@endif"
                                    >{{ __('app.auth.logout') }}</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin') }}">{{ __('app.administration') }}</a>
                            </li>
                        @endguest
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
