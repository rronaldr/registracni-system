@extends('layouts.main', ['title' => __('app.event.events')])

@section('content')
    @if(Illuminate\Support\Facades\Session::has('message'))
        <div id="messageAlert" class="alert alert-success m-2">
            {{ Illuminate\Support\Facades\Session::get('message') }}
        </div>
    @endif

    <event-list :events="{{ $events }}"></event-list>
@endsection
