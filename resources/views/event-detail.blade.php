@extends('layouts.main', ['title' => $event->name, 'hideTitle' => true])

@section('content')
    <event-detail :event="{{ $event }}" :has-user="{{ (int) auth()->check() }}"></event-detail>
@endsection
