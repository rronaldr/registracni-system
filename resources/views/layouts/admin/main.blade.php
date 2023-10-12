@include('layouts.header')

@include('layouts.admin.navbar')

<main class="container mt-2 mb-8" id="vueApp">
    <h3 class="text-primary mb-2">{{ $title ?? '' }}</h3>
    @yield('content')
</main>

@include('layouts.admin.navbar-mobile')

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('storage/dist/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>

@if(app()->getLocale() === 'cs')
    <script src="{{ asset('js/datatables-cs.js') }}"></script>
@else
    <script src="{{ asset('js/datatables-en.js') }}"></script>
@endif
@yield('scripts')
@include('layouts.footer')
