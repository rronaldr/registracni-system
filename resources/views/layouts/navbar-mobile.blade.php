<!-- modal mainmenu -->
<div class="modal modal-mainmenu fade" id="modal-mainmenu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="icon icon-close small mr-1"></span>
                    Menu
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav flex-column">
                    @guest()
                        @if(Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <span class="icon icon-user"></span>
                                    {{ __('app.auth.login') }}
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('enrollment.user', auth()->user()->id) }}">{{ __('app.enrollment.my_enrollments') }}</a>
                        </li>
                        @if(auth()->user()->isExternalUser())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.change-password')}}">{{ __('app.auth.change-password') }}</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link"
                               href="@if(isset(auth()->user()->xname)) {{ route('logout') }}@else {{ route('logout.external') }}@endif">
                                {{ __('app.auth.logout') }}
                            </a>
                        </li>
                        @can('admin-access')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin') }}">{{ __('app.administration') }}</a>
                            </li>
                        @endcan
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</div>
