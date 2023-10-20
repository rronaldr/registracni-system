<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;


class UserController extends Controller
{

    public function changePassword(): view
    {
        return view('auth.change-password');
    }

    public function storeChangedPassword(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->withErrors(['old_password' => __('app.auth.password-change-error')]);
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Session::flash('message', __('app.auth.password-changed-success'));

        return redirect()->route('events.index');
    }
}