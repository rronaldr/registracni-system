<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function index(): View
    {
        return view('login-picker');
    }
    public function shibbolethLogin(): RedirectResponse
    {
        return redirect('/shibboleth-login');
    }

    public function graduateLogin(): RedirectResponse
    {
        return redirect('/shibboleth-login');
    }

    public function externalLogin(): RedirectResponse
    {
        return redirect('/shibboleth-login');
    }

    public function logout(): RedirectResponse
    {
        return redirect('/shibboleth-logout');
    }
}
