@extends('layouts.admin.main', ['title' => __('app.templates.template-create-title')])

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <form action="{{ route('admin.templates.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">{{ __('app.templates.name') }}</label>
                        <input type="text" class="form-control rounded-0" name="name" value="{{ old('name') }}">
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
                        <textarea class="form-control rounded-0" rows="8" name="html">{{ old('html') }}</textarea>
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
                        <a href="{{ route('admin.templates') }}" class="btn btn-outline-danger rounded-0 mb-2"><i
                                    class="fas fa-times"></i> {{ __('app.actions.cancel') }}</a>
                    </div>
                    <div class="col text-right">
                        <button type="submit" class="btn btn-outline-primary rounded-0 mb-2"><i
                                    class="fas fa-save"></i> {{ __('app.actions.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
