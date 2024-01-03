<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
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

    public function alumniLogin(): RedirectResponse
    {
        $clientId = env('ALUMNI_PORTAL_CLIENT_ID');
        $redirectTo = route('login.alumni.process');
        $redirectUrl = sprintf('https://portal.absolventi.vse.cz/portal?client_id=%s&response_type=code&redirect_url=%s', $clientId, $redirectTo);

        return redirect()->away($redirectUrl);
    }

    public function processAlumniLogin(Request $request, UserFacade $userFacade): RedirectResponse
    {
        if ($request->has('result') && $request->has('access_token')) {
            $clientId = env('ALUMNI_PORTAL_CLIENT_ID');
            $url = sprintf('https://portal.absolventi.vse.cz/api/oauth?client_id=%s&access_token=%s', $clientId, $request->get('access_token'));
            $response = Http::get($url);

            if ($response->body()){
                $data = $response->json();
                if (isset($data['user']['id']) && is_array($data) && $data['logged_in']){
                    $user = $userFacade->getOrCreateAlumni(collect($data['user']));

                    Auth::login($user);
                }
            }
        }

        return redirect()->route('events.index');
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

    public function iframeLogin(): View
    {
        return view('auth.iframe-login');
    }
}
