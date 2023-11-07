@extends('layouts.admin.main', ['title' => __('app.templates.templates')])

@section('content')
    <div class="box box-primary">
        <div class="row justify-content-center my-3">
            <div class="col-12">
                <span class="float-left">
                    <a href="{{ route('admin.templates.approvals') }}"
                       class="btn btn-primary rounded-0 mx-1 float-right">{{ __('app.templates.for-approval') }}</a>
                    <a href="{{ route('admin.templates.author', ['user' => Auth::user()->id]) }}"
                       class="btn btn-primary rounded-0 mx-1 float-right">{{ __('app.templates.my-templates') }}</a>
                </span>
                <a href="{{ route('admin.templates.create') }}"
                   class="btn btn-outline-success rounded-0 float-right mx-1"><span class="fas fa-plus"></span> Vytvořit
                    šablonu</a>
            </div>
        </div>

        @if(Illuminate\Support\Facades\Session::has('message'))
            <div id="messageAlert" class="alert alert-secondary m-2">
                {{ Illuminate\Support\Facades\Session::get('message') }}
            </div>
        @endif

        <div class="box-body table-responsive">
            <table width="100%" class="table table-hover" id="dataTables">
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
                            <td><a href="{{ route('admin.templates.edit', ['id' => $template->id]) }}"
                                   class="link-primary">{{ $template->name }}</a></td>
                            <td>{{ $template->author->getFullname() }}</td>
                            @if($template->approved)
                                <td><span class="fa fa-circle text-success"></span> {{ __('app.templates.approved') }}
                                </td>
                            @else
                                <td>
                                    <span class="fa fa-circle text-secondary"></span> {{ __('app.templates.not_approved') }}
                                </td>
                            @endif

                            <td class="text-right">
                                <a href="{{ route('admin.templates.edit', ['id' => $template->id]) }}"
                                   class="text-primary px-1" title="Editovat"><i class="fas fa-pen"></i></a>
                                <form class="d-inline"
                                      action="{{ route('admin.templates.send-test', ['id' => $template->id]) }}"
                                      method="post">
                                    @csrf
                                    <button type="submit" title="{{ __('app.email.send-test') }}"
                                            class="btn-link border-0 text-info px-1"><i class="fas fa-envelope"></i>
                                    </button>
                                </form>
                                <form class="d-inline"
                                      action="{{ route('admin.templates.destroy', ['id' => $template->id]) }}"
                                      method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Odstranit"
                                            class="btn-link border-0 text-danger px-1 mx-1"><i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>

            {{ $templates->links() }}

        </div>
    </div>
@endsection
