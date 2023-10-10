@extends('layouts.admin.main', ['title' => 'Editace události'])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <roles :roles="'{{ $roles }}'" ></roles>

                    <hr class="line">

                    <h4>Roles and permissons</h4>
                    @foreach($roles as $role)
                        <h5>{{ $role->name }}</h5>
                        <span class="small">
                            @foreach($role->permissions as $permission)
                                <span class="small">{{ $permission->name }} | </span>
                            @endforeach
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
