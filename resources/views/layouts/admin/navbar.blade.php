<body>

<header class="header-fixed-mobile-placeholder">
    <div class="bg-header-xl-dark bg-menu header-fixed-mobile text-white">
        <div class="container px-1 px-sm-2">
            <!-- top navigation -->
            <nav class="navbar-top d-flex align-items-center justify-content-between">
                <a class="nav-logo" href="{{ route('events.index') }}">
                    <img src="{{ asset('storage/dist/img/logo/logo-color-cs-01.svg') }}" alt="VŠE">
                </a>
                <ul class="nav nav-system align-items-stretch ml-auto">
                    <li class="nav-item nav-item-light dropdown">
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
                            <li class="nav-item nav-item-light d-xl-block d-none">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <span class="icon icon-user mr-1"></span>
                                    <span>{{ __('app.auth.login') }}</span>
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item nav-item-light d-xl-block d-none dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="icon icon-user"></i> <span>{{ auth()->user()->getFullname() }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right text-right"
                                 aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                   href="{{ route('enrollment.user', auth()->user()->id) }}">{{ __('app.enrollment.my_enrollments') }}</a>
                                @if(auth()->user()->isExternalUser())
                                    <a class="dropdown-item"
                                       href="{{ route('auth.change-password')}}"
                                    >{{ __('app.auth.change-password') }}</a>
                                @endif
                                <a class="dropdown-item"
                                   href="@if(isset(auth()->user()->xname)) {{ route('logout') }} @else {{ route('logout.external') }}@endif"
                                >{{ __('app.auth.logout') }}</a>
                            </div>
                        </li>
                        @can('admin-access')
                            <li class="nav-item nav-item-light d-xl-block d-none">
                                <a class="nav-link" href="{{ route('events.index') }}">{{ __('app.homepage') }}</a>
                            </li>
                        @endcan
                    @endguest

                    <li class="nav-item nav-item-light d-xl-none">
                        <a class="nav-link text-white" href="#modal-mainmenu" data-toggle="modal">
                            <span class="icon icon-menu"></span>
                            <span class="d-none d-sm-inline-block ml-1">Menu</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="bg-white border-bottom-menu-color d-none d-xl-block">

        <div class="container px-0 px-sm-2">
            <nav class="navbar-main p-0">
                <a class="nav-logo" href="{{ route('events.index') }}">
                    <img src="{{ asset('storage/dist/img/logo/logo-color-cs-01.svg') }}" alt="VŠE">
                </a>

                <ul class="nav nav-main ml-auto d-none d-xl-flex">
                    @can('event-access')
                        <li class="nav-item no-dropdown d-none d-xl-block">
                            <a href="{{ route('admin.events') }}" class="nav-link">{{ __('app.event.events') }}</a>
                        </li>
                    @endcan

                    @can('blacklist-access')
                        <li class="nav-item no-dropdown d-none d-xl-block">
                            <a href="{{ route('admin.blacklist') }}" class="nav-link">{{ __('app.blacklist.blacklist') }}</a>
                        </li>
                    @endcan

                    @can('template-access')
                        <li class="nav-item no-dropdown d-none d-xl-block">
                            <a href="{{ route('admin.templates') }}" class="nav-link">{{ __('app.templates.templates') }}</a>
                        </li>
                    @endcan

                    @can('user-access')
                        <li class="nav-item no-dropdown d-none d-xl-block">
                            <a href="{{ route('admin.users') }}" class="nav-link">{{ __('app.user.users') }}</a>
                        </li>
                    @endcan
                </ul>
            </nav>
        </div>

    </div>

</header>