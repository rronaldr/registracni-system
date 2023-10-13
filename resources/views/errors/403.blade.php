@include('layouts.header')

@include('layouts.navbar')

<main class="container mt-2 mb-8" id="vueApp">
    <p>{{ __('app.403-error-message') }}</p>
    <a class="btn btn-primary rounded-0" href="{{ route('events.index') }}">{{ __('app.homepage') }}</a>
</main>

@include('layouts.navbar-mobile')

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
@include('layouts.footer')
