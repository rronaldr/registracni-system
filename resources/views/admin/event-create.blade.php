@extends('layouts.admin.main', ['title' => 'Vytvoření události'])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-8">
                    <event-create-form :user="{{ auth()->user() }}">
                        <template v-slot:csrf>
                            {{ csrf_field() }}
                        </template>
                    </event-create-form>
                </div>
            </div>
        </div>
    </div>
@endsection
