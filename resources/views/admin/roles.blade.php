@extends('layouts.admin.main', ['title' => 'Uživatelské role'])

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <table width="100%" class="table table-hover" id="dataTables-example">
                <thead>
                <tr>
                    <th>Název role</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Administrátor</td>
                    <td>Aktivní</td>
                    <td class="text-end">
                        <a href="{{ route('admin.permissions', ['id' => 1]) }}" class="btn btn-outline-secondary btn-rounded"><i class="fas fa-toggle-on"></i></a>
                        <a href="" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                        <a href="" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>Organizátor</td>
                    <td>Aktivní</td>
                    <td class="text-end">
                        <a href="{{ route('admin.permissions', ['id' => 2]) }}" class="btn btn-outline-secondary btn-rounded"><i class="fas fa-toggle-on"></i></a>
                        <a href="" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                        <a href="" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>Zaměstnanec VŠE</td>
                    <td>Neaktivní</td>
                    <td class="text-end">
                        <a href="{{ route('admin.permissions', ['id' => 3]) }}" class="btn btn-outline-secondary btn-rounded"><i class="fas fa-toggle-on"></i></a>
                        <a href="" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                        <a href="" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>Student</td>
                    <td>Active</td>
                    <td class="text-end">
                        <a href="{{ route('admin.permissions', ['id' => 4]) }}" class="btn btn-outline-secondary btn-rounded"><i class="fas fa-toggle-on"></i></a>
                        <a href="" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                        <a href="" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/initiate-datatables.js') }}"></script>
@endsection

