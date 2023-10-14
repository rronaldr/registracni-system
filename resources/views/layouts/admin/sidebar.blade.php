<!-- sidebar navigation component -->
<nav id="sidebar" class="active">
    <div class="sidebar-header">
        <img src="{{ asset('storage/img/vse.png') }}" alt="VŠE logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
        <li>
            <a href="{{ route('admin.events') }}"><i class="fas fa-home"></i>{{ __('app.event.events') }}</a>
        </li>
        <li>
            <a href="{{ route('admin.blacklist') }}"><i class="fas fa-list"></i>{{ __('app.blacklist.blacklist') }}</a>
        </li>
        <li>
            <a href="{{ route('admin.templates') }}"><i class="fas fa-envelope"></i>{{ __('app.templates.templates') }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users') }}"><i class="fas fa-users"></i>{{ __('app.user.users') }}</a>
        </li>
        <li>
            <a href="{{ route('events.index') }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>{{ __('app.app') }}
            </a>
        </li>

    </ul>
</nav>
<!-- end of sidebar component -->
