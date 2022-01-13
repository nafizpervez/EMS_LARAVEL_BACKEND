<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FileUpdate
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
        $request->setMethod('PUT');
        return $next($request);
    }
}
