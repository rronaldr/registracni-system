@extends('layouts.admin.main', ['title' => __('app.blacklist.global-blacklist'), 'vue' => true])

@section('content')
    <div class="row ">
        <div class="col-lg-9">
            <blacklist-page :blacklist-id="{{ $blacklist->id}}">
                <template v-slot:csrf>
                    {{ csrf_field() }}
                </template>
            </blacklist-page>

            <!-- Custom blacklist modal start -->
            <div class="modal fade" id="infoModal" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Jak přidat uživatele na blacklist?</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p>
                                {!! __('app.blacklist.user-hint') !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Custom blacklist modal end -->

        </div>
    </div>
@endsection
