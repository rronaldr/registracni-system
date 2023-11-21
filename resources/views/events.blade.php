@extends('layouts.main', ['title' => __('app.event.events-offered')])

@section('content')
    @if(Illuminate\Support\Facades\Session::has('message'))
        <div id="messageAlert" class="alert alert-secondary m-2">
            {{ Illuminate\Support\Facades\Session::get('message') }}
        </div>
    @endif

    <event-list></event-list>
@endsection
