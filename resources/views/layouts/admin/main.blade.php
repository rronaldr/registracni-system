@include('layouts.admin.header')

<body>
<div class="wrapper" id="app">
    @auth
    @include('layouts.admin.sidebar')
    @endauth
    <div id="body" class="active">
        @include('layouts.admin.navbar')
        <div class="content">
            <div class="container-fluid">
                <div class="page-title">
                    <h3>{{ $title ?? '' }}</h3>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/admin/admin.js') }}"></script>
@yield('scripts')
</body>

</html>
