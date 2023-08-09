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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/admin/admin.js') }}"></script>
@yield('scripts')
</body>

</html>
