<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Closure;

class UserActiveMiddleware
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
        if($request->user() && $request->user()->flag_active!='1'){
            return new Response(view('unactivate'));
        }
        return $next($request);
    }
}
