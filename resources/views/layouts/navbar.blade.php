<!-- navbar navigation component -->
<nav class="navbar navbar-expand-lg navbar-white bg-white">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav ms-auto">
            <!-- Authentication Links -->
            <li class="nav-item nav-lang dropdown dropdown-primary">
                <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">{{ __(sprintf('app.%s', app()->getLocale())) }}</a>
                <div class="dropdown-menu dropdown-menu-right text-right">
                    <a href="{{ route('locale', ['locale' => 'cs']) }}" class="dropdown-item @if(app()->getLocale() === 'cs') active @endif">{{ __('app.cs') }}</a>
                    <a href="{{ route('locale', ['locale' => 'en']) }}" class="dropdown-item @if(app()->getLocale() === 'en') active @endif">{{ __('app.en') }}</a>
                </div>
            </li>
            @guest
                @if (Route::has('admin.login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-user"></i> <span>{{ Auth::user()->getFullname() }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<!-- end of navbar navigation -->
