<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;

class LoginController extends Controller
{

    public function shibbolethLogin(): RedirectResponse
    {
        return redirect('/shibboleth-login');
    }

    public function logout(): RedirectResponse
    {
        return redirect('/shibboleth-logout');
    }

    public function absolventLogin(): RedirectResponse
    {

    }

    public function externalLogin(): RedirectResponse
    {

    }
}
