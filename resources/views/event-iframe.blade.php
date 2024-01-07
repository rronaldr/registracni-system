@include('layouts.header', ['title' => __('app.date.dates')])
@include('layouts.iframe.navbar')

<div class="content mt-3" id="vueApp">
    <event-iframe :event="{{ $event }}" :has-user="{{ (int) auth()->check() }}"></event-iframe>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
@yield('scripts')

</html>
