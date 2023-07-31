@extends('layouts.main', ['title' => $event->name])

@section('content')
    <event-detail :event="{{ $event }}"></event-detail>
@endsection
