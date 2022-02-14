<?php

namespace App\Http\Middleware;

use Closure;

class Customer
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
        if (auth()->user()->type == "customer"){
            return $next($request);
        }else{
            return redirect()->route('login')->with(['message'=>'Please LogIn First...!!']);
        }
    }
}
