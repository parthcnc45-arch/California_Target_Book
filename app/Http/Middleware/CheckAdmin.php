<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $guard = 'web')
    {
        $user = Auth::guard($guard)->user();
        if (!empty($user) && $user->isAdmin()) {
            return $next($request);
        }

        if ($guard === 'api' || $request->ajax() || $request->wantsJson()) {
	        return response('Unauthorized.', 401);
	    }
        return redirect()->guest('login');
    }
}
