@extends('layouts.main', ['title' => $event->name, 'hideTitle' => true])

@section('content')
    @if(Illuminate\Support\Facades\Session::has('message'))
        <div id="messageAlert" class="alert alert-secondary m-2">
            {{ Illuminate\Support\Facades\Session::get('message') }}
        </div>
    @endif

    <event-detail :event="{{ $event }}" :has-user="{{ (int) auth()->check() }}"></event-detail>
@endsection
