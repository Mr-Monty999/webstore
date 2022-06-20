<?php

namespace App\Http\Middleware;

use App\Models\Vistor;
use Closure;
use Illuminate\Http\Request;

class vistors
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

        $vistor = Vistor::where("ip", $request->ip());
        if ($vistor->exists()) {

            $vistor = $vistor->first();
            $vistor->hits += 1;
            $vistor->save();
        } else {
            Vistor::create([
                "ip" => $request->ip(),
                "hits" => 1,
                "user_agent" => $request->userAgent(),
            ]);
        }


        return $next($request);
    }
}
