<?php

namespace App\Http\Middleware;

use Closure;

class Vendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request,  Closure $next)
    {


        // dd(auth()->user()->type == "vendor");
        if (auth()->user()->type == "vendor"){
            return $next($request);
        }else{
            return redirect()->route('login');
        }

    }
}
