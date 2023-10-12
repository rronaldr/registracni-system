@extends('layouts.admin.main', ['title' => __('app.templates.for-approval')])

@section('content')
    <div class="box box-primary">
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
                @foreach($templates as $template)
                    <tr>
                        <td><a href="{{ route('admin.templates.edit', ['id' => $template->id]) }}" class="link-primary">{{ $template->name }}</a></td>
                        <td>{{ $template->author->getFullname() }}</td>
                        @if($template->approved)
                            <td><span class="fa fa-circle text-success"></span> {{ __('app.templates.approved') }}</td>
                        @else
                            <td><span class="fa fa-circle text-secondary"></span> {{ __('app.templates.not_approved') }}</td>
                        @endif

                        <td class="text-right">
                            <form class="d-inline" action="{{ route('admin.templates.send-test', ['id' => $template->id]) }}" method="post">
                                @csrf
                                <button type="submit" title="{{ __('app.email.send-test') }}" class="btn-link border-0 mx-1"> <i class="fas fa-envelope"></i></button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.templates.approve', ['id' => $template->id]) }}" method="post">
                                @csrf
                                <button type="submit" title="{{ __('app.templates.approve-template') }}" class="btn-link border-0 mx-1"> <i class="fas fa-check-circle"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/initiate-datatables.js') }}"></script>
@endsection
