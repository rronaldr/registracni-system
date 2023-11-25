@include('layouts.header', ['title' => __('app.enrollment.enrollment_form')])
<body class="bg-gray-500">
<div class="content mt-3" id="vueApp">
    <enrollment-iframe-form :date-id="{{ $dateId }}" :fields="{{ $fields }}" :info="{{ $info }}" :can-enroll="{{ $canEnroll }}"
                     gdppr-link="{{ config('constants.gdpr_url') }}"></enrollment-iframe-form>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
@yield('scripts')
</body>

</html>
