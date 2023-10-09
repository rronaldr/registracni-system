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

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
@yield('scripts')
</body>

</html>
