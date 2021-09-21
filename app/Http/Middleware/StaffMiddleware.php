<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if (!$this->auth->check() || ($request->user()->user_type != '2')){
            $this->auth->logout();
            return redirect ('/');
        }
        return $next($request);
    }
}
