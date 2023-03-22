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
                <div class="mb-3">
                    <label for="email" class="form-label text-uppercase"><small>Dashboard</small></label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch1">
                        <label class="form-check-label" for="switch1">Open dashboard page</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="text-uppercase"><small>Users</small></label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch2">
                        <label class="form-check-label" for="switch2">Add User</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch3">
                        <label class="form-check-label" for="switch3">Edit User</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch4">
                        <label class="form-check-label" for="switch4">Delete User</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="text-uppercase"><small>Roles & Permissions</small></label>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch5">
                        <label class="form-check-label" for="switch5">Add Roles</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch6">
                        <label class="form-check-label" for="switch6">Edit Roles</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch7">
                        <label class="form-check-label" for="switch7">Delete Roles</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switch8">
                        <label class="form-check-label" for="switch8">Update Permissions</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button>
            <a href="roles.html" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </div>
@endsection
