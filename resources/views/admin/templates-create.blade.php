@extends('layouts.admin.main', ['title' => 'Vytvoření šablony'])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-8">
                    <form action="{{ route('admin.templates.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">{{ __('app.templates.name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mb-3">
                            {!! __('app.templates.template-hint') !!}
                        </div>

                        @error('content')
                        <span class="text-danger">{!! $message !!}</span>
                        @enderror

                        <div class="row mb-3" id="contentDiv">
                            <div class="col">
                                <label for="html" class="form-label">{{ __('app.templates.html') }}</label>
                                <textarea class="form-control" rows="8" name="html">{{ old('html') }}</textarea>
                                @error('html')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <input type="hidden" name="type" value="default" id="type"/>

                        <div class="line"></div>
                        <br>
                        <div class="mb-3 row justify-content-between">
                            <div class="col">
                                <a href="{{ route('admin.templates') }}" class="btn btn-danger mb-2"><i
                                        class="fas fa-times"></i> {{ __('app.cancel') }}</a>
                            </div>
                            <div class="col text-end">
                                <button type="submit" class="btn btn-primary mb-2"><i
                                        class="fas fa-save"></i> {{ __('app.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
