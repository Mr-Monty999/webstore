<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

trait CheckService
{
    public static function checkCartAndGetId()
    {
        $uid = uniqid('cart_');

        if (!Cookie::has('cart_uid')) {
            Cookie::queue('cart_uid', $uid, 99999999, '/');
            Cart::create(['id' => $uid]);
        } else {
            $uid = Cookie::get('cart_uid');

            Cart::firstOrCreate(['id' => $uid]);
        }

        return $uid;
    }
}
