<!-- sidebar navigation component -->
<nav id="sidebar" class="active">
    <div class="sidebar-header">
        <img src="{{ asset('storage/img/vse.png') }}" alt="VŠE logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
        <li>
            <a href="{{ route('admin.events') }}"><i class="fas fa-home"></i>Události</a>
        </li>
        <li>
            <a href="{{ route('admin.blacklist') }}"><i class="fas fa-list"></i>Blacklist</a>
        </li>
        <li>
            <a href="{{ route('admin.templates') }}"><i class="fas fa-envelope"></i>Šablony</a>
        </li>
        <li>
            <a href="https://kalendar.vse.cz/" target="_blank">
                <i class="fas fa-external-link-alt"></i>Kalendář
            </a>
        </li>

    </ul>
</nav>
<!-- end of sidebar component -->
