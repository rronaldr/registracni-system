@extends('layouts.main', ['title' => __('app.enrollment.my_enrollments')])

@section('content')
    @if(Illuminate\Support\Facades\Session::has('message'))
        <div id="messageAlert" class="alert alert-secondary m-2">
            {{ Illuminate\Support\Facades\Session::get('message') }}
        </div>
    @endif

    <div class="box-body">
        @if($enrollments->isEmpty())
            <p>{{ __('app.enrollment.no-enrollments') }}</p>
        @else
            <table width="100%" class="table table-hover" id="dataTables">
                <thead>
                <tr>
                    <th>{{ __('app.event.event-name') }}</th>
                    <th>{{ __('app.date.date') }}</th>
                    <th>{{ __('app.enrollment.state.title') }}</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($enrollments as $enrollment)
                    <tr>
                        <td><a href="{{ route('events.show', ['id' => $enrollment->date->event->id]) }}"
                               class="link-primary">{{ $enrollment->date->event->name }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($enrollment->date->date_start)->format('j.n.Y H:i') }}
                            - {{ \Carbon\Carbon::parse($enrollment->date->date_end)->format('j.n.Y H:i') }}</td>
                        <td>{{ __('app.enrollment.state.'.$enrollment->state) }}</td>
                        <td>
                            @can('signOff', $enrollment)
                                <form method="POST" action="{{ route('enrollment.user.singoff', $enrollment->id) }}">
                                    @csrf
                                    <button class="btn-link border-0 pe-auto" type="submit">{{ __('app.enrollment.sign-out') }}</button>
                                </form>

                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $enrollments->links() }}
        @endif
    </div>
@endsection
