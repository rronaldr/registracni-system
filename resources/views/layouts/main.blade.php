@include('layouts.header')

@include('layouts.navbar')

<main class="container mt-2 mb-8" id="vueApp">
    <h3 class="text-primary mb-2">@if(isset($hideTitle) && !$hideTitle) {{ $title ?? '' }} @endif</h3>
    @yield('content')
</main>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
@include('layouts.footer')
