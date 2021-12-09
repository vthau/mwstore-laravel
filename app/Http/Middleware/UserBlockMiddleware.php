<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class UserBlockMiddleware
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
        if (auth()->check() && (auth()->user()->block >= 5)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            session(['block' => true]);
            return redirect()->route('user.blocked');
        }
        return $next($request);
    }
}
