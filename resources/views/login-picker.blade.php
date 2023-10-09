@extends('layouts.main', ['title' => __('app.auth.login-picker')])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('login.shibboleth') }}" class="btn btn-link my-3 btn-lg btn-block">{{ __('app.auth.shibboleth') }}</a>
            <a href="{{ route('login.graduate') }}" class="btn btn-link my-3 btn-lg btn-block">{{ __('app.auth.graduate') }}</a>
            <a href="{{ route('login.external') }}" class="btn btn-link my-3 btn-lg btn-block">{{ __('app.auth.external') }}</a>
        </div>
    </div>

@endsection
