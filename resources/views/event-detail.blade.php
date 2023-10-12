@extends('layouts.main', ['title' => __('app.event.detail')])

@section('content')
    <event-detail :event="{{ $event }}"></event-detail>
@endsection
