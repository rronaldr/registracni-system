<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

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
        dd($request->getPathInfo());
        if (!$request->expectsJson()) {
            return route('iframe.login');
        }
    }
}
