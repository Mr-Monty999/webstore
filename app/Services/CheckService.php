<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

class CheckService
{
    public static function cartChecker()
    {
        $uid = uniqid('cart_');


        if (!Cookie::has('cart_uid')) {
            Cookie::queue('cart_uid', $uid, 99999999, '/');

            // if (!Cart::where("cart_uid", $uid)->exists())
            Cart::create(['cart_uid' => $uid]);
        } else {
            $uid = Cookie::get('cart_uid');

            if (!Cart::where('cart_uid', $uid)->exists()) {
                Cart::create(['cart_uid' => $uid]);
            }
        }
    }
}
