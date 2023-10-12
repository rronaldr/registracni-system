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
                    <li class="nav-item">
                        <a href="/consultation/list" class="nav-link ">Nabízené konzultace</a>
                    </li>
                </ul>
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
                            <a class="nav-link" href="{{ route('admin') }}">{{ __('app.enrollment.my_enrollments') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="@if(isset(auth()->user()->xname)) {{ route('logout') }}@else {{ route('logout.external') }}@endif">{{ __('app.auth.logout') }}"
                                >{{ __('app.auth.logout') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}">{{ __('app.administration') }}</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</div>
