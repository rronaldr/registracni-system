<footer class="bg-footer-dark text-white py-2 py-lg-4" id="calendar-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-8 order-xxl-2 mb-2">
                <ul class="nav nav-footer d-block d-sm-flex justify-content-center justify-content-xxl-end">
                    <li class="nav-item">
                        <a class="nav-link" href="/user/consent">Podmínky používání</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('app.auth.login') }}</a>
                    </li>
                    @endguest
                </ul>
            </div>
            <div class="col-xxl-4 order-xxl-1 small text-muted text-sm-center text-xxl-left">
                <p>Copyright © 2023 Vysoká škola ekonomická v Praze</p>
            </div>
        </div>
    </div>
</footer>