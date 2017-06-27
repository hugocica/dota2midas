<?php

namespace App\Http\Middleware;

use Closure;

class CheckPlayerItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $id)
    {
        dd($id);
        if ($request) {
            return redirect()->guest('/');
        }
        return $next($request);
    }
}
