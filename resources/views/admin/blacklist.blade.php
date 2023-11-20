@extends('layouts.admin.main', ['title' => __('app.blacklist.global-blacklist'), 'vue' => true])

@section('content')
    <div class="row ">
        <div class="col-lg-9">
            <blacklist-page :blacklist-id="{{ $blacklist->id }}">
                <template v-slot:csrf>
                    {{ csrf_field() }}
                </template>
            </blacklist-page>
        </div>
    </div>
@endsection
