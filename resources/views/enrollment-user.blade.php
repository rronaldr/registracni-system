@extends('layouts.main', ['title' => __('app.enrollment.my_enrollments')])

@section('content')
    <div class="box-body">
        @if(isset($enrollments))
            <p>{{ __('app.enrollment.no-enrollments') }}</p>
        @else
            <table width="100%" class="table table-hover" id="dataTables">
                <thead>
                <tr>
                    <th>{{ __('app.event.event-name') }}</th>
                    <th>{{ __('app.date.date') }}</th>
                    <th>{{ __('app.enrollment.state.title') }}</th>
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
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $enrollments->links() }}
        @endif
    </div>
@endsection
