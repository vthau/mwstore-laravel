<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;

class VisitorMiddleware
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
        Visitor::visitor();
        return $next($request);
    }
}
