<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function index(): View
    {
        return view('auth.login');
    }

    public function shibbolethLogin(): RedirectResponse
    {
        return redirect('/shibboleth-login');
    }

    public function graduateLogin(): RedirectResponse
    {
        return redirect('/shibboleth-login');
    }

    function login(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();

            return redirect()->route('events.index');
        }

        return back()->withErrors('email', __('app.auth.login-error'));
    }

    public function logoutExternal(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('events.index');
    }

    public function logout(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::check() ? Auth::user() : null;

        if (!isset($user->xname) && !isset($user->absolvent_id)) {
            return redirect()->route('logout.external');
        }

        if ($user === null) {
            return redirect()->route('events.index');
        }

        return redirect('/shibboleth-logout');
    }
}
