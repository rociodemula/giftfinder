<?php

namespace Giftfinder\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminControl
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->user()->tipo != 'admin'){
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
