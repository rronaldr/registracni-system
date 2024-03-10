@include('layouts.header', ['title' => 'login redirect'])
<div class="content mt-3">
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    postMessage('login_success', '*')
    let loginWindow = window.open('', '_self')
    loginWindow.close()
</script>

</html>
