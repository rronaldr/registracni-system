@extends('layouts.admin.main', ['title' => __('app.event.events')])

@section('content')
    <div class="box box-primary">
        <div class="row justify-content-center my-1">
            <div class="col-12">
                <a href="{{ route('admin.events.create') }}" class="btn btn-outline-success rounded-0 float-right mx-1"><span
                            class="fas fa-plus"></span> {{ __('app.event.create') }}</a>
                <a href="#"
                   data-toggle="modal" data-target="#importModal"
                   class="btn btn-outline-secondary rounded-0 float-right mx-1"><span
                            class="fas fa-file-import"></span> {{ __('app.event.import') }}</a>
            </div>
        </div>

        @if(Illuminate\Support\Facades\Session::has('message'))
            <div id="messageAlert" class="alert alert-secondary m-2">
                {{ Illuminate\Support\Facades\Session::get('message') }}
            </div>
        @endif

        <div class="box-body">
            <table width="100%" class="table table-hover" id="dataTables">
                <thead>
                <tr>
                    <th>{{ __('app.event.name') }}</th>
                    <th>{{ __('app.event.status-label') }}</th>
                    <th>{{ __('app.date.dates') }}</th>
                    <th>{{ __('app.date.from-to') }}</th>
                    <th>{{ __('app.event.participants') }}</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td><a href="{{ route('admin.events.edit', ['id' => $event->id]) }}"
                               class="link-primary">{{ $event->name }}</a></td>
                        <td>
                            <span class="fa fa-circle @if($event->status === 1) text-success @else text-secondary @endif"></span> {{ __('app.event.status.'.$event->status) }}
                        </td>
                        <td><a href="#" class="link-primary" data-toggle="modal" data-target="#datesModal"
                               onClick="getDates({{$event->id}})">
                                {{ __('app.event.show-dates') }} ({{ $event->dates_count }})
                            </a>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($event->date_start_cache)->format('j.n.Y') }}
                            - {{ \Carbon\Carbon::parse($event->date_end_cache)->format('j.n.Y') }}
                        </td>
                        <td><a href="#" class="link-primary" data-toggle="modal" data-target="#usersModal"
                               onClick="getUsers({{ $event->id }})">
                                {{ __('app.event.show-all-participants') }}
                            </a>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.events.edit', ['id' => $event->id]) }}" class="text-primary px-1"
                               title="{{__('app.actions.edit')}}"><i class="fas fa-pen"></i></a>
                            <a href="{{ route('admin.events.duplicate', ['id' => $event->id]) }}" class="text-info px-1"
                               title="{{__('app.actions.duplicate')}}"><i class="fas fa-copy"></i></a>
                            <form class="d-inline" action="{{ route('admin.events.destroy', ['id' => $event->id]) }}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="{{__('app.actions.delete')}}"
                                        class="btn-link border-0 text-danger px-1"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Custom dates modal start -->
            <div class="modal fade" id="datesModal" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('app.date.list') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-start">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('app.date.date_start') }}</th>
                                    <th scope="col">{{ __('app.date.date_end') }}</th>
                                    <th scope="col">{{ __('app.date.capacity') }}</th>
                                </tr>
                                </thead>
                                <tbody id="datesBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Custom dates modal end -->

            <!-- Custom users modal start -->
            <div class="modal fade" id="usersModal" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('app.enrollment.list') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-start">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('app.user.xname') }}</th>
                                        <th scope="col">{{ __('app.user.email') }}</th>
                                        <th scope="col">{{ __('app.enrollment.enrolled') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="usersBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($events->isNotEmpty())
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary rounded-0" id="export_users"
                                   href="{{ route('admin.events.users.export', ['id' => 1]) }}"><i
                                            class="fas fa-file-export"></i> {{ __('app.event.export') }}</a>
                                <a type="button" class="btn btn-secondary rounded-0" id="export_emails"
                                   href="{{ route('admin.events.users.export.email', ['id' => 1]) }}"><i
                                            class="fas fa-envelope"></i> {{ __('app.event.export-emails') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Custom users modal end -->

            <!-- Import file upload modal start -->
            <div class="modal fade" id="importModal" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('app.event.import-file') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.events.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body text-start">
                                <input type="file" name="event_import">

                                <p class="mt-2">
                                    {{ __('app.event.import-template-hint') }}
                                    <a href="{{ route('admin.events.import.template') }}">{{ __('app.event.import-template-download') }}</a>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn rounded-0 btn-secondary"><i
                                            class="fas fa-file-import"></i> {{ __('app.event.import') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Import file upload modal end -->

            {{ $events->links() }}
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
        function getUsers(eventId) {
            let rows = $('#usersBody')
            let i = 1
            rows.empty()
            $.get('events/' + parseInt(eventId) + '/users', function (data) {
                if (data.length === 0) {
                    rows.append('<tr class="test">')
                    rows.append('<td colspan="4">No records</td>')
                    rows.append('</tr>')
                }

                let currentUrl = window.location.origin
                $('#export_users').attr('href', currentUrl+'/admin/events/'+ eventId +'/users/export')
                $('#export_emails').attr('href', currentUrl+'/admin/events/'+ eventId +'/users/export-email')

                $.each(data, function (key, val) {
                    rows.append('<tr id="user' + i + '"></tr>')
                    let row = $('#user' + i)
                    row.append('<td>' + val.xname + '</td>')
                    row.append('<td>' + val.email + '</td>')
                    row.append('<td>' + formatDate(val.enrolled) + '</td>')
                    i++
                })
            })
        }

        function getDates(eventId) {
            let rows = $('#datesBody')
            let i = 1
            rows.empty()
            $.get('dates/' + parseInt(eventId) + '/event', function (data) {
                let dates = data.data

                $.each(dates, function (key, val) {
                    console.log(val)
                    let capacity = val.capacity === -1 ? '∞' : val.capacity

                    rows.append('<tr id="date' + i + '"></tr>')
                    let row = $('#date' + i)
                    row.append('<td>' + formatDate(val.date_start) + '</td>')
                    row.append('<td>' + formatDate(val.date_end) + '</td>')
                    row.append('<td>' + capacity + '</td>')
                    i++
                })

            })
        }

        function exportUsers(eventId) {
            $.get('events/' + parseInt(eventId) + '/users/export', function (data) {

            })
        }

        function formatDate(date) {
            if (date) {
                return moment(String(date)).format('DD.MM.YYYY HH:mm')
            }
        }
    </script>
@endsection
