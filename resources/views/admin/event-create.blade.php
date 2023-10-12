@extends('layouts.admin.main', ['title' => __('app.event.create')])

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <event-create-form @if(isset($event)) :event="{{ $event }}" @endif :user="{{ auth()->user() }}">
                <template v-slot:csrf>
                    {{ csrf_field() }}
                </template>
            </event-create-form>
        </div>
    </div>
@endsection
