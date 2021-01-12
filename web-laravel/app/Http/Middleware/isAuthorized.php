<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Check token value in header
        if (isset(getallheaders()['token']) && getallheaders()['token'] == $_ENV['API_TOKEN']) {
            return $next($request);
        } else {
            return response()->json(['ok' => false, 'des' => "Authentication failed"], 401);
        }
    }
}
