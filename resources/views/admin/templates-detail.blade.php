@extends('layouts.admin.main', ['title' => $template->name])

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="name" class="form-label">Název šablony</label>
                            {{ $template->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="name" class="form-label">{{ __('app.author') }}</label>
                            {{ $template->author->getFullname() }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="name" class="form-label">{{ __('app.merge-tags') }}</label>
                            {{ implode(',', $template->getParams()->toArray()) }}
                        </div>
                    </div>

                    <div class="row d-inline mb-3">
                        <form class="form-group" action="{{ route('admin.templates.send-test') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $template->id }}">
                            <input type="email" class="form-control w-25" name="email" placeholder="{{ __('app.email.your-email') }}">
                            <button type="submit" title="{{ __('app.email.send-test') }}" class="btn btn-info">
                                <i class="fas fa-envelope"></i>
                                {{ __('app.email.send-test') }}
                            </button>
                        </form>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            {{ __('app.templates.show-content')  }}
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <pre><code>{{ $template->html }}</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="line"></div><br>
                    <div class="mb-3 row">
                        <div class="col-sm-4">
                            <a href="{{ route('admin.templates') }}" class="btn btn-danger mb-2"><i class="fas fa-times"></i>
                                {{ __('app.back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
