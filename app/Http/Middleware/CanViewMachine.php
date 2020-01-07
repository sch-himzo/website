<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Machine;

class CanViewMachine
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
        $machine = Machine::all()->find(Setting::where('name','current_machine')->first()->setting);

        if(!Auth::check() || Auth::user()->role_id<$machine->viewable_by) {
            abort(401);
        }

        return $next($request);
    }
}
