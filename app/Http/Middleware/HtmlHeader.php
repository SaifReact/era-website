<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HtmlHeader
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
        $request->headers->set('accept', 'text/html');

        return $next($request);
    }
}
