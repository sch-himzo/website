<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Activate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check()) {
            return $next($request);
        }

        if(!Auth::user()->activated && Auth::user()->internal_id==null) {
            return redirect()->route('activate');
        }

        return $next($request);
    }
}
