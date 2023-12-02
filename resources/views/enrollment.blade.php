@extends('layouts.main', ['title' => __('app.enrollment.enrollment_form'), 'hideTitle' => true])

@section('content')
    <div class="content mt-3" id="vueApp">
        <enrollment-form :date-id="{{ $dateId }}" :fields="{{ $fields }}" :info="{{ $info }}"
                         gdppr-link="{{ config('constants.gdpr_url') }}"></enrollment-form>
    </div>
@endsection
