@extends('layouts.admin.main', ['title' => __('app.event.detail'), 'vue' => true])

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <event-detail-admin :event="{{ $event }}" :last-change-user="'{{ $last_changed }}'" :author="'{{ $event->author->getFullname() }}'" :can-view="{{ (int) $can_view }}">
                <template v-slot:csrf>
                    {{ csrf_field() }}
                </template>
            </event-detail-admin>
        </div>
    </div>
@endsection
