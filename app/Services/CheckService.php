<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class CheckService
{
    public static function checkCartAndGetId()
    {
        $cart_id = uniqid('cart_');

        if (!Cookie::has('cart_id')) {
            Cookie::queue('cart_id', $cart_id, 99999999, '/');
            Cart::create(['id' => $cart_id]);
        } else {
            $cart_id = Cookie::get('cart_id');
            Cart::firstOrCreate(['id' => $cart_id]);
        }

        return $cart_id;
    }
}
