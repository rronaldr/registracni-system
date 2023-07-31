@include('layouts.header')
<body class="bg-gray-500">
    <div class="content mt-3" id="vueApp">
        <enrollment fields="{{ $fields->c_fields }}"></enrollment>
    </div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
@yield('scripts')
</body>

</html>
