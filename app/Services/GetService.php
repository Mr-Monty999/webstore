<?php

namespace App\Services;

use App\Models\Cart;

trait GetService
{

    public static function getCartProducts($cartId)
    {

        return Cart::with('products')
            ->where('cart_uid', $cartId)
            ->first()->products;
    }
}
