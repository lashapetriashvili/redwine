<?php

namespace Redwine\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redwine\Facades\Redwine;

class RedwineMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guest()) {
            $user = Redwine::model('Redwine\Models\User')->find(Auth::id());
            return $user->hasPermission('browse_admin') ? $next($request) : redirect('/');
        } else {
            if ($request->path() == "redwine/login") {
                return $next($request);
            } elseif ($request->path() == "redwine") {
                return redirect("redwine/login");
            } else {
                return redirect("/");
            }
        }
    }
}
