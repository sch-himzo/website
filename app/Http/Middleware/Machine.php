<?php

namespace App\Http\Middleware;

use Closure;

class Machine
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
        if($request->input('machine_key')!=env('MACHINE_KEY')){
            abort(401);
        }

        return $next($request);
    }
}
