<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ActiveCheck
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
        $active = Auth::user()->active;
        if ($active == 0) {
            Auth::logout();
            return redirect('/not-yet-activated');
        }
        return $next($request);
    }
}
