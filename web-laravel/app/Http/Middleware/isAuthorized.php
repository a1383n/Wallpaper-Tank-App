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
        //Check is request from AJAX
        if ($request->ajax()) {
            return $next($request);
        } //Check token value in header
        else if (isset(getallheaders()['Authorization']) && getallheaders()['Authorization'] == $_ENV['API_TOKEN']) {
            return $next($request);
        } else {
            return response()->json(['ok' => false, 'des' => "Authentication failed"], 401);
        }
    }
}
