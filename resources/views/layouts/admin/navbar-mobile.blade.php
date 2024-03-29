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
                    @can('event-access')
                    <li class="nav-item nav-item-light">
                        <a href="{{ route('admin.events') }}" class="nav-link ">{{ __('app.event.events') }}</a>
                    </li>
                    @endcan

                    @can('blacklist-access')
                    <li class="nav-item nav-item-light">
                        <a href="{{ route('admin.blacklist') }}"
                           class="nav-link ">{{ __('app.blacklist.blacklist') }}</a>
                    </li>
                    @endcan

                    @can('template-access')
                    <li class="nav-item nav-item-light">
                        <a href="{{ route('admin.templates') }}"
                           class="nav-link ">{{ __('app.templates.templates') }}</a>
                    </li>
                    @endcan

                    @can('user-access')
                    <li class="nav-item nav-item-light">
                        <a href="{{ route('admin.users') }}" class="nav-link ">{{ __('app.user.users') }}</a>
                    </li>
                    @endcan
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item nav-item-light">
                        <a class="nav-link"
                           href="@if(isset(auth()->user()->xname)) {{ route('logout') }}@else {{ route('logout.external') }}@endif"
                        >
                            {{ __('app.auth.logout') }}</a>
                    </li>
                    <li class="nav-item nav-item-light">
                        <a class="nav-link" href="{{ route('events.index') }}">{{ __('app.homepage') }}</a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
