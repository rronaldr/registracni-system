@extends('layouts.main', ['title' => __('app.auth.change-password')])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="{{ route('auth.change-password.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="old_password"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.auth.current-password') }}</label>
                        <div class="col-md-6">
                            <input id="old_password" type="password"
                                   class="form-control rounded-0 @error('old_password') is-invalid @enderror"
                                   name="old_password" required autocomplete="old-password">

                            @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="new_password"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.auth.new-password') }}</label>
                        <div class="col-md-6">
                            <input id="new_password" type="password"
                                   class="form-control rounded-0 @error('new_password') is-invalid @enderror"
                                   name="new_password" required autocomplete="new_password">

                            @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="new_password_confirmation"
                               class="col-md-4 col-form-label text-md-end">{{ __('app.auth.new-password-confirm') }}</label>
                        <div class="col-md-6">
                            <input id="new_password_confirmation" type="password" class="form-control rounded-0"
                                   name="new_password_confirmation" required autocomplete="new_password_confirmation">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary rounded-0">
                                {{ __('app.actions.save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
