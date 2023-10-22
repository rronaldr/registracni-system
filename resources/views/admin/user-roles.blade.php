@extends('layouts.admin.main', ['title' => __('app.user.roles'), 'vue' => true])

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-10 col-sm-8">
            <roles-page :roles="'{{ $roles }}'"></roles-page>

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
@endsection
