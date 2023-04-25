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
                                <label for="subtitle" class="form-label">Podtitul události</label>
                                <input type="text" class="form-control" name="subtitle" value="{{ old('subtitle') }}">
                                @error('subtitle')
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
                                    <label class="form-check-label" for="single">
                                        Opakovaná událost či části, kterých se lze zůčastnit samostatně
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="type" type="radio" id="series" value="3">
                                    <label class="form-check-label" for="series">
                                        Navazující část jedné události
                                    </label>
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
                                    <label class="col-sm-2 d-inline">Zapnout systémový
                                        <a class="link-primary"
                                           href="{{route('admin.blacklist')}}" target="_blank">blacklist</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="blacklist" class="form-label">Přidat uživatele na blacklist</label>
                                <a class="link-secondary float-end" data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <i class="fas fa-info-circle"></i> Zobrazit nápovědu
                                </a>
                                <textarea class="form-control" name="blacklist" rows="8"></textarea>
                                @error('blacklist')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Custom blacklist modal start -->
                        <div class="modal fade" id="infoModal" role="dialog" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Jak přidat uživatele na blacklist?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p>
                                            Pro každého uživatele přidejte hodnoty <br>ve formátu <b>email:datum:"důvod",</b>
                                            <br>každý záznam ukončete pomocí čárky.
                                            <br> Například: <br><b>jan.novak@vse.cz:1.5.2030 9:15:"Váš důvod",</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Custom blacklist modal end -->

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
                                                <div class="row g-2 mb-3">
                                                    <div class="col">
                                                        <label for="name" class="form-label">Název</label>
                                                        <input type="text" name="name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label for="room" class="form-label">Místnost</label>
                                                        <input type="text" name="room" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <label for="capacity" class="form-label">Kapacita</label>
                                                        <input type="number" name="capacity" class="form-control">
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <label for="limited_capacity" class="form-label">Neomezená kapacita</label>
                                                        <input type="checkbox" name="limited_capacity" class="form-check-input">
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <label for="substitutes" class="form-label">Povolit náhradníky</label>
                                                        <input type="checkbox" name="substitutes" class="form-check-input">
                                                    </div>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-8">
                                                        <label for="od" class="form-label">Začátek</label>
                                                        <input type="date" name="date_from" class="form-control datepicker-here"
                                                               data-language="cs" aria-describedby="datepicker">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="do" class="form-label">Čas žačátku</label>
                                                        <input type="time" name="time_from" class="form-control datepicker-here"
                                                               data-language="cs" aria-describedby="datepicker">
                                                    </div>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-8">
                                                        <label for="od" class="form-label">Konec</label>
                                                        <input type="date" name="date_to" class="form-control "
                                                               data-language="cs">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="do" class="form-label">Čas konce</label>
                                                        <input type="time" name="time_to" class="form-control "
                                                               data-language="cs">
                                                    </div>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col">
                                                        <label for="od" class="form-label">Přihlašování od</label>
                                                        <input type="datetime-local" name="od" class="form-control"
                                                               data-language="cs" placeholder="Vyberte datum">
                                                    </div>
                                                    <div class="col">
                                                        <label for="do" class="form-label">Přihlašování do</label>
                                                        <input type="datetime-local" name="do" class="form-control"
                                                               data-language="cs" placeholder="Vyberte datum">
                                                    </div>
                                                    <div class="col">
                                                        <label for="do" class="form-label">Odhlašování do</label>
                                                        <input type="datetime-local" name="do" class="form-control"
                                                               data-language="cs" placeholder="Vyberte datum">
                                                    </div>
                                                </div>
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
                                                <div class="mb-3">
                                                    <label for="tag" class="form-label">Název pole</label>
                                                    <input type="text" name="tag" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="checkbox" class="form-label">Povinné</label>
                                                    <input class="form-check-input" type="checkbox" value="" id="check2">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="input" class="form-label">Typ pole</label>
                                                    <select name="input" class="form-select">
                                                        <option value="text">Text</option>
                                                        <option value="number">Číslo</option>
                                                        <option value="checkbox">Checkbox</option>
                                                        <option value="select">Select</option>
                                                        <option value="file">Soubor</option>
                                                        <option value="email">Email</option>
                                                        <option value="tel">Telefon</option>
                                                        <option value="date">Datum</option>
                                                        <option value="url">URL</option>
                                                        <option value="textarea">Textarea</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="input" class="form-label">Hodnoty</label>
                                                    </br><small class="form-text">Jednotlivé hodnoty oddělte pomocí znaku <code>,</code></small>
                                                    <textarea name="value" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="default_value" class="form-label">Výchozí hodnota</label>
                                                    <input type="text" name="default_value" class="form-control">
                                                </div>
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
