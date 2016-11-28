<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if(auth()->user()->type !== 'administrator')
        {
            \Session::flash('error', 'Unauthorized Access. You are not authorized to visit the page!!');

            return redirect('dashboard');
        }

        return $next($request);
    }
}
