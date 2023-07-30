@include('layouts.header')

<body>

<div class="wrapper">
    <div id="body">
        @include('layouts.navbar')
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
@include('layouts.footer')

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
@yield('scripts')
</body>

</html>
