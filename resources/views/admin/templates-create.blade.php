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
                                <label for="name" class="form-label">Název šablony</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" @click="increment()">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Výchozí šablona
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Vlastní šablona
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="html" class="form-label">HTML kód</label>
                                <textarea class="form-control wysiwyg" rows="8" name="html"></textarea>
                                @error('html')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <a href="{{ route('admin.events') }}" class="btn btn-danger mb-2"><i class="fas fa-times"></i> Zrušit</a>
                                <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-save"></i> Uložit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <x-wysiwyg></x-wysiwyg>
@endsection
