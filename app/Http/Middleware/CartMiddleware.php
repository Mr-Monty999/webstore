<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Route;

class CartMiddleware
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
        $uid = uniqid("cart_");

        if (!Cookie::has("cart_uid")) {
            Cookie::queue("cart_uid", $uid, 99999999, "/");


            // if (!Cart::where("cart_uid", $uid)->exists())
            Cart::create(["cart_uid" => $uid]);
        } else {
            $uid = Cookie::get("cart_uid");

            if (!Cart::where("cart_uid", $uid)->exists()) {
                Cart::create(["cart_uid" => $uid]);
            }
        }

        return $next($request);
    }
}
