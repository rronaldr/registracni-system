@extends('layouts.main', ['title' => __('app.auth.register')])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="first_name"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.user.first_name') }}</label>
                        <div class="col-md-6">
                            <input id="first_name" type="text"
                                   class="form-control rounded-0 @error('first_name') is-invalid @enderror"
                                   name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name"
                                   autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="last_name"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.user.last_name') }}</label>
                        <div class="col-md-6">
                            <input id="last_name" type="text"
                                   class="form-control rounded-0 @error('last_name') is-invalid @enderror"
                                   name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name"
                                   autofocus>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.email.email') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email"
                                   class="form-control rounded-0 @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.auth.password') }}</label>
                        <div class="col-md-6">
                            <input id="password" type="password"
                                   class="form-control rounded-0 @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.auth.password-confirm') }}</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control rounded-0"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary rounded-0">
                                {{ __('app.auth.register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
