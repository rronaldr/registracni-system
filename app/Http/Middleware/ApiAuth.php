<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if ($apiKey === null) {
            return response()->json(['message' => 'No API key provided!'], 401);
        }

        $dbApiKey = DB::table('api_keys')->where('api_key', $apiKey)->first();

        if ($dbApiKey === null) {
            return response()->json(['message' => 'Invalid API key!'], 401);
        }

        return $next($request);
    }
}
