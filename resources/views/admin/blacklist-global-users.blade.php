@extends('layouts.admin.main', ['title' => __('app.blacklist.global-blacklist'), 'vue' => true])

@section('content')
    <div class="box-body table-responsive">
        <table width="100%" class="table table-hover">
            <thead>
            <tr>
                <th>{{ __('app.user.xname') }}</th>
                <th>{{ __('app.user.name') }}</th>
            </tr>
            </thead>

            <tbody>
            @if($users->isNotEmpty())
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->xname }}
                        </td>
                        <td>{{ $user->display_name ?? sprintf('%s %s', $user->first_name, $user->last_name) }}</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="2">Empty</td>
                </tr>
            @endif
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
