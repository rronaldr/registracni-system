@include('layouts.header', ['title' => __('app.date.dates')])
@include('layouts.iframe.navbar')

<div class="content mt-3" id="vueApp">
    @if(Illuminate\Support\Facades\Session::has('message'))
        <div id="messageAlert" class="alert alert-secondary m-2">
            {{ Illuminate\Support\Facades\Session::get('message') }}
        </div>
    @endif

    <event-iframe :event="{{ $event }}" :has-user="{{ (int) auth()->check() }}"></event-iframe>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    document.getElementById('iframeLoginLink').addEventListener('click',function(e){
        e.preventDefault();
        e.stopPropagation();

        window.open('/external/auth/login','_blank','width=800,height=600,status=0,toolbar=0');
    });
</script>

</html>
