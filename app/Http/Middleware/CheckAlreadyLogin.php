<?php

namespace App\Http\Middleware;

use Closure;

class CheckAlreadyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles)
    {
        if (is_array($roles)) {
            if (isset($request->user()->active)) {
                if ( $request->user()->active == 1) {
                    return redirect('/dashboard/choose-company');
                }
            }
            return $next($request);
        }
    }
}
