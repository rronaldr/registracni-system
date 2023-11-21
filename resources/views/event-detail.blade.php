@extends('layouts.main')

@section('content')
    <event-detail :event="{{ $event }}" :has-user="{{ (int) auth()->check() }}"></event-detail>
@endsection
