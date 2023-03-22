@extends('layouts.admin.main', ['title' => 'Vytvoření události'])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-8">
                    <form action="{{ route('admin.events.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">Název události</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="description" class="form-label">Popis události</label>
                                <textarea class="form-control wysiwyg" name="description">
                                    {{ old('description') }}
                                </textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="line"></div><br>

                        <div class="row mb-3">
                            <label class="col-sm-2">Typ události</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="type" type="radio" id="single" value="1">
                                    <label class="form-check-label" for="single">Jednodenní</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="type" type="radio" id="multi" value="2">
                                    <label class="form-check-label" for="multi">Vícedenní</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="type" type="radio" id="series" value="3">
                                    <label class="form-check-label" for="series">Série událostí</label>
                                </div>
                                @error('type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2">Blacklist pro událost<br></label>
                            <div class="col-sm-10">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Zapnout blacklist</label>
                                </div>
                                <div class="select col-5">
                                    <select name="blacklist" class="form-select" disabled>
                                        <option value="">Kariérní poradenství</option>
                                        <option value="">option 2</option>
                                        <option value="">option 3</option>
                                        <option value="">option 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="line"></div><br>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                <h5>
                                                    Termíny <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Zde vytvořte termíny pro událost"></i>
                                                </h5>
                                            </div>
                                            <div class="col">
                                                <a class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#datesModal">
                                                    <i class="fas fa-plus"></i> Přidat termín
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Zatím nemáte vytvořené žádné termíny k akci</p>
                                    </div>
                                </div>
                                <!-- Custom dates modal start -->
                                <div class="modal fade" id="datesModal" role="dialog" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Přidat nový termín</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
{{--                                                <form action="#" accept-charset="utf-8">--}}
                                                    <div class="row g-2 mb-3">
                                                        <label for="room" class="form-label">Místnost</label>
                                                        <input type="text" name="room" class="form-control">
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col">
                                                            <label for="od" class="form-label">Termín od</label>
                                                            <input type="text" name="od" class="form-control datepicker-here"
                                                                   data-language="cs" aria-describedby="datepicker">
                                                        </div>
                                                        <div class="col">
                                                            <label for="do" class="form-label">Termín do</label>
                                                            <input type="text" name="do" class="form-control datepicker-here"
                                                                   data-language="cs" aria-describedby="datepicker">
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col">
                                                            <label for="od" class="form-label">Přihlašování od</label>
                                                            <input type="text" name="od" class="form-control datepicker-here"
                                                                   data-language="cs" aria-describedby="datepicker" placeholder="Vyberte datum">
                                                        </div>
                                                        <div class="col">
                                                            <label for="do" class="form-label">Přihlašování do</label>
                                                            <input type="text" name="do" class="form-control datepicker-here"
                                                                   data-language="cs" aria-describedby="datepicker" placeholder="Vyberte datum">
                                                        </div>
                                                        <div class="col">
                                                            <label for="do" class="form-label">Odhlašování do</label>
                                                            <input type="text" name="do" class="form-control datepicker-here"
                                                                   data-language="cs" aria-describedby="datepicker" placeholder="Vyberte datum">
                                                        </div>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Uložit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Custom dates modal end -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                <h5>
                                                    Vlastní pole  <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Zde můžete přidat vlastní pole, které účastník vyplní v příhlášce na událost"></i>
                                                </h5>
                                            </div>
                                            <div class="col">
                                                <a class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#fieldsModal">
                                                    <span class="fas fa-plus"></span> Přidat pole
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"></p>
                                    </div>
                                </div>
                                <!-- Custom fields modal start -->
                                <div class="modal fade" id="fieldsModal" role="dialog" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Přidat nové pole</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
{{--                                                <form action="#"  accept-charset="utf-8">--}}
                                                    <div class="mb-3">
                                                        <label for="tag" class="form-label">Název pole</label>
                                                        </br><small class="form-text">Název pole ohraničtě pomocí hranatých závorek<code>[ ]</code></small>
                                                        <input type="text" name="tag" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="checkbox" class="form-label">Povinné?</label>
                                                        <input class="form-check-input" type="checkbox" value="" id="check2">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="input" class="form-label">Typ pole</label>
                                                        <select name="input" class="form-select">
                                                            <option value="text">Text</option>
                                                            <option value="number">Číslo</option>
                                                            <option value="checkbox">Checkbox</option>
                                                            <option value="radio">Radio</option>
                                                            <option value="email">Email</option>
                                                            <option value="tel">Telefon</option>
                                                            <option value="date">Datum</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="input" class="form-label">Hodnoty</label>
                                                        </br><small class="form-text">Jednotlivé hodnoty oddělte pomocí znaku <code>,</code></small>
                                                        <textarea name="value" class="form-control"></textarea>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Uložit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Custom fields modal end -->
                            </div>
                        </div>

                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <a href="{{ route('admin.events.index') }}" class="btn btn-danger mb-2"><i class="fas fa-times"></i> Zrušit</a>
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
    <script src="{{ asset('/vendor/airdatepicker/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('/vendor/airdatepicker/js/i18n/datepicker.cs.js') }}"></script>
    <x-wysiwyg></x-wysiwyg>
@endsection
