@include('layouts.admin.header')

<body>
<div class="wrapper">
    @auth
    @include('layouts.admin.sidebar')
    @endauth
    <div id="body" class="active">
        @include('layouts.admin.navbar')
        <div class="content" id="vueApp">
            <div class="container-fluid">
                <div class="page-title">
                    <h3>{{ $title ?? '' }}</h3>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/admin/admin.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
@yield('scripts')
</body>

</html>
