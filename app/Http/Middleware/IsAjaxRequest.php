<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        abort_if(!$request->ajax(), 404);

        return $next($request);
    }
}
