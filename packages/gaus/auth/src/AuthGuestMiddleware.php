<?php namespace Gaus\Auth;

use Auth;
use Closure;

class AuthGuestMiddleware {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Auth::init();

        return $next($request);
    }

}