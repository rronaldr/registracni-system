@extends('layouts.admin.main', ['title' => __('app.event.edit')])

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <event-edit-form :author="'{{ $event->author->getFullname() }}'"
                             :last-change-user="'{{ $last_changed }}'"
                             :user="{{ auth()->user() }}"
                             :event="{{ $event }}">
                <template v-slot:csrf>
                    {{ csrf_field() }}
                </template>
            </event-edit-form>
        </div>
    </div>
@endsection
