@extends('layouts.main', ['title' => __('app.auth.login-picker')])

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-3">
            <nav class="nav nav-tabs" id="login-tab" role="tablist">
                <a class="nav-item nav-link active show" id="login-shibboleth-tab" data-toggle="tab"
                   href="#login-shibboleth" role="tab" aria-controls="login-shibboleth"
                   aria-selected="true">{{ __('app.auth.shibboleth') }}</a>
                <a class="nav-item nav-link" id="login-local-tab" data-toggle="tab" href="#login-graduate" role="tab"
                   aria-controls="login-local" aria-selected="false">{{ __('app.auth.graduate-login') }}</a>
                <a class="nav-item nav-link" id="login-local-tab" data-toggle="tab" href="#login-external" role="tab"
                   aria-controls="login-local" aria-selected="false">{{ __('app.auth.external-login') }}</a>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="login-shibboleth" role="tabpanel"
                     aria-labelledby="login-shibboleth-tab">
                    <p class="mt-3 mb-2">{{ __('app.auth.shibboleth-hint') }}</p>
                    <div class="my-2">
                        <a href="{{ route('login.shibboleth') }}" class="btn btn-primary py-1 px-2"
                           role="button">{{ __('app.auth.login') }}</a>
                    </div>
                </div>
                <div class="tab-pane fade show" id="login-graduate" role="tabpanel"
                     aria-labelledby="login-shibboleth-tab">
                    <p class="mt-3 mb-2">{{ __('app.auth.graduate-hint') }}</p>
                    <div class="my-2">
                        <a href="{{ route('login.graduate') }}" class="btn btn-primary py-1 px-2"
                           role="button">{{ __('app.auth.login') }}</a>
                    </div>
                </div>
                <div class="tab-pane fade show " id="login-external" role="tabpanel" aria-labelledby="login-local-tab">
                    <div class="my-2">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-1 col-form-label text-md-end">{{ __('app.email.email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control rounded-0 @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-1 col-form-label text-md-end">{{ __('app.auth.password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control rounded-0 @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('app.auth.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-primary rounded-0">
                                        {{ __('app.auth.login') }}
                                    </button>
                                </div>
                                <div class="col-md-5">
                                    <a class="link-primary text-decoration-underline"
                                       href="{{ route('register.index') }}">{{ __('app.auth.register') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
