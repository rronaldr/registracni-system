@extends('layouts.admin.main', ['title' => 'Události'])

@section('content')
    <div class="box box-primary">

        <div class="row justify-content-center my-3 mx-1">
            <div class="col-12">
                <a href="{{ route('admin.events.create') }}" class="btn btn-success float-end mx-1"><span class="fas fa-plus"></span> Vytvořit událost</a>
                <a href="{{ route('admin.events.create') }}" class="btn btn-secondary float-end mx-1"><span class="fas fa-file-import"></span> Importovat</a>
            </div>
        </div>

        @if(Illuminate\Support\Facades\Session::has('message'))
            <div id="messageAlert" class="alert alert-success m-2">
                {{ Illuminate\Support\Facades\Session::get('message') }}
            </div>
        @endif

        <div class="box-body">
            <table width="100%" class="table table-hover" id="dataTables">
                <thead>
                    <tr>
                        <th>Název události</th>
                        <th>Stav</th>
                        <th>Termíny</th>
                        <th>Od - Do</th>
                        <th>Účastníci</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td><a href="{{ route('admin.events.edit', ['id' => $event->id]) }}" class="link-primary">{{ $event->name }}</a></td>
                            <td><span class="fa fa-circle text-secondary"></span> {{ __('app.event.status.'.$event->status) }}</td>
                            <td><a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#datesModal" onClick="getDates({{$event->id}})">
                                    Zobrazit termíny ({{ $event->dates_count }})
                                </a></td>
                            <td>
                                {{ \Carbon\Carbon::parse($event->date_start_cache)->format('j.n.Y') }} - {{ \Carbon\Carbon::parse($event->date_end_cache)->format('j.n.Y') }}
                            </td>
                            <td><a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#usersModal" onClick="getUsers({{ $event->id }})">
                                    Zobrazit všechny účastníky
                                </a></td>
                            <td class="text-end">
                                <a href="{{ route('admin.events.edit', ['id' => $event->id]) }}" class="btn btn-outline-primary btn-rounded" title="{{__('app.actions.edit')}}"><i class="fas fa-pen"></i></a>
                                <form class="d-inline" action="{{ route('admin.events.duplicate', ['id' => $event->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" title="{{__('app.actions.duplicate')}}" class="btn btn-outline-info btn-rounded"> <i class="fas fa-copy"></i></button>
                                </form>
                                <form class="d-inline" action="{{ route('admin.events.destroy', ['id' => $event->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="{{__('app.actions.delete')}}" class="btn btn-outline-danger btn-rounded"> <i class="fas fa-trash"></i></button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('app.date.date_start') }}</th>
                                        <th scope="col">{{ __('app.date.date_end') }}</th>
                                        <th scope="col">{{ __('app.date.name') }}</th>
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

            <!-- Custom dates modal start -->
            <div class="modal fade" id="usersModal" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('app.enrollment.list') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('app.user.xname') }}</th>
                                    <th scope="col">{{ __('app.user.email') }}</th>
                                    <th scope="col">{{ __('app.enrollment.enrolled') }}</th>
                                    <th scope="col">{{ __('app.enrollment.c_fields') }}</th>
                                </tr>
                                </thead>
                                <tbody id="usersBody">
                                </tbody>
                            </table>
                        </div>
                        @if(count($events) > 0)
                            <div class="modal-footer">
                                <a type="button" class="btn btn-secondary" href="{{ route('admin.events.users.export', ['id' => $event->id]) }}"><i class="fas fa-file-export"></i> Exportovat</a>
                                <a type="button" class="btn btn-secondary" href="{{ route('admin.events.users.export.email', ['id' => $event->id]) }}"><i class="fas fa-envelope"></i> Exportovat emaily</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Custom dates modal end -->

            <div class="row justify-content-end">
                <div class="float-right">
                    {!! $events->appends(\Request::except('page'))->render() !!}
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function getUsers(eventId) {
            let rows = $('#usersBody')
            rows.empty()
            $.get('events/'+parseInt(eventId)+'/users', function (data) {
                $.each(data, function (key, val) {
                    let tag = []
                    $.each(val.c_fields, function (k, v) {
                        tag.push(k +": "+ v)
                    })
                    rows.append('<tr scope="row">')
                    rows.append('<td>'+ val.xname +'</td>')
                    rows.append('<td>'+ val.email +'</td>')
                    rows.append('<td>'+ formatDate(val.enrolled) +'</td>')
                    rows.append('<td>'+ tag.toString() +'</td>')
                    rows.append('</tr>')
                })
            })
        }

        function getDates(eventId) {
            let rows = $('#datesBody')
            rows.empty()
            $.get('events/'+parseInt(eventId)+'/dates', function (data) {
                $.each(data, function (key, val) {
                    let name = val.name ?? '-'
                    rows.append('<tr scope="row">')
                    rows.append('<td>'+ formatDate(val.date_start) +'</td> - ')
                    rows.append('<td>'+ formatDate(val.date_end)+'</td>')
                    rows.append('<td>'+ name +'</td>')
                    rows.append('</tr>')
                })

            })
        }

        function exportUsers(eventId) {
            $.get('events/'+parseInt(eventId)+'/users/export', function (data) {

            })
        }

        function formatDate(date) {
            var formattedDate = new Date(date);
            return ''+ formattedDate.getDate() +'.'+ formattedDate.getMonth() +'.'+ formattedDate.getFullYear() +' '
                + formattedDate.getHours() +':' + formattedDate.getMinutes()
        }
    </script>
@endsection
