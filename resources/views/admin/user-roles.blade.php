@extends('layouts.admin.main', ['title' => __('app.user.roles'), 'vue' => true])

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-10 col-sm-8">
            <roles-page :roles="'{{ $roles }}'"></roles-page>
        </div>
    </div>
@endsection
