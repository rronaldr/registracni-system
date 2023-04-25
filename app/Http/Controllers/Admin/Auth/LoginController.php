<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('admin.auth.login');
    }

    function login(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);

        if(auth()->attempt($request->only('email', 'password'), $request->remember)){
            $request->session()->regenerate();

            return redirect()->route('admin.events');
        }

        return back()->withErrors('email', 'Invalid login credentials.');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('admin.login');
    }


}
