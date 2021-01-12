<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminAuthenticated
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
        if (auth::user()->role_id == 1){
            return redirect('/my_account')->with('message',"You are not allowed");
        }
        return $next($request);
    }
}
