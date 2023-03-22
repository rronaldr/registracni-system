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
            <table width="100%" class="table table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>Název události</th>
                        <th>Stav</th>
                        <th>Počet termínů</th>
                        <th>Termíny</th>
                        <th>Účastníci</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><a href="#" class="link-primary">Událost 1</a></td>
                        <td><span class="fa fa-circle text-success"></span> Publikováno</td>
                        <td class="text-start">5</td>
                        <td>
                            21.8.2023 9:00-13:00
                            <p>
                                21.8.2023 9:00-13:00 RB101
                            </p>
                        </td>
                        <td><a href="#" class="link-primary">Zobrazit seznam (20)</a></td>
                        <td class="text-end">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-outline-primary btn-rounded" title="Editovat"><i class="fas fa-pen"></i></a>
                            <a href="" class="btn btn-outline-info btn-rounded" title="Duplikovat"><i class="fas fa-copy"></i></a>
                            <a href="" class="btn btn-outline-danger btn-rounded" title="Smazat"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @foreach($events as $event)
                        <tr>
                            <td><a href="#" class="link-primary">{{ $event->name }}</a></td>
                            <td><span class="fa fa-circle text-secondary"></span> {{ __('app.event.status.'.$event->status) }}</td>
                            <td class="text-start">5</td>
                            <td>
                                21.8.2023 9:00-13:00
                                <p>
                                    21.8.2023 9:00-13:00 RB101
                                </p>
                            </td>
                            <td><a href="#" class="link-primary">Zobrazit seznam (20)</a></td>
                            <td class="text-end">
                                <a href="{{ route('admin.events.create') }}" class="btn btn-outline-primary btn-rounded" title="Editovat"><i class="fas fa-pen"></i></a>
                                <form class="d-inline" action="{{ route('admin.events.duplicate', ['event' => $event]) }}" method="post">
                                    @csrf
                                    <button type="submit" title="Odstranit" class="btn btn-outline-info btn-rounded"> <i class="fas fa-copy"></i></button>
                                </form>
                                <form class="d-inline" action="{{ route('admin.events.destroy', ['event' => $event]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Odstranit" class="btn btn-outline-danger btn-rounded"> <i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row justify-content-end">
                <div class="float-right">
                    {!! $events->appends(\Request::except('page'))->render() !!}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/initiate-datatables.js') }}"></script>
@endsection
