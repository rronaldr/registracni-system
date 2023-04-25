@extends('layouts.admin.main', ['title' => 'Globální blacklist'])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-8">
                    <form action="{{ route('admin.blacklist.update', ['blacklist_id' => 1]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                <h5>
                                                    Uživatelé na blacklistu
                                                    <i class="fas fa-info-circle"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="Zde je seznam uživatelů, kteří jsou na globálním blacklistu"></i>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if (!isset($blacklist))
                                        <p class="card-text">Zatím nejsou žádní uživatelé na blacklistu</p>
                                        @else
                                            <table class="table table table-striped">
                                                <thead>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>Blokace do</td>
                                                    <td>Důvod blokace</td>
                                                    <td></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($blacklist as $row)
                                                    <tr>
                                                        <td>{{ $row->email }}</td>
                                                        @if (isset($row->blocked_until))
                                                        <td>{{ \Carbon\Carbon::parseFromLocale($row->blocked_until)->format('d.m.Y H:i') }}</td>
                                                        @else
                                                            <td>{{ '-' }}</td>
                                                        @endif
                                                        <td>{{ $row->blocked_reason ?? '-'}}</td>
                                                        <td>
                                                            <button type="submit" title="Odstranit" class="btn btn-outline-danger btn-rounded"> <i class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line"></div><br>

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

@endsection
