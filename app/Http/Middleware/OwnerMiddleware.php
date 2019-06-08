<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Closure;

class OwnerMiddleware
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
        if($request->user() && $request->user()->role!='owner'){
            return new Response(view('unauthorized')->with('role','owner'));
        }
        return $next($request);
    }
}
