@extends('layouts.main', ['title' => __('app.app-title')])

@section('content')
    <event-list :events="{{ $events }}"></event-list>
@endsection
