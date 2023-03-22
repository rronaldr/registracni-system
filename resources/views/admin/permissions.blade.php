@php
    switch ($id){
        case 1:
            $group = 'Administrátor';
            break;
        case 2:
            $group = 'Organizátor';
            break;
        case 3:
            $group = 'Student';
            break;
        case 4:
            $group = 'Zaměstnanec VŠE';
            break;
    }

@endphp

@extends('layouts.admin.main', ['title' => $group.' - oprávnění'])
@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form accept-charset="utf-8">
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="email" class="text-uppercase"><small>Role a oprávnění</small></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch5">
                            <label class="form-check-label" for="switch5">Vytvářet role</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch6">
                            <label class="form-check-label" for="switch6">Editovat role</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch7">
                            <label class="form-check-label" for="switch7">Smazat role</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch8">
                            <label class="form-check-label" for="switch8">Měnit oprávnění</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="email" class="text-uppercase"><small>Události</small></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch5">
                            <label class="form-check-label" for="switch5">Vytvořit událost</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch6">
                            <label class="form-check-label" for="switch6">Publikovat událost</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch7">
                            <label class="form-check-label" for="switch7">Editovat událost</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch8">
                            <label class="form-check-label" for="switch8">Smazat událost</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch8">
                            <label class="form-check-label" for="switch8">Editovat události ostatních</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch8">
                            <label class="form-check-label" for="switch8">Importovat události ze souboru</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch8">
                            <label class="form-check-label" for="switch8">Exportovat události</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="email" class="text-uppercase"><small>Blacklist</small></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch5">
                            <label class="form-check-label" for="switch5">Vytvořit blacklist</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch6">
                            <label class="form-check-label" for="switch6">Přidat uživatele na blacklist</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch7">
                            <label class="form-check-label" for="switch7">Odebrat uživatele z blacklistu</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch8">
                            <label class="form-check-label" for="switch8">Editovat blacklist</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <label for="email" class="text-uppercase"><small>Přihlášení na událost</small></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch5">
                            <label class="form-check-label" for="switch5">Přihlásit se na událost</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch6">
                            <label class="form-check-label" for="switch6">Zobrazit seznam přihlášených na událost</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch7">
                            <label class="form-check-label" for="switch7">Přidat účastníka na událost</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch8">
                            <label class="form-check-label" for="switch8">Odebrat účastníka z události</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="email" class="text-uppercase"><small>Šablony</small></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch5">
                            <label class="form-check-label" for="switch5">Vytvořit šablonu</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch6">
                            <label class="form-check-label" for="switch6">Editovat šablonu</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="switch7">
                            <label class="form-check-label" for="switch7">Smazat šablonu</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Uložit</button>
            <a href="{{ route('admin.roles') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Zrušit</a>
        </div>
    </div>
@endsection
