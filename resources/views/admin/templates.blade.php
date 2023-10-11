@extends('layouts.admin.main', ['title' => __('app.templates.templates')])

@section('content')
    <div class="row justify-content-end align-content-end">
        <div class="col-12 my-2 ">
            <a href="{{ route('admin.templates.approvals') }}" class="btn btn-primary m-2 float-end">{{ __('app.templates.for-approval') }}</a>
            <a href="{{ route('admin.templates.author', ['user' => Auth::user()->id]) }}" class="btn btn-primary m-2 float-end">{{ __('app.templates.my-templates') }}</a>
        </div>
    </div>
    <div class="box box-primary">
        <div class="row justify-content-center my-3 mx-1">
            <div class="col-12">
                <a href="{{ route('admin.templates.create') }}" class="btn btn-success float-end mx-1"><span class="fas fa-plus"></span> Vytvořit šablonu</a>
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
                    <th>{{ __('app.templates.template') }}</th>
                    <th>{{ __('app.author') }}</th>
                    <th>{{ __('app.templates.status') }}</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @if(count($templates) > 0)
                @foreach($templates as $template)
                    <tr>
                        <td><a href="{{ route('admin.templates.edit', ['id' => $template->id]) }}" class="link-primary">{{ $template->name }}</a></td>
                        <td>{{ $template->author->getFullname() }}</td>
                        @if($template->approved)
                            <td><span class="fa fa-circle text-success"></span> {{ __('app.templates.approved') }}</td>
                        @else
                            <td><span class="fa fa-circle text-secondary"></span> {{ __('app.templates.not_approved') }}</td>
                        @endif

                        <td class="text-end">
                            <a href="{{ route('admin.templates.edit', ['id' => $template->id]) }}" class="btn btn-outline-primary btn-rounded" title="Editovat"><i class="fas fa-pen"></i></a>
                            <form class="d-inline" action="{{ route('admin.templates.send-test', ['id' => $template->id]) }}" method="post">
                                @csrf
                                <button type="submit" title="{{ __('app.email.send-test') }}" class="btn btn-outline-info btn-rounded"> <i class="fas fa-envelope"></i></button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.templates.destroy', ['id' => $template->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Odstranit" class="btn btn-outline-danger btn-rounded"> <i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>

            <div class="row justify-content-end">
                <div class="float-right">
                    {!! $templates->appends(\Request::except('page'))->render() !!}
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/initiate-datatables.js') }}"></script>
@endsection
