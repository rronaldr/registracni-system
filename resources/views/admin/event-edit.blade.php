@extends('layouts.admin.main', ['title' => 'Editace události'])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <event-edit-form :user="{{ auth()->user() }}" :event-data="{{ $event }}">
                        <template v-slot:csrf>
                            {{ csrf_field() }}
                        </template>
                    </event-edit-form>
                </div>
            </div>
        </div>
    </div>
@endsection
