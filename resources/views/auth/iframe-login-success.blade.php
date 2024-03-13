@include('layouts.header', ['title' => 'login redirect'])
<div class="content mt-3">
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    window.opener.postMessage('loginSuccess');
    window.close()
</script>

</html>
