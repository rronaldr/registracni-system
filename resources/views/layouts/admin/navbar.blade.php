<!-- navbar navigation component -->
<nav class="navbar navbar-expand-lg navbar-white bg-white">
    @auth
    <button type="button" id="sidebarCollapse" class="btn btn-light">
        <i class="fas fa-bars"></i><span></span>
    </button>
    @endauth
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav ms-auto">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('admin.login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('admin.register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown mt-0">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-user"></i> <span>{{ Auth::user()->getFullname() }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end mt-0" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}">{{ __('app.auth.logout') }}</a>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<!-- end of navbar navigation -->
