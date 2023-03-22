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
            <a href="forms.html"><i class="fas fa-calendar"></i>Kalendář</a>
        </li>
        <li>
            <a href="tables.html"><i class="fas fa-table"></i>Formuláře</a>
        </li>
        <li>
            <a href="charts.html"><i class="fas fa-list"></i>Blacklist</a>
        </li>
        <li>
            <a href="icons.html"><i class="fas fa-envelope"></i>Šablony</a>
        </li>
        <li>
            <a href="#pagesmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-cogs"></i>Nastavení</a>
            <ul class="collapse list-unstyled" id="pagesmenu">
                <li>
                    <a href="users.html"><i class="fas fa-user-friends"></i>Uživatelé</a>
                </li>
                <li>
                    <a href="{{ route('admin.roles') }}"><i class="fas fa-user-shield"></i>Oprávnění</a>
                </li>
            </ul>
        </li>

    </ul>
</nav>
<!-- end of sidebar component -->
