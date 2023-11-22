<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Session;

class IframeAuth extends Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        redirect()->setIntendedUrl(url($request->getPathInfo()));
        Session::put('iframe', true);

        if (!$request->expectsJson()) {
            return route('iframe.login.index');
        }
    }
}
