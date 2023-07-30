@extends('layouts.admin.main', ['title' => 'Vytvoření šablony'])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            @if(Illuminate\Support\Facades\Session::has('message'))
                <div id="messageAlert" class="alert alert-success m-2">
                    {{ Illuminate\Support\Facades\Session::get('message') }}
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-8">
                    <form action="{{ route('admin.templates.update', ['id' => $template->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">{{ __('app.templates.name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ $template->name}}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="htmlRadio" value="default"
                                        {{ $template->type === 'default' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        {{ __('app.templates.default-template') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="htmlRadio" id="customRadio"
                                           value="custom"
                                        {{ $template->type === 'custom' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        {{ __('app.templates.custom-template') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mb-3">
                            {!! __('app.templates.template-hint') !!}
                        </div>

                        @error('content')
                        <span class="text-danger">{!! $message !!}</span>
                        @enderror

                        <div class="row mb-3">
                            <div class="col">
                                <p>Přednastavené hodnoty</p>
                                <button class="btn btn-light mx-2">Jméno</button>
                                <button class="btn btn-light mx-2">Přijmeni</button>
                                <button class="btn btn-light mx-2">Xname</button>
                                <button class="btn btn-light mx-2">Email</button>
                                <button class="btn btn-light mx-2">Název události</button>
                                <button class="btn btn-light mx-2">Datum termínu</button>
                                <button class="btn btn-light mx-2">Datum registrace</button>
                            </div>
                        </div>

                        <div class="row mb-3" id="editorDiv">
                            <div class="col">
                                <label for="text" class="form-label">{{ __('app.templates.content') }}</label>
                                <textarea class="form-control wysiwyg mb-3" rows="8" name="text">{{ $template->html }}</textarea>
                                @error('text')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="contentDiv">
                            <div class="col">
                                <label for="html" class="form-label">{{ __('app.templates.html') }}</label>
                                <textarea class="form-control" rows="8" name="html">{{ $template->html }}</textarea>
                                @error('html')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="alert alert-info mt-3">
                                    {!! __('app.templates.custom-template-hint') !!}
                                </div>
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

@section('scripts')
    <x-wysiwyg></x-wysiwyg>
    <script type="text/javascript">

        getRadioValue()

        $('input[name="htmlRadio"]').on("click", function () {
            getRadioValue()
        })

        function displayEditor(showEditor) {
            let editorDiv = $('#editorDiv')
            let editor = $('#editorDiv textarea')
            let contentDiv = $('#contentDiv')
            let content = $('#contentDiv textarea')

            if (showEditor) {
                editorDiv.show()
                editor.prop('disabled', false);
                contentDiv.hide()
                content.prop('disabled', true);
            } else {
                editorDiv.hide()
                editor.prop('disabled', true);
                contentDiv.show()
                content.prop('disabled', false);
            }
        }

        function getRadioValue() {
            let radioValue = $('input[name = "htmlRadio"]:checked').val();
            $('#type').val(radioValue);
            let showEditor = radioValue === 'default' ? true : false;
            displayEditor(showEditor)
        }
    </script>
@endsection
