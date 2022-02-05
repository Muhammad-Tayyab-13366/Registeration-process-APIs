<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class EmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $currentroute = request()->segment(1);
       //dd(is_null(auth()->user()->registered_at));
        if (((is_null(auth()->user()->registered_at)) == true) && ($currentroute != 'email_verification'))
        {
             return redirect('/email_verification');
        }
        else if(((is_null(auth()->user()->registered_at)) == true) &&  ($currentroute == 'email_verification'))
        { 
            return $next($request);
        }
        else if(((is_null(auth()->user()->registered_at)) == false)  &&  $currentroute == 'email_verification')
        return redirect('/home');
        else
        return $next($request);
    }
}
