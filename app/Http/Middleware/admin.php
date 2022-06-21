<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class admin
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
        if (!Auth::guard("admin")->check() && Route::currentRouteName() != "dashboard.login")
            return redirect()->route("dashboard.login");

        if (Auth::guard("admin")->check() && Route::currentRouteName() == "dashboard.login")
            return redirect()->route("dashboard.index");


        return $next($request);
    }
}
